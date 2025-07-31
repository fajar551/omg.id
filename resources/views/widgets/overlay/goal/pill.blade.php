<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Goal | Pill</title>

    <link href="{{ asset('assets/img/omg.png') }}" rel="icon" type="image/x-icon">
    <link href="{{ asset('template/vendor/bootstrap-5/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template/vendor/animate.css/css/animate.min.css') }}" rel="stylesheet">
    <style>
        :root {
            --color-card: #ebebeb;
            --color-text-dark: #2d2d39;
            --color-card-shadow: #6103D0;
            --color-text-dark: #2d2d39;
            --color-text: #6103D0;
            --color-progress: #D0EE26;
            --box-width: 430px;
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

        .bg-content  {
            width: var(--box-width);
            height: auto;
            box-shadow: -5px 6px 0px 0px var(--color-card-shadow);
            background-color: var(--color-card);
            top: -1px;
            right: -2px;
            /* margin-top: 50px; */
        }

        .text-indigo {
            color: var(--color-text);
            font-weight: 700;
        }

        span.des {
            font-size: 14px;
            font-weight: 500;
            color: var(--color-text);
        }

        .color-progress {
            background: var(--color-progress);
        }

        .color-progress-border {
            border: 1px solid var(--color-progress);
        }

        .color-text-dark {
            color: var(--color-text-dark);
        }
    </style>
</head>

<body class="parent-content">

    <div class="box m-3" id="widget-container"></div>

    <!-- Scripts -->
    <script src="{{ asset('template/vendor/jquery/js/jquery.min.js') }}"></script>
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

            $(() => {
                if (qParams.has('iframe')) {
                    regCallbackInterval();
                }

                init();
                if (!qParams.has('iframe')) {
                    setInterval(() => {
                        init();
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
                }

                // Set font
                const font = qParams.has('goa_font') ? qParams.get('goa_font') : "Ubuntu";
                setFont(font);

                // Setup color palete
                const colorCard = qParams.get('goa_t3_color_1');
                if (colorCard) {
                    setStyle('--color-card', colorCard);
                }

                const colorCardShaodw = qParams.get('goa_t3_color_2');
                if (colorCardShaodw) {
                    setStyle('--color-card-shadow', colorCardShaodw);
                }

                const colorText = qParams.get('goa_t3_color_3');
                if (colorText) {
                    setStyle('--color-text', colorText);
                }

                const colorProgress = qParams.get('goa_t3_color_4')
                if (colorProgress) {
                    setStyle('--color-progress', colorProgress);
                }

                // Setup inner html
                let widgetParams = {
                    showLink: qParams.get('goa_show_link'),
                    showCurrentNominal: qParams.get('goa_show_current_nominal'),
                    showTargetNominal: qParams.get('goa_show_target_nominal'),
                    showProgress: qParams.get('goa_show_progress')
                }

                // Get data from BE
                const response = await fetchData();
                if (response) {
                    let { payloads } = await response.data.result;

                    payloads = {
                        ...widgetParams,
                        ...payloads.goal
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
                let hidden = '';
                if (payloads.showCurrentNominal == "1" || payloads.showTargetNominal == "1") {
                    hidden = 'hidden';
                }

                if (payloads.showCurrentNominal == "0" && payloads.showTargetNominal == "0") {
                    hidden = 'hidden';
                }

                if (payloads.showCurrentNominal == "1" && payloads.showTargetNominal == "1") {
                    hidden = '';
                }

                return `
                    <div class="card bg-content rounded-pill mx-auto animate__animated animate__fadeIn">
                        <div class="card-body py-1 content rounded-pill pt-2 pb-3">
                            <h6 class="text-indigo text-center">
                                <span class="" id="title">${escape(payloads.title) || `My Goal`}</span>
                                <br><br>
                                <span class="des color-text">
                                    <span id="target_achieved" ${payloads.showCurrentNominal != "1" ? 'hidden' : ''}>
                                        @lang('Terkumpul') 
                                        <strong id="target_achieved_value"> ${payloads.formated_target_achieved || `Rp0`} </strong>
                                    </span> 
                                    <span id="text_from" ${hidden}> 
                                        @lang('Dari') 
                                    </span> 
                                    <span id="target" ${payloads.showTargetNominal != "1" ? 'hidden' : ''}> 
                                        <strong id="target_value"> ${payloads.formated_target || `Rp0`} </strong>
                                    </span> 
                                </span>
                                <footer class=" color-text tesaja text-center font-size-12 mt-2" id="creator_link" ${payloads.showLink != "1" ? 'hidden' : ''}> 
                                    <cite title="Link" class="color-text">${payloads.short_creator_link}&nbsp;</cite>
                                </footer>
                            </h6>
                            <div class="" id="show_progress" ${payloads.showProgress != "1" ? 'hidden' : ''}>
                                <div class="progress ml-4 color-progress-border mx-auto" style="height:30%; width: 80%">
                                    <div class="progress-bar color-progress" role="progressbar" style="width: ${payloads.progress}%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                        <span class="color-text-dark text-weight-60"> ${payloads.progress}% </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }

            const renderLoader = () => {
                return `
                    <div class="card bg-content rounded-pill mx-auto animate__animated animate__fadeIn">
                        <div class="card-body py-1 content rounded-pill  ">
                            <h6 class="text-indigo text-center">
                                <span id="title">Rendering...</span>
                            </h6>
                        </div>
                    </div>
                `;
            }
            
        })(jQuery);
    </script>
<body>
</html>