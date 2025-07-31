<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Media Share | Default</title>

    <link href="{{ asset('assets/img/omg.png') }}" rel="icon" type="image/x-icon">
    <link href="{{ asset('template/vendor/bootstrap-5/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template/vendor/animate.css/css/animate.min.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/js/utils.js') }}"></script>
    <style>
        :root {
            --color-card: #2d2d39;  
            --color-card-footer: #ebebeb;
            --color-text-card: #d2d5d8;
            --color-text-footer: #6103D0;
            --color-progress: #F22635;
            --box-width: 590px;
            --box-margin: auto;
            --font-family: "Ubuntu", "Montserrat", sans-serif;
        }

        body {
            width: var(--box-width);
            margin: var(--box-margin);
        }

        .box {
            max-width: var(--box-width);
            margin: var(--box-margin);
            font-family: var(--font-family);
        }
        
        .bg-color-card {
            background: var(--color-card);
            color: var(--color-text-card);
        }
        
        .bg-color-footer {
            background: var(--color-card-footer);
            color: var(--color-text-footer);
        }

        .color-progress {
            background: var(--color-progress);
        }

        .color-progress-border {
            border: 1px solid var(--color-progress);
        }

        .message:before,
        .message:after {
            content: "\2014\00A0";
        }

        .avatar-80 {
            height: 60px;
            width: 60px;
            line-height: 60px;
        }

    </style>
