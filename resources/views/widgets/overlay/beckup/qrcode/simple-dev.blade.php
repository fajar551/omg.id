<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $creatorPage }} QR Code</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family={{ $qrc_font }}" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .card-qr {
            background: transparent;
            border: solid 3px #333;
        }
    </style>
    @if ($qParams['qrc_color_1'])
        <style>
            .card-qr {
                background: {{ $qParams['qrc_color_1'] }};
            }
        </style>
    @endif

    @if ($qParams['qrc_color_3'])
        <style>
            .card-qr {
                color: {{ $qParams['qrc_color_3'] }};
            }
        </style>
    @endif

    @if ($qParams['qrc_color_4'])
        <style>
            .card-qr {
                border: solid 3px {{ $qParams['qrc_color_4'] }};
            }
        </style>
    @endif
    @if ($qParams['qrc_show_border'])
        <style>
            .card-qr {
                border: unset !important;
            }
        </style>
    @endif


</head>

<body>
    <div id="app">
        <main class="py-4">
            <div class="container @if (isset($qParams['iframe']) && @$qParams['iframe'] == 1) on-iframe @endif">

                @php
                    $color = hex2rgba($qParams['qrc_color_2']);
                @endphp
                <div class="row justify-content-center">
                    <div class="col-md-4 col-12">
                        <div id="qr-code" class="card card-qr">
                            <div class="card-body">
                                <div class="top-lable mb-2 text-center"><span
                                        id="qr-top-text">{{ @$qParams['qrc_top_label'] }}</span></div>
                                <div class="qr-ceode d-flex justify-content-center mb-2">
                                    {{-- square or circle. --}}
                                    {!! QrCode::size(200)->style($qrc_style)->color($color[0], $color[1], $color[2])->backgroundColor(0, 0, 0, 0)->eye('circle')->eyeColor(0, 0, 0, 0, 190, 30, 45, 1)->margin(2)->generate(Request::root() . '/' . $creatorPage) !!}
                                </div>
                                <div class="top-lable mb-2 text-center"><span
                                        id="qr-bottom-text">{{ @$qParams['qrc_bottom_label'] }}</span></div>
                            </div>
                        </div>
                        <div class="text-center mt-5 {{ @$qParams['iframe'] == 0 ? 'd-none' : '' }} ">
                            <button id="download" class="btn btn-md btn-danger"> Download</button>
                        </div>
                    </div>
                </div>


            </div>
        </main>
    </div>
</body>
<script src="{{ asset('template/js/jquery.fontselect.min.js') }}"></script>
<script src="{{ asset('assets/js/dom-to-image.js') }}"></script>
<script src="{{ asset('assets/js/omg-widget.js') }}"></script>
<script>
    $(() => {
        if (parent && parent.registerChildFunction) {
            console.log('registering function with parent');

            parent.registerChildFunction({
                "setStyle": setStyle,
                "setHTML": setHTML,
                "setFont": setFont,
                "getElementById": getElementById,
                "getElementsByClassName": getElementsByClassName,
                "toIDR": toIDR,
                "buildParams": buildParams,
                "reloadWidget": reloadWidget,
            });
        }
    });
</script>

<script>
    //var domtoimage = require('dom-to-image');
    $("#download").click(function() {
        let getid = document.getElementById('qr-code');
        domtoimage.toPng(getid)
            .then(function(dataUrl) {
                console.log(dataUrl, 'url');
                var link = document.createElement('a');
                link.download = '{{ $creatorPage }}-{{ date('Ymd') }}.jpeg';
                link.href = dataUrl;
                link.click();
            })
            .catch(function(error) {
                console.error('oops, something went wrong!', error);
            });
    });

    const useFont = (font) => {
        font = font.replace(/\+/g, ' ');
        font = font.split(':');
        var fontFamily = font[0];
        var fontSpecs = font[1] || null;
        var italic = false,
            fontWeight = 400;
        if (/italic/.test(fontSpecs)) {
            italic = true;
            fontSpecs = fontSpecs.replace('italic', '');
        }
        fontWeight = +fontSpecs;
        // Set selected font on paragraphs
        var css = {
            fontFamily: "'" + fontFamily + "'",
            fontWeight: fontWeight,
            fontStyle: italic ? 'italic' : 'normal'
        };
        //console.log(css,'css');
        //$('.container').css(css);
        $('body').css(css);
        return false;
    }
    useFont('{{ $qrc_font }}');

    /* responsive qr */
    const valueattr = (size) => {
        return {
            width: size,
            height: size
        }
    }


    const responsiveQR = (window) => {
        //const selector=$('.qr-ceode svg');
        let attr = valueattr(200);
        if (window < 768) {
            attr = valueattr(150);
        }
        console.log(attr);
        $('.qr-ceode svg').attr(attr);
    }
    var windowsize = $(window).width();
    responsiveQR(windowsize);
    $(window).resize(function() {
        var windowsize = $(window).width();
        responsiveQR(windowsize);
    });
</script>

</html>
