<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Last Supporter | Card Flip</title>

    <link href="{{ asset('assets/img/omg.png') }}" rel="icon" type="image/x-icon">
    <link href="{{ asset('template/vendor/bootstrap-5/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template/vendor/animate.css/css/animate.min.css') }}" rel="stylesheet">
    <style>
        :root {
            --color-card: #6103D0;  
            --color-card-back: #D0EE26;
            --color-text-card: #ebebeb;
            --color-text-back: #2d2d39;
            --box-width: 520px;
            --box-margin: auto;
            --flip-transform: rotateX(180deg);
            --font-family: "Ubuntu", "Montserrat", sans-serif;
        }

        body {
            width: var(--box-width);
            margin: var(--box-margin);
        }

        /* .box {
            max-width: var(--box-width);
            margin: var(--box-margin);
            font-family: var(--font-family);
        } */
        
        .bg-color-card {
            background: var(--color-card);
            color: var(--color-text-card);
            border: 1px solid var(--color-card);
        }
        
        .bg-color-card-back {
            background: var(--color-card-back);
            color: var(--color-text-back);
            border: 1px solid var(--color-card-back);
        }

        /* .message:before,
        .message:after {
            content: "\2014\00A0";
        } */

        .avatar-50 {
            height: 50px;
            width: 50px;
            line-height: 25px;
        }

        .avatar {
            position: relative;
        }

        .scene, 
        .box {
            /* width: 520px; */
            /* height: 260px; */
            /* border: 1px solid #CCC; */
            max-width: var(--box-width);
            height: 160px;
            margin: var(--box-margin);
            font-family: var(--font-family);
            margin: 40px 0;
            perspective: 600px;
        }

        .card-flip {
            width: 100%;
            height: 100%;
            transition: transform 1s;
            transform-style: preserve-3d;
            cursor: pointer;
            position: relative;
        }

        .card-face {
            position: absolute;
            width: 100%;
            height: 100%;
            /* line-height: 260px; */
            /* color: white; */
            /* text-align: center; */
            /* font-weight: bold; */
            /* font-size: 40px; */
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
        }

        .card-face-front {
            /* background: var(--color-card); */
        }

        .card-face-back {
            /* background: var(--color-card-back); */
            transform: var(--flip-transform);
        }

        .card-flip.is-flipped {
            transform: var(--flip-transform);
        }

        .message:before,
        .message:after {
            content: "\2014\00A0";
        }

    </style>
