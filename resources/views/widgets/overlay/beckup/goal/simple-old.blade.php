
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('template/images/favicon.ico') }}" />
    <title>OMG | Goal - {{ $creatorPage }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/echo.js') }}"></script>
    <script type="text/javascript">
        const URL ='{{ url('/') }}';
        let firstFetch = false;
        //goa_custom_title
        {!! 'const mode =\''.$qParams['goa_source'].'\';';  !!}
        {!! 'const titlegoal =\''.$qParams['goa_custom_title'].'\';';  !!}
        /*
        $(() => {
            Echo.channel("stream.newtip.{{ $streamKey }}")
                .listen('.stream.newtip', (data) => {
                    const { payloads } = data;

                    if (!payloads.test) {
                        prefetchData(payloads);
                    }
                });

            Echo.channel("stream.goal.{{ $streamKey }}")
                .listen('.stream.goal', (data) => {
                    const { payloads } = data;

                    renderWidget(payloads);
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
        });

        */

        const renderWidget = async (payloads) => {        
            console.log(payloads);
            const card=$('.card-goal');
            const progress=$('#progress');
            let tercapai = payloads.goal.progress;

            $("#example-result").html(JSON.stringify(payloads, null, 2));
            $("#mode").html(`${payloads.test ? "Mode: Test" : ""}`);

            $('#title_active_goal').html(payloads.goal.title);
            $('#title_tips_history').html(titlegoal);
            $('.userurl').html(payloads.goal.creator_link);
            $('#idrtarget').html(payloads.goal.formated_target);
            $('#nominal').html(payloads.goal.formated_target_achieved);

            /*progress */
            progress.css('width',tercapai+'%').attr('aria-valuenow',tercapai);


            //card.addClass('animate__backInUp');
            //$.wait( function(){ card.removeClass('animate__backInUp') }, 3);
            //card.removeClass('animate__backInUp');
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
                    //console.log(response.data.result,'response');
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
    @if(!empty($qParams['goa_font']))
    <link href="https://fonts.googleapis.com/css?family={{ $qParams['goa_font'] }}" rel="stylesheet" type="text/css">
    @endif

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('template/css/animate.min.css') }}" rel="stylesheet">
    <style>
        .card {     
            background-color: #3a54c5; 
            color: #fff;        
        }
        .card-title{
            font-weight: bold;
        }
        .card.card-goal{
            border: solid 2px;
        }
        .active-goal #title_tips_history, .active-goal p, .active-goal .userurl, .active-goal #nominal{
            display: none;
        }
        .tips-history #title_active_goal{
            display: none;
        }
        .card-body{
            padding: 15px;
        }
        @media(max-width:768px){
            .card-title {
                font-weight: bold;
                font-size: 16px;
                margin-bottom: 5px;
            }
            .card p {
                margin-bottom: 0;
            }
            .container.pt-5 {
                padding-top: 3px !important;
            }

        }
    </style>
   
    
         @if($qParams['goa_color_1'])
         <style>
        .card-goal{
            border-color: {{ $qParams['goa_color_1'] }} ;
        }
        </style>
        @endif
        @if($qParams['goa_color_2'])
        <style>
            .card-goal{
                background-color: {{ $qParams['goa_color_2'] }} ;
            }
        </style>
        @endif
        @if($qParams['goa_color_3'])
        <style>
            .card-goal{
                color: {{ $qParams['goa_color_3'] }} ;
            }
        </style>
        @endif
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
        {{--    
        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">

                        </div>
                    </div>
                </div>
            </div>
        </main>
       
        --}}
        
       
        <div class="container py-4">

            <div class="card card-goal animate__animated">
                <div class="card-body text-center  {{ ($qParams['goa_source'] == 'active-goal')?'active-goal':'tips-history' }}">
                    <h3 id="title_tips_history" class="card-title">{{ $qParams['goa_custom_title'] }}</h3>
                    <h3 id="title_active_goal" class="card-title">Aktive Goale</h3>
                    <p>{{ $qParams['goa_custom_title'] }}</p>
                    @if($qParams['goa_show_link'])
                        <div class="userurl">{{ url('/andi/wijang-p') }}</div>
                    @endif
                    @if($qParams['goa_show_target_nominal'])
                    <div><span id="nominal" {{ ($qParams['goa_show_current_nominal'] == 1)?'class="d-none"':'' }}  >0</span> - <span id="idrtarget" {{ ($qParams['goa_show_target_nominal'] == 1)?'class="d-none"':'' }} >Rp. {{ $qParams['goa_custom_target'] }}</span></div>
                    @endif
                    @if($qParams['goa_show_progress'])
                    <div class="progress">
                        <div id="progress" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" ></div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('template/js/jquery.fontselect.min.js')}}"></script>
    @if(!empty($qParams['goa_font']))
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

         useFont('{{ $qParams['goa_font'] }}');
    </script>
    @endif
</body>
</html>
