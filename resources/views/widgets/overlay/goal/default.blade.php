<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Goal | Default</title>

    <link href="{{ asset('assets/img/omg.png') }}" rel="icon" type="image/x-icon">
    <link href="{{ asset('template/vendor/bootstrap-5/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template/vendor/animate.css/css/animate.min.css') }}" rel="stylesheet">
    <style>
        /* 
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
        }

        .bg-color-footer {
            background: var(--color-card-footer);
        }

        .color-text {
            color: var(--color-text);
        }

        .color-text-dark {
            color: var(--color-text-dark);
        }

        .text-weight-60 {
            font-weight: 600;
        }

        .color-progress {
            background: var(--color-progress);
        }

        .color-progress-border {
            border: 1px solid var(--color-progress);
        } */

        :root {
            --color-card: #ebebeb;
            --color-card-footer: #6103D0;
            --color-text: #6103D0;
            --color-progress: #D0EE26;
            --color-text-progress: #2d2d39;
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

        .blockquote-footer::after {
            content: "\2014\00A0";
        }

        .card.parent {
            border-radius: 30px;
            width: 90%;
            margin: auto;
        }

        .card.bg-1 {
            background-color: var(--color-card);
            border-radius: 30px 30px 0px 0px !important;
        }

        .card.bg-2 {
            background-color: var(--color-card-footer);
            border-radius: 0px 0px 30px 30px !important;
        }

        .color-text {
            color: var(--color-text);
            font-weight: 700;
            font-size: 16px;
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
        
        .color-progress-text {
            color: var(--color-text-progress);
        }

    </style>
</head>

<body>

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
                    }, 3 * 60 * 1000); // 3 Minutes
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
                const colorCard = qParams.get('goa_t1_color_1');
                if (colorCard) {
                    setStyle('--color-card', colorCard);
                }

                const colorCardFooter = qParams.get('goa_t1_color_2');
                if (colorCardFooter) {
                    setStyle('--color-card-footer', colorCardFooter);
                }

                const colorText = qParams.get('goa_t1_color_3');
                if (colorText) {
                    setStyle('--color-text', colorText);
                }

                const colorProgress = qParams.get('goa_t1_color_4')
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
                    <div class="card tesaja parent border-0  shadow mt-4">
                        <div class="card card-goal bg-1 my-0 py-0 border-0  rounded-0">
                            <div class="card-body card-goal pb-2">
                                <h6 class="color-text text-center">
                                    <span id="title">${escape(payloads.title) || `My Goal`}</span>
                                    <hr>
                                    <span class="color-text text-center" >
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
                            </div>
                        </div>
                        <div class="card bg-2 my-0 py-0 border-0 rounded-0">
                            <div class="card-body">
                                <div class="bg-color-footer" id="show_progress" ${payloads.showProgress != "1" ? 'hidden' : ''}>
                                    <div class="progress color-progress-border" style="height:75%;">
                                        <div class="progress-bar color-progress " role="progressbar" style="width: ${payloads.progress}%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                            <span class="color-progress-text"> ${payloads.progress}% </span> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }

            const renderLoader = () => {
                return `
                    <div class="card color-text text-center bg-color-card shadow border-0 animate__animated animate__fadeIn">
                        <div class="card-body p-2">
                            <h5 class="mb-1 text-center"><strong id="text-render">Rendering...</strong></h5>
                        </div>
                    </div>
                `;
            }
            
        })(jQuery);
    </script>

</body>

</html>