
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/echo.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.marquee.min.js') }}"></script>
    <script  type="text/javascript"> 

        let firstFetch = false;
        const selector=$('#running-text');
        const setup = {
                        speed: 120,
                        gap: 50,
                        delayBeforeStart: 0,
                        direction: 'left',
                        duplicated: true,
                        pauseOnHover: true
                    };
        $(() => {
            // To get query params https://flaviocopes.com/urlsearchparams/
            const params = new URLSearchParams(window.location.search);

            Echo.channel("stream.newtip.{{ $streamKey }}")
                .listen('.stream.newtip', (data) => {
                    const { payloads } = data;

                    renderWidget(payloads);
                    //$('#running-text').marquee(setup);
                });

            Echo.connector.pusher.connection.bind("state_change", function (states) {
                console.log(`Socket is ${states.current}`);

                if (states.current === "connected") {
                    if (!firstFetch) {
                        prefetchData();
                        firstFetch = true;
                    }
                }
            });

           //$(window).load(function() {
                $('#running-text').marquee(setup);
            //});
        });

       

        const renderWidget = (payloads) => {
            console.log(payloads,'payloads');
            //$("#example-result").html(JSON.stringify(payloads, null, 2));
            //$("#mode").html(`${payloads.test ? "Mode: Test" : ""}`);
            
            const data=payloads.new_tip;
            const card=$('.card-lastsupporter');
            //if(data){
                selector.empty();
                $('.sp-title').html(data.name);
                $('#message').html(data.message);
                $('#total').html(data.formated_amount);

                //let html=' <i class="fas fa-circle"></i> Supporter Terbaru ';
                ////$.each(data.items, function( index, value ) {
                  //  html+=` <i class="fas fa-circle"></i> `+value.name+` x `+value.qty+` = <b>`+value.formated_total+`</b>`;
               // });

                html=` <i class="fas fa-circle"></i> <b>`+data.name+`</b> baru saja mendukung mu dengan `+data.formated_amount+`  "<i>`+data.message+`"</i> `;

                /*updadte ruuning text */
                $('#running-text').marquee('destroy');
                $('#running-text').html(html);
                $('#running-text').marquee(setup);
           // }
            card.addClass('animate__backInUp');
            $.wait( function(){ card.removeClass('animate__backInUp') }, 3);
            //$('#running-text').html(html);
            
        }
        $.wait = function( callback, seconds){
            return window.setTimeout( callback, seconds * 1000 );
        }
        
        const prefetchData = async () => {
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
        }
        
    </script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    @if(!empty($qParams['lst_font']))
    <link href="https://fonts.googleapis.com/css?family={{ $qParams['lst_font'] }}" rel="stylesheet" type="text/css">
    @endif
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{ asset('template/vendor/jquery.marquee/css/jquery.marquee.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template/css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>
    <div id="app">
        {{-- <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">

                    </ul>
                </div>
            </div>
        </nav> --}}

            <!-- version 1 -->
        <style>
            .card-lastsupporter{
                background-color: {{ $qParams['lst_color_1'] }};
                border-color: {{ $qParams['lst_color_2'] }};
                color: {{ $qParams['lst_color_3'] }};
                overflow: hidden;
            }
            div#running-text {
                padding: 0 20px;
            }
            @media(max-width:768px){
                .sp-title {
                    font-size: 16px;
                }

            }
        </style>
        
        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                       <div class="card card-lastsupporter animate__animated animate__backInUp">
                            <div class="card-body p-0">
                            {{--<ul class="notification-list m-0 p-3">
                                    <li class="d-flex align-items-center justify-content-between">
                                        <div class="user-img img-fluid mr-2 d-none"><img src="{{ asset('template/images/user/01.jpg') }}" alt="story-img" class="rounded-circle avatar-40"></div>
                                        <div class="w-100">
                                            <div class="d-flex justify-content-between">
                                                <div class=" ms-3">
                                                    <h4 class="sp-title"><b>Ozy Sihombing S.Pd</b></h4>
                                                    <p id="message" class="mb-0 {{ (!$qParams['lst_support_message'])?'d-none':'' }} ">Voluptatem temporibus tempora voluptatem odio voluptas eum aperiam molestiae.</p>
                                                </div>
                                                <div class="d-flex align-items-center {{ (!$qParams['lst_marquee'])?'d-none':'' }} ">
                                                    <span><b id="total"  >Rp120.000</b></span>
                                                </div>
                                            </div>
                                        </div>
                                    </li> 
                                </ul>--}}
                                <div id="running-text" class="p-2" >
                                    Supporter Terbaru
                                </div>
                            </div>
                       </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
        

    <script src="{{asset('template/js/jquery.fontselect.min.js')}}"></script>
    @if(!empty($qParams['lst_font']))
    <script>
         
         const useFont = (font) => {
            font = font.replace(/\+/g, ' ');
            font = font.split(':');
            var fontFamily = font[0];
            var fontSpecs = font[1] || null;
            var italic = false, fontWeight = 400;
            if (/italic/.test(fontSpecs)) {
               italic = true;
               fontSpecs = fontSpecs.replace('italic','');
            }
            fontWeight = +fontSpecs;
            // Set selected font on paragraphs
            var css = {
               fontFamily: "'"+fontFamily+"'",
               fontWeight: fontWeight,
               fontStyle: italic ? 'italic' : 'normal'
            };
            //console.log(css,'css');
            //$('.container').css(css);
            $('body').css(css);
            return false;
         }

         useFont('{{ $qParams['lst_font'] }}');
    </script>
    @endif
</body>
</html>
