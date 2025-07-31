<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Marquee | Default</title>

    <link href="{{ asset('assets/img/omg.png') }}" rel="icon" type="image/x-icon">
    <link href="{{ asset('template/vendor/bootstrap-5/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template/vendor/animate.css/css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template/vendor/acme-news-ticker/assets/css/style.css') }}" rel="stylesheet">
    <style>
        :root {
            --color-card: #ebebeb;  
            --color-card-label: #ffc107;
            --color-text-card: #6103D0;
            --color-text-label: #2d2d39;
            --box-width: 520px;
            --box-margin: auto;
            --text-shadow: 2px 2px 3px #858585;
            --font-family: "Ubuntu", "Montserrat", sans-serif;
        }

        body {
            width: 100%;
            margin: var(--box-margin);
            font-family: var(--font-family);
        }

        .acme-news-ticker {
            background: var(--color-card);
            /* border: 1px solid var(--color-card-label); */
            /* border-color: var(--color-card-label); */
            border: none !important;
            color: var(--color-text-card);
            border-radius: 25px;
            margin-top: 5px;
            box-shadow: 0px 5px #888888;
            /* height:50px; */
        }

        .separator-color {
            color: var(--color-text-card);
        }

        .acme-news-ticker-label {
            background: var(--color-card-label);
            color: var(--color-text-label);
            margin-right: 15px;
        }

        /* .acme-news-ticker .acme-news-ticker-label:after{
            content: "";
            position: absolute;
            top: 0;
            margin-top: 5px;
            margin-left: 4px;
            border-left: 20px solid var(--color-card-label);
            border-top: 17px solid transparent;
            border-bottom: 15px solid transparent;
        } */

        .marquee {
            width: 100%;
            overflow: hidden;
            margin: auto;
        }

        .text-shadow {
            text-shadow: var(--text-shadow);
        }

        @media (max-width: 575px) {
            .acme-news-ticker-box {
                /* padding-left: 3px; */
                padding-right: 3px; 
            } 
        }

        .card-footer {
            box-shadow: 0px 5px #888888;
        }
    </style>
