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
        .bg-parent {
            position: relative;
            background-color: #6103D0;
            width: 90%;
            height: 80px;
            border-radius: 23px;
            line-height: 90px;
            margin: auto;
        }

        .text {
            color: #FFFFFF;
            font-weight: 500;
            font-size: 13px;
            width: 70%;
            
        }

        .float {
            position: absolute;
            top: 0;
            right: -1px;
            width: 30%;
            height: 100%;
            border-radius: 0px 23px 23px 0px;
            border: 1px solid white;
        }



    </style>


</head>

<body>
    <div id="app">


        <main class="py-4">
            <div class="card bg-parent border-0">
                <div class="card-body bg-content">
                    <h6 class="text pt-1" >
                        CROISSANTXX
                        <br>
                        baru saja mengirimkan 5 koin!
                    </h6>
                    <div class="float bg-white text-center">
                          <img src="{{ asset('template/images/icon/coin.png') }}" alt="" class="text-center" width="60" height="60">
                    </div>
                </div>
            </div>

        </main>
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