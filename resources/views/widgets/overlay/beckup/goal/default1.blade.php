<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Goal | Default</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        :root {
            --color-card: #2d2d39;
            --color-text-dark: #2d2d39;
            --color-card-footer: #dee2e6;
            --color-text: #fff;
            --color-progress: #ffba68;
            --box-width: 400px;
            --box-margin: auto;
            --font-family: "Ubuntu", "Montserrat", sans-serif;
        }

        .blockquote-footer::after {
            content: "\2014\00A0";
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
        }
        
    </style>
</head>

<body>

    <div class="box m-3" id="widget-container"></div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/omg-widget.js') }}"></script>
    
    <script type="text/javascript">
        $(() => {
            if (parent && parent.registerChildFunction){
                console.log('registering function with parent');

                parent.registerChildFunction({
                    "setStyle": setStyle,
                    "setHTML": setHTML,
                    "setFont": setFont,
                    "getElementById": getElementById,
                    "toIDR": toIDR,
                    "buildParams": buildParams,
                    "reloadWidget": reloadWidget,
                });
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
            const colorCard = qParams.get('goa_t2_color_1'); 
            if (colorCard) {
                setStyle('--color-card', colorCard);
            }

            const colorCardFooter = qParams.get('goa_t2_color_2');
            if (colorCardFooter) {
                setStyle('--color-card-footer', colorCardFooter);
            }

            const colorText = qParams.get('goa_t2_color_3');
            if (colorText) {
                setStyle('--color-text', colorText);
            }

            const colorprogress = qParams.get('goa_t2_color_4')
            if (colorprogress) {
                setStyle('--color-progress', colorprogress);
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

                console.log(payloads);
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
                <div class="card color-text text-center bg-color-card shadow border-0 animate__animated animate__fadeIn">
                    <div class="card-body p-2">
                        <h4 class="card-title color-text mb-1" id="title">${payloads.title || `My Goal`}</h4>
                        <hr class="mt-1 mb-2">
                        <blockquote class="blockquote mb-3">
                            <p> 
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
                            </p>
                            <footer class="blockquote-footer color-text font-size-12 mt-2" id="creator_link" ${payloads.showLink != "1" ? 'hidden' : ''}> 
                                <cite title="Link" class="color-text">${payloads.short_creator_link}&nbsp;</cite>
                            </footer>
                        </blockquote>
                    </div>
                    <div class="card-footer bg-color-footer" id="show_progress" ${payloads.showProgress != "1" ? 'hidden' : ''}>
                        <div class="progress color-progress-border" style="height:75%;">
                            <div class="progress-bar color-progress" role="progressbar" style="width: ${payloads.progress}%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                <span class="color-text-dark text-weight-60"> ${payloads.progress}% </span> 
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

    </script>

</body>
</html>