
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('template/images/favicon.ico') }}" />
    <title>{{ $creatorPage }} Marquee</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.marquee.min.js') }}"></script>
    <script src="{{ asset('js/echo.js') }}"></script>
    @include('components.creator-stream')
    <script type="text/javascript">
        
        const separatorType = '{!! ( $qParams['mrq_separator_type'] == 'dot' )?'<i class="fas fa-circle"></i>':'<i class="fas fa-bullhorn"></i>' !!}';

        const speed = {
                            'slow' : 90,
                            'normal' : 120,
                            'fast'  : 160
                        };
    
        let firstFetch = false;

        $(() => {
            /*
            Echo.channel("stream.newtip.{{ $streamKey }}")
                .listen('.stream.newtip', (data) => {
                    const { payloads } = data;

                    if (!payloads.test) {
                        prefetchData(payloads);
                    }
                });

            Echo.channel("stream.marquee.{{ $streamKey }}")
                .listen('.stream.marquee', (data) => {
                    //console.log(data,'data');
                    const { payloads } = data;

                    renderWidget(payloads);
                });

            Echo.connector.pusher.connection.bind("state_change", function (states) {
                console.log(`Socket is ${states.current}`);

                if (states.current === "connected") {
                    if (!firstFetch) {
                        prefetchData();
                        firstFetch = true;
                        const qParams = JSON.parse('{!! json_encode($qParams) !!}');
                        // console.log(qParams['mode']);
                        if (!qParams['test']) {
                            const status = 1;
                            setused(status);
                        }
                    }
                }
            });
            */
        });

        const renderWidget = async (payloads) => {        
            //console.log(payloads);
            //$("#example-result").html(JSON.stringify(payloads, null, 2));
           // $("#mode").html(`${payloads.test ? "Mode: Test" : ""}`);

            var html ='';
            $.each(payloads.additional_message,function( index, value ) {
                html += ` `+separatorType+` `+value+` `;
            });

            $('#running-text').html(html);

            $('#running-text').marquee({
                speed: speed.{{ $qParams['mrq_speed'] }},
                gap: 50,
                delayBeforeStart: 0,
                direction: 'left',
                duplicated: true,
                pauseOnHover: true
            });
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
            const { payloads } = response.data.result;
            renderWidget(payloads);
        }

        prefetchData();

        setInterval(function(){
            prefetchData();
        },60000);
    </script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    @if(!empty($ntf_font))
    <link href="https://fonts.googleapis.com/css?family={{ $qParams['mrq_font'] }}" rel="stylesheet" type="text/css">
    @endif


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        div#running-text {
            overflow: hidden;
            height: 30px;
            line-height: 30px;
            font-size: 17px;
            /* background: #fff;
            border: solid 1px #fff; */
        }
        .card-runing {
            padding: 10px;
            border: solid 2px #333;
        }
        @media(max-width:768px){
            div#app {
                position: fixed;
                right: 0;
                left: 0;
                width: 100%;
                top: 10%;
            }

        }
    </style>
    @if($qParams['mrq_color_1'])
    <style>
        .card-runing{
            border: 1px solid {{ $qParams['mrq_color_1'] }};
        }
    </style>
    @endif
    @if($qParams['mrq_color_2'])
    <style>
        .card-runing{
            background: {{ $qParams['mrq_color_2'] }};
        }
    </style>
    @endif
    @if($qParams['mrq_color_3'])
    <style>
        .card-runing{
            color: {{ $qParams['mrq_color_3'] }};
        }
    </style>
    @endif
    <!-- Styles -->

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
        
        <main class="py-4">
            <div class="container-fluid">
                <div class="card card-txt">
                    <div class="card-body card-runing">
                        <div id="running-text"></div>
                    </div>
                </div>

                {{--
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">{{ ucwords( __($key) ) .__(" Widget") }}</div>
            
                            <div class="card-body">
                                <div class="alert alert-success" role="alert">
                                    <div id="mode"></div>
                                    <pre id="example-result"> </pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                --}}
            </div>
        </main>
    </div>
    <script src="{{asset('template/js/jquery.fontselect.min.js')}}"></script>
    @if(!empty($qParams['mrq_font']))
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

         useFont('{{$qParams['mrq_font'] }}');
    </script>
    @endif
</body>
</html>
