<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Last Supporter | Default</title>

    <link href="{{ asset('assets/img/omg.png') }}" rel="icon" type="image/x-icon">
    <link href="{{ asset('template/vendor/bootstrap-5/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template/vendor/animate.css/css/animate.min.css') }}" rel="stylesheet">
    <style>
        /* :root {
            --color-card:linear-gradient(180deg, #FFFFFF 0%, rgba(255, 255, 255, 0.4) 25.38%, rgba(254, 254, 254, 0.590518) 80.82%, rgba(252, 252, 252, 0.816404) 99.99%, #FFFFFF 100%);;  
            --color-card-footer: #c1c6cc;
            --color-card-border: #ebebeb;
            --color-text-card: #d2d5d8;
            --color-text-footer: #2d2d39;
            --box-width: 520px;
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

        .color-card-border {
            /* border: 2px solid; */
        /* border-color: var(--color-card-border)!important;
        }

        .avatar-80 {
            height: 60px;
            width: 60px;
            line-height: 60px;
        }

        .box-corner:before,
        .box-corner:after {
            content: "";
            position: absolute;
            left: 0; 
            right: 0;
            bottom: 100%;
            margin-left:-1px;
            margin-right:-1px;
            border-bottom: 8px solid var(--color-card-border);
            border-left: 16px solid transparent;
            border-right: 16px solid transparent;
        } */

        /* .box-corner:before{
            border-left: 15px solid var(--color-card-border);
        }

        .box-corner:after{
            border-right: 15px solid var(--color-card-border);
        } */

        /* .box-corner:after {
            bottom: auto;
            top: 100%;
            border-bottom: none;
            border-top: 8px solid var(--color-card-border);
        }

        .message:before,
        .message:after {
            content: "\2014\00A0";
        } */

        :root {
            --color-card: #6103D0;  
            --color-card-footer: #ebebeb;
            --color-card-border: #ebebeb;
            --color-text-card: #ebebeb;
            --color-text-footer: #2d2d39;
            --box-width: 520px;
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

        .card {
            background-color: #ffff;
            border-radius: 12px;
        }

        .bg-color-card {
            background: var(--color-card);
            color: var(--color-text-card);
        }

        .footer {
            background-color: #ffff;
        }

        .card-footer {
            border-radius: 0px 0px 10px 10px !important;
        }

        marquee.card-footer {
           border: 0 !important;
           background: transparent !important;
        }

        .bg-color-footer {
            background: var(--color-card-footer);
            /* color: var(--color-text-footer); */
        }

        .message {
            color: var(--color-text-footer);
        }

        .message:before,
        .message:after {
            content: "\2014\00A0";
        }
    </style>
</head>

<body>
    <div class="box mt-3 m-3" id="widget-container"></div>

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

            $(() => {
                if (qParams.has('iframe')) {
                    regCallbackInterval({
                        "getSupportMessageType": getSupportMessageType,
                    });
                }

                init();
                if (!qParams.has('iframe')) {
                    Echo.channel("stream.new_tip.{{ $streamKey }}")
                        .notification((data) => {
                            // console.log(data);
                            const {
                                type,
                                payloads
                            } = data;

                            if (type == 'notify.new_tip') {
                                if (hasRender && !payloads.test) {
                                    renderWidgetContent(payloads.new_tip);
                                }
                            }
                        });

                    Echo.connector.pusher.connection.bind("state_change", function(states) {
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
                const colorCard = qParams.get('lst_t1_color_1');
                if (colorCard) {
                    setStyle('--color-card', colorCard);
                }

                // Color card footer
                const colorCardFooter = qParams.get('lst_t1_color_2');
                if (colorCardFooter) {
                    setStyle('--color-card-footer', colorCardFooter);
                }

                // Color card text
                const colorCardText = qParams.get('lst_t1_color_3');
                if (colorCardText) {
                    setStyle('--color-text-card', colorCardText);
                }

                // Color footer text
                const colorFooterText = qParams.get('lst_t1_color_4');
                if (colorFooterText) {
                    setStyle('--color-text-footer', colorFooterText);
                }

                // Setup html
                let widgetParams = {
                    showMessage: qParams.get('lst_support_message'),
                    setAsMarquee: qParams.get('lst_marquee')
                }

                // Get data from BE
                const response = await fetchData();
                if (response) {
                    let {
                        payloads
                    } = await response.data.result;

                    payloads = {
                        ...widgetParams,
                        ...payloads.new_tip
                    };

                    // console.log(payloads);
                    setHTML('widget-container', renderWidget(payloads));

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
                    <div class="card bg-color-card  border-0  shadow">
                        <div class="card-body  d-flex justify-content-between align-items-center">
                            <div class="conten">
                                <h5 class="mb-1 "><strong id="supporter_name">${splitLongText((escape(payloads.name) || ''), 25, 20)}</strong></h5>
                                <h6>Baru saja mendukungmu </h6>
                                <h6 class="fw-bold">
                                    <strong id="support">${payloads.formated_amount || 'Rp0'}</strong>
                                </h6>
                            </div>
                            <div class="image">
                                <div class="img-leaderboard">
                                    <img class="" width="60" height="60" id="supporter_avatar" src="${payloads.avatar ?? "{{ asset('template/images/icon/icon-user.png') }}"}" alt="">
                                </div>
                            </div>
                        </div>
                        <div id="support_message_div" class="card-footer bg-color-footer overflow-hidden ps-2 pe-2 ${setAsMarquee == '1' ? 'pb-0 pt-1' : '' }" ${payloads.showMessage != '1' ? 'hidden' : ''}>
                            ${supportMessage}
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
                        <div class="card w-100 rounded-1 box-corner color-card-border bg-color-card shadow-sm animate__animated animate__fadeIn">
                            <div class="card-body p-1">
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

            const getSupportMessageType = (type = 'text') => {
                let payloads = payloadsData;
                let supportMessage = `<span class="message fst-italic text-nowrap" id="supporter_message"> ${splitLongText((escape(payloads.message) || 'Example Message'), 40, 35)} </span>`;
                if (type == 'marquee') {
                    supportMessage = `<marquee class="p-0" behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();">
                                        <span class="message fst-italic text-nowrap" id="supporter_message"> ${splitLongText((escape(payloads.message) || 'Example Message'), 40, 35)} </span>
                                    </marquee>`;
                }

                return supportMessage;
            }
            
        })(jQuery);
    </script>

</body>

</html>