</head>
<body>
    <div class="box m-3" id="widget-container" style="display: none;"></div>

    <!-- Scripts -->
    <script src="{{ asset('template/vendor/jquery/js/jquery.min.js') }}"></script>
    @if (!isset($qParams['iframe'])) <script src="{{ asset('js/echo.js') }}"></script> @endif
    <script src="{{ asset('template/vendor/bootstrap-5/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('template/vendor/webfont/js/webfont.min.js') }}"></script>
    <script src="{{ asset('assets/js/omg-widget.js') }}"></script>

    <script type="text/javascript">

        let payloadsData = {};
        let hasRender = false;

        $(() => {
            if (qParams.has('iframe')) {
                regCallbackInterval();
            }

            init();
            if (!qParams.has('iframe')) {
                Echo.channel("stream.new_tip.{{ $streamKey }}")
                    .notification((data) => {
                        // console.log(data);
                        const { type, payloads } = data;

                        if (type == 'notify.new_tip') {
                            const { new_tip, media_share = null, test, notify_type } = payloads;

                            if (new_tip && media_share) {
                                // console.log("push new tip!");
                                new_tip.test = test;

                                if (test && notify_type == 'mediashare') {
                                    loadTestVideo(new_tip, media_share);
                                    return;
                                }

                                if (!test && notify_type == 'notification') {
                                    videoQueue.push({
                                        new_tip,
                                        media_share,
                                    });

                                    setTimeout(() => {
                                        loadVideo();
                                    }, 300);
                                }
                            }
                        }
                });

                Echo.connector.pusher.connection.bind("state_change", function (states) {
                    console.log(`Socket is ${states.current}`);
                });
            }

            setInterval(() => {
                loadVideo();
            }, 3 * 60 * 1000);  // 3 Minutes
        });

        const init = async () => {
            setHTML('widget-container', renderLoader());
            setStyle('--animate-duration', '500ms');

            // Check if in iframe / preview
            if (qParams.get('iframe')) {
                setStyle('--box-width', '100%');
                $('#widget-container').show();
            } else {
                $('#widget-container').hide();
                setStyle('--box-margin', 'initial');
            }
            
            // Set font
            const font = qParams.has('mds_font') ? qParams.get('mds_font') : "Ubuntu"; 
            setFont(font);

            // Color card body
            const colorCard = qParams.get('mds_t1_color_1'); 
            if (colorCard) {
                setStyle('--color-card', colorCard);
            }

            // Color card footer
            const colorCardFooter = qParams.get('mds_t1_color_2');
            if (colorCardFooter) {
                setStyle('--color-card-footer', colorCardFooter);
            }

            // Color footer text
            const colorFooterText = qParams.get('mds_t1_color_3');
            if (colorFooterText) {
                setStyle('--color-text-footer', colorFooterText);
            }

            // Color footer progress
            const colorprogress = qParams.get('mds_t1_color_4')
            if (colorprogress) {
                setStyle('--color-progress', colorprogress);
            }

            // Setup html
            let widgetParams = {
                isIframe: qParams.get('iframe'),
                showFooter: qParams.get('mds_show_footer'),
                showMessage: qParams.get('mds_show_support_message'),
                templateText: qParams.get('mds_template_text'),
            }

            setHTML('widget-container', renderWidget(widgetParams));
        }

        const renderWidget = (payloads = {}) => {
            return `
                <div class="d-flex justify-content-center" ${payloads.isIframe != '1' ? 'hidden' : ''}>
                    <div class="card w-100 border-0 rounded-3 box-corner bg-color-card shadow-sm animate__animated animate__fadeIn">
                        <div class="card-body ps-1 pe-1 pt-2 pb-2">
                            <div class="position-relative align-items-center">
                                <div class=" ratio ratio-16x9" id="player"></div>
                                <div class="progress color-progress-border ms-3 me-3" style="height:75%;" id="show_progress" hidden>
                                    <div class="progress-bar color-progress" role="progressbar" style="height:2px; width: 10%;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="footer_div" class="card-footer bg-color-footer overflow-hidden ps-2 pe-2" ${payloads.showFooter != '1' ? 'hidden' : ''}>
                            <div class="d-flex align-items-center mb-2">
                                <div class="flex-grow-1 ms-3 mt-2">
                                    <h5 class="mb-1">OMG...!! <strong id="supporter_name">${splitLongText((escape(payloads.name) || 'Someone'), 25, 20)}</strong></h5>
                                    <p class="m-0"><span id="template_text"> ${escape(payloads.templateText)} </span> <strong id="support">${payloads.formated_amount || 'Rp0'}</strong></p>
                                </div>
                                <div class="flex-shrink-0 me-3">
                                    <img class="img-fluid rounded-circle avatar-80" id="supporter_avatar" src="${payloads.avatar ?? "{{ asset('template/images/user/user.png') }}"}" alt="">
                                </div>
                            </div>
                            <div id="support_message_div" ${payloads.showMessage != '1' ? 'hidden' : ''}>
                                <hr class="mt-0 mb-2 ms-3 me-3 ">
                                <marquee class="p-0" behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();">
                                    <span class="message fst-italic text-nowrap" id="supporter_message"> Example Message </span>
                                </marquee>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        const renderWidgetContent = (payloads) => {
            setHTML('supporter_name', splitLongText((escape(payloads.name) || 'Someone'), 25, 20));
            setHTML('support', payloads.formated_amount || 'Rp0');
            setHTML('supporter_message', splitLongText((escape(payloads.message) || 'Example Message'), 40, 35));
            if (payloads.avatar) {
                getElementById('supporter_avatar').src = payloads.avatar;
            } else {
                getElementById('supporter_avatar').src = "{{ asset('template/images/user/user.png') }}";
            }
        }

        const renderLoader = () => {
            return `
                <div class="d-flex justify-content-center">
                    <div class="card w-100 rounded-3 bg-color-card shadow-sm animate__animated animate__fadeIn">
                        <div class="card-body p-2">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 ms-3 mt-2 mb-2">
                                    <h5 class="mb-1 text-center"><strong id="text-render">Rendering...</strong></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

    </script>

    <script type="text/javascript">
        let videoQueue = [];

        let ytAPI = "https://www.youtube.com/iframe_api";
        let tag = document.createElement('script');
        tag.src = ytAPI;
        
        let firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

        // The youtube player instance
        let player;

        function onYouTubeIframeAPIReady() {
            let options = {
                // height: '290',
                // width: '540',
                videoId: qParams.has('iframe') ? 'T7lnaDyJTs0' : '',
                playerVars: { 'autoplay': qParams.has('iframe') ? 0 : 1, 'controls': qParams.has('iframe') ? 1 : 0, 'mute': 1 },
                events: {
                    'onReady': onPlayerReady,
                    'onStateChange': onPlayerStateChange
                }
            }

            player = new YT.Player('player', options);
        }

        function onPlayerReady(event) {
            // loadVideo();
        }
        
        function onPlayerStateChange(event) {
            if (event.data == YT.PlayerState.PLAYING || event.data == YT.PlayerState.PAUSED) {
                $('#widget-container').show();
            }else {
                if (!qParams.get('iframe')) {
                    $('#widget-container').hide();
                }
            }

            if (event.data == YT.PlayerState.PAUSED) {
                setTimeout(() => {
                    stopVideo();
                }, 3 * 1000);   // 3 Seconds
            }
        }

        function stopVideo() {
            player.stopVideo();
        }

        function playVideo() {
            player.playVideo();
        }

        function loadVideo() {
            if (videoQueue.length > 0 && player.getPlayerState() != YT.PlayerState.PLAYING) {
                let { media_share, new_tip } = videoQueue[0];

                renderWidgetContent(new_tip);
                player.loadVideoById(media_share);

                videoQueue.shift();
            }
        }

        function loadTestVideo(new_tip, media_share) {
            stopVideo();
            renderWidgetContent(new_tip);
            player.loadVideoById(media_share);
        }

    </script>

</body>
</html>
