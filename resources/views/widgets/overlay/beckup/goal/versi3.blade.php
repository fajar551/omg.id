<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    @if(!empty($ntf_font))
    <link href="https://fonts.googleapis.com/css?family={{ $ntf_font }}" rel="stylesheet" type="text/css">
    @endif
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('template/css/jquery.fontselect.min.css')}}">
    <!-- <link rel="stylesheet" href="{{asset('assets/notif.css')}}"> -->

    <!-- Scripts -->
    {{--
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    --}}
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/echo.js') }}"></script>

    {{-- Added 08-03-2022 10:13 --}}
    <script src="{{ asset('assets/js/omg-widget.js') }}"></script>

    <script type="text/javascript">


    </script>

    <style>
        .card.parent {
            border-radius: 30px;
            width: 90%;
            margin: auto;
        }
        .card.bg-1 {
            background-color: white;
            border-radius: 30px 30px 0px 0px !important;
        }

        .card.bg-2 {
            background-color: #6103D0;
            border-radius: 0px 0px 30px 30px !important;
        }

        .text-indigo {
            color: #6103D0;
            font-weight: 700;
            font-size: 16px;
        }

        span.des {
            font-size: 14px;
            font-weight: 500;
            color: #6103D0;
        }


        .color-progress {
            background: var(--color-progress);
        }

        .color-progress-border {
            border: 1px solid var(--color-progress);
        }
    </style>


</head>

<body class="parent-content">

    <script type="text/javascript">
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
    </script>

    <div id="app">


            <div class="card parent border-0  shadow mt-4">
            <div class="card bg-1 my-0 py-0 border-0  rounded-0">
                <div class="card-body pb-2">
                    <h6 class="text-indigo text-center">
                        Lorem ipsum
                        <br>
                        <span class="des">
                            baru saja mengirimkan 5 koin!
                        </span>
                    </h6>
                </div>

            </div>

            <div class="card bg-2 my-0 py-0 border-0 rounded-0">
                <div class="card-body">
                    <div class="progress ml-4 color-progress-border" style="height:20px; width: 80%">
                        <div class="progress-bar color-progress" role="progressbar" style="width: ${payloads.progress}%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                            <span class="color-text-dark text-weight-60"> ${payloads.progress}% </span>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        <script src="{{asset('template/js/jquery.fontselect.min.js')}}"></script>
        @if(!empty($ntf_font))
        <script>
            //  const useFont = (font) => {
            //     font = font.replace(/\+/g, ' ');
            //     font = font.split(':');
            //     var fontFamily = font[0];
            //     var fontSpecs = font[1] || null;
            //     var italic = false, fontWeight = 400;
            //     if (/italic/.test(fontSpecs)) {
            //        italic = true;
            //        fontSpecs = fontSpecs.replace('italic','');
            //     }
            //     fontWeight = +fontSpecs;
            //     Set selected font on paragraphs
            //     var css = {
            //        fontFamily: "'"+fontFamily+"'",
            //        fontWeight: fontWeight,
            //        fontStyle: italic ? 'italic' : 'normal'
            //     };
            //     console.log(css,'css');
            //     $('.container').css(css);
            //     $('body').css(css);
            //     return false;
            //  }

            //  useFont('{{ $ntf_font }}');
        </script>
        @endif

</html>