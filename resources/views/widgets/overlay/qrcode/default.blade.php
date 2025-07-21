<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>QRCode | Default</title>

    <link href="{{ asset('assets/img/omg.png') }}" rel="icon" type="image/x-icon">
    <link href="{{ asset('template/vendor/bootstrap-5/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template/vendor/animate.css/css/animate.min.css') }}" rel="stylesheet">
    <style>
        :root {
            --color-card: #ebebeb;
            --color-text: #2d2d39;
            --color-pattern: #2d2d39;
            --color-card-border: #ebebeb;
            --box-width: 300px;
            --box-margin: auto;
            --font-family: "Ubuntu", "Montserrat", sans-serif;
        }

        body {
            width: var(--box-width);
            margin: var(--box-margin);
        }

        .box {
            min-width: var(--box-width);
            margin: var(--box-margin);
            font-family: var(--font-family);
        }

        .bg-color-card {
            background: var(--color-card);
            /* background: transparent; */
        }

        .card-border {
            border: 2px solid var(--color-card-border);
        }

        .color-text {
            color: var(--color-text);
        }

        .color-pattern {
            background: var(--color-pattern);
        }
        
    </style>
</head>

<body>
    @php 
        $colorBg = hex2rgba($qParams['qrc_t1_color_1'] ?? '#ebebeb'); 
        $color = hex2rgba($qParams['qrc_t1_color_3'] ?? '#2d2d39'); 
        $eyeColor = hex2rgba('#6103D0'); 
        $supportPage = Request::root() ."/$creatorPage/support";

        $qr = QrCode::format('png')
                    ->merge(asset('assets/img/omg.png'), .2, true)
                    ->size(250)
                    ->style($qrc_style)
                    ->color($color[0], $color[1], $color[2])
                    ->backgroundColor($colorBg[0], $colorBg[1], $colorBg[2], 100)
                    ->eye('circle')
                    ->eyeColor(0, 0, 0, 0, $eyeColor[0], $eyeColor[1], $eyeColor[2], 1)
                    ->margin(0)
                    ->errorCorrection('H')
                    ->generate($supportPage);
    @endphp

    <div class="box m-3" id="widget-container"></div>

    <!-- Scripts -->
    <script src="{{ asset('template/vendor/jquery/js/jquery.min.js') }}"></script>
    <script src="{{ asset('template/vendor/bootstrap-5/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('template/vendor/webfont/js/webfont.min.js') }}"></script>
    <script src="{{ asset('assets/js/omg-widget.js') }}"></script>
    <script src="{{ asset('assets/js/dom-to-image.js') }}"></script>
    <script src="{{ asset('assets/js/utils.js') }}"></script>
    <script type="text/javascript">
    
        $(() => {
            if (qParams.has('iframe')) {
                regCallbackInterval();
            }

            init();
        });

        const init = async () => {
            setHTML('widget-container', renderLoader());
            setStyle('--animate-duration', '500ms');

            // Check if in iframe / preview
            if (qParams.get('iframe')) {
                setStyle('--box-width', '90%');
            } else {
                setStyle('--box-margin', 'initial');
            }
            
            // Set font
            const font = qParams.has('qrc_font') ? qParams.get('qrc_font') : "Ubuntu"; 
            setFont(font);

            // Setup color palete
            const colorCard = qParams.get('qrc_t1_color_1');
            if (colorCard) {
                setStyle('--color-card', colorCard);
            }
            
            const colorCardBorder = qParams.get('qrc_t1_color_2');
            if (colorCardBorder) {
                setStyle('--color-card-border', colorCardBorder);
            }

            const colorPattern = qParams.get('qrc_t1_color_3');
            if (colorPattern) {
                setStyle('--color-pattern', colorPattern);
            }

            const colorText = qParams.get('qrc_t1_color_4')
            if (colorText) {
                setStyle('--color-text', colorText);
            }

            // Setup inner html
            let payloads = {
                topLabel: qParams.get('qrc_top_label') || '',
                bottomLabel: qParams.get('qrc_bottom_label') || '',
                isIframe: qParams.get('iframe') || 0,
            }

            setHTML('widget-container', renderWidget(payloads));
        }

        const renderWidget = (payloads = {}) => {
            return `
                <div class="card color-text text-center bg-color-card shadow card-border animate__animated animate__fadeIn" id="qr-code">
                    <div class="card-body p-2">
                        <h4 class="card-title color-text mb-2 mt-2" id="top-label">${escape(payloads.topLabel)}</h4>
                        <img src="data:image/png;base64, {!! base64_encode($qr) !!}" class="img-fluid" >
                        <h5 class="card-title color-text mb-2 mt-2" id="bottom-label">${escape(payloads.bottomLabel)} </h5>
                    </div>
                </div>
                <div class="text-center mt-3 " ${payloads.isIframe == 0 ? 'hidden' : ''}>
                    <button id="download" class="btn btn-sm btn-outline-danger " onclick="downloadQr();"> Download </button>
                </div>
            `;
        }

        const renderLoader = () => {
            return `
                <div class="card color-text text-center bg-color-card shadow card-border">
                    <div class="card-body p-2">
                        <h5 class="mb-1 text-center"><strong id="text-render">Rendering...</strong></h5>
                    </div>
                </div>
            `;
        }

        const downloadQr = () => {
            let getid = document.getElementById('qr-code');
            let strRand = Math.random().toString(36).substring(2, 15);

            domtoimage.toPng(getid)
                .then(function(dataUrl) {
                    let link = document.createElement('a');
                    link.download = `omg-qr-${strRand}.png`;
                    link.href = dataUrl;
                    link.click();
                })
                .catch(function (error) {
                    console.error('oops, something went wrong!', error);
                });
        }
        
    </script>

</body>
</html>