</head>
<body>
    <div class="box box--card-flip m-3" id="widget-container"></div>
    
    <!-- Scripts -->
    <script src="{{ asset('template/vendor/jquery/js/jquery.min.js') }}"></script>
    @if (!isset($qParams['iframe'])) <script src="{{ asset('js/echo.js') }}"></script> @endif
    <script src="{{ asset('template/vendor/bootstrap-5/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('template/vendor/webfont/js/webfont.min.js') }}"></script>
    <script src="{{ asset('assets/js/omg-widget.js') }}"></script>
    <script src="{{ asset('assets/js/utils.js') }}"></script>
    <script type="text/javascript">
        /**
        * Overlay scripts
        * Version: 1.0
        */
        (function ($) {
            "use strict";

            let payloadsData = {};
            let hasRender = false;
            let flipInterval = null;

            $(() => {
                if (qParams.has('iframe')) {
                    regCallbackInterval({
                        "getSupportMessageType": getSupportMessageType,
                        "setFlipType": setFlipType,
                    });
                }

                init();
                if (!qParams.has('iframe')) {
                    Echo.channel("stream.new_tip.{{ $streamKey }}")
                        .notification((data) => {
                            // console.log(data);
                            const { type, payloads } = data;

                            if (type == 'notify.new_tip') {
                                if (hasRender && !payloads.test) {
                                    renderWidgetContent(payloads.new_tip);
                                }
                            }
                    });

                    Echo.connector.pusher.connection.bind("state_change", function (states) {
                        console.log(`Socket is ${states.current}`);
                    });
                }
            });

            const init = async () => {
                setHTML('widget-container', renderLoader());
                setStyle('--animate-duration', '500ms');

                // Check if in iframe / preview
                if (qParams.get('iframe')) {
                    setStyle('--box-width', '100%');
                } else {
                    setStyle('--box-margin', 'initial');
                }
                
                // Set font
                const font = qParams.has('lst_font') ? qParams.get('lst_font') : "Ubuntu"; 
                setFont(font);

                // Color card body
                const colorCard = qParams.get('lst_t3_color_1'); 
                if (colorCard) {
                    setStyle('--color-card', colorCard);
                }

                // Color card back
                const colorCardBack = qParams.get('lst_t3_color_2');
                if (colorCardBack) {
                    setStyle('--color-card-back', colorCardBack);
                }

                // Color card text
                const colorCardText = qParams.get('lst_t3_color_3');
                if (colorCardText) {
                    setStyle('--color-text-card', colorCardText);
                }

                // Color footer text
                const colorCardBackText = qParams.get('lst_t3_color_4');
                if (colorCardBackText) {
                    setStyle('--color-text-back', colorCardBackText);
                }

                // Setup html
                let widgetParams = {
                    showMessage: qParams.get('lst_support_message'),
                    setAsMarquee: qParams.get('lst_marquee')
                }

                // Get data from BE
                const response = await fetchData();
                if (response) {
                    let { payloads } = await response.data.result;
                    
                    payloads = {
                        ...widgetParams,
                        ...payloads.new_tip
                    };

                    // console.log(payloads);
                    setHTML('widget-container', renderWidget(payloads));
                    if (qParams.get('iframe')) {
                        getElementById('text-flip-info').removeAttribute('hidden');
                    } else {
                        getElementById('text-flip-info').setAttribute('hidden', '');
                    }

                    // Flip transform
                    const flipType = qParams.get('lst_flip_type');
                    if (flipType) {
                        setFlipType(flipType);
                    }

                    return true;
                }

                setHTML('text-render', 'Failed to render');
            }

            const fetchData = async () => {
                @php
                    $params = array_merge([
                        'key' => $key, 
                        'streamKey' => $streamKey, 
                        'fetch_only' => 1, 
                    ], $qParams);
                @endphp

                const url = "{!! route('api.widget.overlay.show', $params) !!}";
                const options = {
                    method: "GET",
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                }

                const response = await fetch(url, options)
                    .then(response => {
                        if (!response.ok) throw new Error(response.statusText);

                        return response.json();
                    })
                    .catch(error => {
                        console.log(`Request failed: ${error}`);

                        return false;
                });

                return response;
            }

            const renderWidget = (payloads = {}) => {
                payloadsData = payloads;

                let setAsMarquee = payloads.setAsMarquee;
                let supportMessage = getSupportMessageType();
                if (setAsMarquee == '1') {
                    supportMessage = getSupportMessageType('marquee');;
                }

                hasRender = true;
                return `
                    <strong class="fst-italic" id="text-flip-info">* Click card to flip.</strong>
                    <div class="card-flip" onclick="this.classList.toggle('is-flipped');">
                        <div class="card-face card-face-front">
                            <div class="card bg-color-card shadow card-border h-100 animate__animated animate__fadeIn">
                                <div class="card-body p-3 overflow-hidden">
                                    <div>
                                        <img class="img-fluid rounded-circle avatar avatar-50 job-icon mb-2 d-inline-block" id="supporter_avatar" src="${payloads.avatar ?? "{{ asset('template/images/user/user.png') }}"}" alt="">
                                    </div>
                                    <h5 id="supporter_name">${splitLongText((escape(payloads.name) || 'Someone'), 25, 20)}</h5>
                                    <small class="text-nowrap me-3">Memberikan dukungan sebesar <strong id="support">${payloads.formated_amount || 'Rp0'}</strong></small>
                                </div>
                            </div>
                        </div>
                        <div class="card-face card-face-back">
                            <div class="card card bg-color-card-back shadow card-border h-100 p-0 animate__animated animate__fadeIn">
                                <div class="card-body text-center p-3">
                                    <div>
                                        <img class="img-fluid rounded-circle avatar avatar-50 job-icon mb-2 d-inline-block" id="supporter_avatar_back" src="{{ asset('template/images/omg.png') }}" alt="">
                                    </div>
                                    <div id="support_message_div" class="overflow-hidden  ${setAsMarquee == '1' ? 'pb-0 pt-1' : '' }">
                                        ${supportMessage}
                                    </div>
                                    <small>&nbsp;</small>
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
                    // getElementById('supporter_avatar_back').src = payloads.avatar;
                } else {
                    getElementById('supporter_avatar').src = "{{ asset('template/images/user/user.png') }}";
                }

                const card = document.querySelector('.card-flip');
                card.classList.toggle('is-flipped');
            }

            const renderLoader = () => {
                return `
                    <div class="card-flip">
                        <div class="card-face card-face-front">
                            <div class="card bg-color-card shadow h-100 card-border p-0 animate__animated animate__fadeIn">
                                <div class="card-body ">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 ">
                                            <h5 class="mb-1 text-center"><strong id="text-render">Rendering...</strong></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }

            const getSupportMessageType = (type = 'text') => {
                let payloads = payloadsData;
                let supportMessage = `<h5 class="message fst-italic text-nowrap" id="supporter_message"> ${splitLongText((escape(payloads.message) || 'Example Message'), 40, 35)} </h5>`;
                if (type == 'marquee') {
                    supportMessage = `<marquee class="p-0" behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();">
                                        <h5 class="message fst-italic text-nowrap" id="supporter_message"> ${splitLongText((escape(payloads.message) || 'Example Message'), 40, 35)} </h5>
                                    </marquee>`;
                }

                return supportMessage;
            }
            
            const setFlipType = (flip = 'horizontal', force = false) => {
                setStyle('--flip-transform', flip == 'horizontal' ? 'rotateX(180deg)' : 'rotateY(180deg)');
                runCardFlip(force);
            }

            const runCardFlip = (force = false) => {
                const card = document.querySelector('.card-flip');

                if (force) {
                    card.classList.toggle('is-flipped');
                    return;
                }

                if (flipInterval != null) {
                    clearInterval(flipInterval);
                    flipInterval = null;
                }

                flipInterval = setInterval(() => {
                    card.classList.toggle('is-flipped');
                }, 10 * 1000);   // 10 Seconds
            }

        })(jQuery);
    </script>

</body>
</html>