</head>
<body>
    <div class="acme-news-ticker animate__animated animate__fadeIn" id="widget-container"  ></div>  

    <!-- Scripts -->
    <script src="{{ asset('template/vendor/jquery/js/jquery.min.js') }}"></script>
    <script src="{{ asset('template/vendor/bootstrap-5/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('template/vendor/webfont/js/webfont.min.js') }}"></script>
    <script src="{{ asset('assets/js/omg-widget.js') }}"></script>
    <script src="{{ asset('template/vendor/acme-news-ticker/assets/js/acmeticker-custom.js') }}"></script>
    <script src="{{ asset('assets/js/utils.js') }}"></script>
    <script type="text/javascript">
        /**
        * Overlay scripts
        * Version: 1.0
        */
        (function ($) {
            "use strict";

            let widgetParams = {};
            let rtQueue = [];

            $(() => {
                if (qParams.has('iframe')) {
                    regCallbackInterval({
                        "buildMarquee": buildMarquee,
                    });
                }

                widgetParams = {
                    showLabel: qParams.get('mrq_show_label'),
                    showSupportMessage: qParams.get('mrq_show_support_message'),
                    textLabel: qParams.get('mrq_txt_label'),
                    marqueeType: qParams.get('mrq_type'),
                    showShadow: qParams.get('mrq_txtshadow'),
                    itemCount: qParams.get('mrq_item_count'),
                    separatorType: qParams.get('mrq_separator_type'),
                    realData: qParams.get('real_data'),
                }

                init();
                if (!qParams.has('iframe')) {
                    // TODO: Maybe it should be better if listen to ws for latest tips
                    setInterval(async() => {
                        const response = await fetchData();
                        if (response) {
                            let { payloads } = await response.data.result;
                            
                            payloads = {
                                ...widgetParams,
                                marquee: payloads.marquee,
                                additionalMessage: payloads.additional_message,
                            };

                            // console.log(payloads, 'Push data to queue');
                            rtQueue.push(payloads);

                            return true;
                        }
                    }, 3 * 60 * 1000);  // 3 Minutes 
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

                    if (qParams.get('mrq_type') == 'marquee') {
                        document.addEventListener("marqueeEnd", (e) => {
                            // console.log("MarqueeEnd");
                            if (rtQueue.length > 0) {
                                renderQueue();
                            }
                        });
                    } else if (qParams.get('mrq_type') == 'horizontal' || qParams.get('mrq_type') == 'vertical') {
                        document.addEventListener("vertiZontalEnd", (e) => {
                            // console.log("vertiZontalEnd");
                            if (rtQueue.length > 0) {
                                renderQueue();
                            }
                        });
                    }
                }
                
                // Set font
                const font = qParams.has('mrq_font') ? qParams.get('mrq_font') : "Ubuntu"; 
                setFont(font);

                // Color card label
                const colorCardLabel = qParams.get('mrq_t1_color_1');
                if (colorCardLabel) {
                    setStyle('--color-card-label', colorCardLabel);
                }

                // Color card body
                const colorCard = qParams.get('mrq_t1_color_2'); 
                if (colorCard) {
                    setStyle('--color-card', colorCard);
                }

                // Color card text label
                const colorCardTextLabel = qParams.get('mrq_t1_color_3');
                if (colorCardTextLabel) {
                    setStyle('--color-text-label', colorCardTextLabel);
                }

                // Color card text
                const colorCardText = qParams.get('mrq_t1_color_4');
                if (colorCardText) {
                    setStyle('--color-text-card', colorCardText);
                }

                // Text shadow
                const textShadow = qParams.get('mrq_txtshadow');
                if (textShadow == '1') {
                    setStyle('--text-shadow', '2px 2px 3px #858585');
                } else {
                    setStyle('--text-shadow', '0');
                }

                // Setup html
                // let widgetParams = {
                //     showLabel: qParams.get('mrq_show_label'),
                //     showSupportMessage: qParams.get('mrq_show_support_message'),
                //     textLabel: qParams.get('mrq_txt_label'),
                //     marqueeType: qParams.get('mrq_type'),
                //     showShadow: qParams.get('mrq_txtshadow'),
                //     itemCount: qParams.get('mrq_item_count'),
                //     separatorType: qParams.get('mrq_separator_type'),
                //     realData: qParams.get('real_data'),
                // }

                // Get data from BE
                const response = await fetchData();
                if (response) {
                    let { payloads } = await response.data.result;
                    
                    payloads = {
                        ...widgetParams,
                        marquee: payloads.marquee,
                        additionalMessage: payloads.additional_message,
                    };

                    // console.log(payloads);
                    setHTML('widget-container', renderWidget(payloads));
                    setTimeout(() => {
                        buildMarquee(qParams.get('mrq_type'));
                    }, 1500);

                    return true;
                }

                setHTML('text-render', 'Failed to render');
            }

            const fetchData = async () => {
                @php
                    $params = array_merge([
                        'key' => $key, 
                        'streamKey' => $streamKey, 
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

            const renderQueue = () => {
                // console.log('Render new data from queue: ');
                let payloads = rtQueue[0];

                setHTML('news-ticker', messageBuilder(payloads));
                document.dispatchEvent(new Event('marqueeDataUpdated'));
            
                rtQueue.shift();
            }

            const getSpeedForMarquee = (speed = 'normal', type = 'marquee') => {
                const marqSpeed = {
                    marquee: {
                        slow: 0.05,
                        normal: 0.10, 
                        fast: 0.20
                    },
                    horizontal: {
                        slow: 1000,
                        normal: 800, 
                        fast: 200
                    },
                };

                switch (type) {
                    case 'marquee':
                        return marqSpeed['marquee'][speed];
                    case 'horizontal':
                    case 'vertical':
                        return marqSpeed['horizontal'][speed];
                    default:
                        return 0;
                }
            }

            const getDirectionForMarquee = (type = 'marquee') => {
                switch (type) {
                    case 'marquee':
                        return 'left';
                    case 'horizontal':
                        return 'right';
                    case 'vertical':
                        return 'down';
                    default:
                        return 'left';
                }
            }

            const buildMarquee = (type = 'marquee') => {
                $('#news-ticker').AcmeTicker({
                    type,                                                           /* horizontal/vertical/marquee/typewriter */
                    direction: getDirectionForMarquee(type),                        /* up/down/left/right */
                    speed: getSpeedForMarquee(qParams.get('mrq_speed'), type),      /* true/false/number */ /*For vertical/horizontal 600*//*For marquee 0.05*//*For typewriter 50*/
                    // controls: {
                    //     toggle: $('.pause'),/*Can be used for horizontal/horizontal/typewriter*//*not work for marquee*/
                    // }
                });
            }

            const renderWidget = (payloads = {}) => {
                return `
                    <div class="acme-news-ticker-label label p-2 top-0 rounded-pill" id="marquee-label" style="left: 0" ${payloads.showLabel != 1 ? 'hidden' : '' }>
                        <img src="{{ asset('template/images/omg.png') }}" alt="" class="" width="30" height="30">
                        <span id="marquee-label-text"> ${escape(payloads.textLabel) || ''}</span>
                    </div>
                    <div class="rounded-pill acme-news-ticker-box">
                        <ul class="my-news-ticker text-nowrap" id="news-ticker">
                            ${messageBuilder(payloads)} 
                        </ul>
                    </div>
                `;
            }

            const messageBuilder = (payloads) => {
                let marquee = payloads.marquee || [];
                let message = [];

                if (marquee.length > 0) {
                    for (const support of marquee) {
                        message.push(`${escape(support.name)} memberikan dukungan sebesar <strong>${support.formated_amount}</strong> <span><strong class="supporter_message" ${payloads.showSupportMessage != '1' ? 'hidden' : ''}> | ${splitLongText((escape(support.message) || 'No Message'), 40, 35)} </strong></span>`);
                    }
                } else {
                    message.push(`<strong>No latest support</strong>`);
                }

                // Support message
                let element = [];
                let textContent = '';
                for (let i = 1; i <= payloads.itemCount; i++) {
                    textContent = null;
                    if (message.length > 0 && message[i-1] !== undefined) {
                        textContent = `${message[i-1]}`
                    } else {
                        if (payloads.realData == '0') {
                            textContent = `Example stream tickers ${$i}`;
                        } else if (payloads.realData == '1' && message[i-1] !== undefined) {
                            textContent = `${message[i-1]}`;
                        }
                    }

                    if (textContent) {
                        element.push(`<li class="${payloads.showShadow ? 'text-shadow ' : ''}" style="margin-right: 5px; margin-left: 5px; display: inline-block;">${textContent}</li>`);
                    }
                }

                // Additional message
                let additionalMessage = payloads.additionalMessage;
                for (let i = 0; i < additionalMessage.length; i++) {
                    element.push(`<li class="${payloads.showShadow ? 'text-shadow ' : ''}" style="margin-right: 5px; margin-left: 5px; display: inline-block;">${escape(additionalMessage[i])}</li>`);
                }

                let separtor = payloads.marqueeType == 'marquee' 
                                ? (payloads.separatorType == 'dot' ? ' <i class="separator-color fas fa-circle fa-1x"></i> ' : ' <span> <img src="{{ asset("template/images/omg.png") }}" alt="" class="" width="20" height="20"> </span> ') 
                                : '';

                return element.join(separtor);
            }

            const renderLoader = () => {
                return `
                    <div class=" border-top-0 rounded-pill acme-news-ticker-box">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 ">
                                <h5 class="mb-1 text-center"><strong id="text-render">Rendering...</strong></h5>
                            </div>
                        </div>
                    </div>
                `;
            }

        })(jQuery);
    </script>

</body>
</html>
