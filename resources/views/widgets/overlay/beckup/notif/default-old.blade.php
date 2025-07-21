
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('template/images/favicon.ico') }}" />

    <title>{{ $creatorPage }} Notification</title>
    
    <!-- Scripts -->
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
    <script src="{{ asset('js/app.js') }}"></script>
    @if(@$qParams['iframe'] != 1)
    <script src="{{ asset('js/echo.js') }}"></script>
    @endif

    {{-- Added 08-03-2022 10:13 --}}
    <script src="{{ asset('assets/js/omg-widget.js') }}"></script>

    @php( $dataArray=['right' => 'animate__backInRight','left' => 'animate__backInLeft', 'top' => 'animate__backInUp', 'bottom' => 'animate__backOutDown'])
    <script  type="text/javascript"> 
        const duration = "{{ $qParams['ntf_duration'] }}";
        const Interval = duration * 1000;
        const realdata = "{{ $qParams['real_data'] }}";
        {!! 'const direction =\''.$dataArray[$qParams['ntf_direction']].'\';' !!}
        let tipsQueue =[];
        let test =[];
        let animation=false;

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-start',
            showConfirmButton: true,
            confirmButtonColor: '#3085d6',
           // timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        $(() => {
            if (parent && parent.registerChildFunction){
                console.log('registering function with parent');

                parent.registerChildFunction({
                    "setStyle": setStyle,
                    "setHTML": setHTML,
                    "setFont": setFont,
                    "getElementById": getElementById,
                    "getElementsByClassName": getElementsByClassName,
                    "toIDR": toIDR,
                    "buildParams": buildParams,
                    "getQParams": getQParams,
                    "reloadWidget": reloadWidget,
                });
            }

            // To get query params https://flaviocopes.com/urlsearchparams/
            const params = new URLSearchParams(window.location.search);

            @if(@$qParams['iframe'] != 1)
                // Echo.channel("stream.new_tip.{{ $streamKey }}")
                //     .listen('.stream.newtip', (data) => {
                //         const { payloads } = data;
                //         //renderWidget(payloads);
                //         tipsQueue.push(payloads);
                //     });

                Echo.channel("stream.new_tip.{{ $streamKey }}")
                    .notification((data) => {
                        // console.log(data);
                        const { type, payloads } = data;

                        if (type == 'notify.new_tip') {
                            // renderWidget(payloads);
                            tipsQueue.push(payloads);
                        }
                });

                Echo.connector.pusher.connection.bind("state_change", function(states) {
                    console.log(`Socket is ${states.current}`);
                });
            @endif
        });
        /*
        const toRupiah = (price, decimal = 0) => { 

            return 'Rp ' + Number(price.toFixed(decimal)).toLocaleString().replace(/\./g, "@").replace(/,/g, ".").replace(/@/g, ","); 
        };
        */

        const renderWidget = (payloads) => {
            console.log(payloads,'data');
            $("#example-result").html(JSON.stringify(payloads, null, 2));
            $("#mode").html(`${payloads.test ? "Mode: Test" : ""}`);
            
            // Example notif using sweet alert
            let items = [];
            $.each(payloads.items, (index, value) => {
                const { qty, unit, price } = value;
                const str = ` ${qty} ${unit} senilai ${toIDR(price)}`;

                items.push(str);
            });
            

            let html ='';
            const selector=$('#textdata');
            const card=$('.notification');
            const render =$('#apprender');
            //card.removeClass('d-none');
            if(payloads.new_tip){
                var getData=payloads.new_tip;
                const animate=card.data('direction');
                /*
                html=`
                <h5><small class="text-muted"><i>`+getData.name+`</i></small> </h5>
                    <p>New Tip Received</p>
                    <p>`+getData.template_text+`</p>
                `;
                */
                //selector.html(html);
                //card.addClass(animate);
                //wait( function(){ card.removeClass(animate) }, 2);
                //wait( function(){ card.addClass('d-none') }, duration);
                //tipsQueue.splice(0,1);

                render.html(`
                            <div class="notification  received animate__animated `+direction+` " data-direction=`+direction+`" >
                                <div class="notification__message ">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 img-notif">
                                            <img src="{{ asset('template/images/user/user.png') }}" class="rounded-circle mx-3" alt="Sample Image">
                                        </div>
                                        <div id="textdata" class="flex-grow-1 ms-3">
                                            <h5>New Tip</h5>
                                            <p>`+getData.name+`</p>
                                            <p>`+getData.template_text+`</p>
                                        </div>
                                    </div>
                                    <!-- x icon through a path element -->
                                    <button aria-labelledby="button-dismiss" hidden>
                                        <span id="button-dismiss" hidden>Dismiss</span>
                                        <svg viewBox="0 0 100 100" width="10" height="10">
                                            <!-- group to style the path -->
                                            <g
                                                stroke="currentColor"
                                                stroke-width="6"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                fill="none">
                                                <!-- group to center and rotate the + sign to show an x sign instead -->
                                                <g transform="translate(50 50) rotate(45)">
                                                    <!-- path describing two perpendicular lines -->
                                                    <path
                                                        d="M 0 -30 v 60 z M -30 0 h 60">
                                                    </path>
                                                </g>
                                            </g>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            
                            
                            `);

            }

            

        }
    
        const load=()=>{
            $(function() {
                const notif =$('.notification');
            });
        }
        load();

        const wait= function( callback, seconds){
            return window.setTimeout( callback, seconds * 1000 );
        }
        
    </script>
    @if(@$qParams['iframe'] != 1)
    <script  type="text/javascript"> 
         setInterval(function(){
            if(tipsQueue.length !== 0){
                animation=true;
                $('#apprender').empty();
                renderWidget(tipsQueue[0]);
                tipsQueue.splice(0,1);
            }else{
                $('#apprender').empty();
            }   
        },Interval);
    </script>
    @endif
    

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    @if(!empty($ntf_font))
    <link href="https://fonts.googleapis.com/css?family={{ $ntf_font }}" rel="stylesheet" type="text/css">
    @endif

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('template/css/animate.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/notif.css')}}">
    <style>
        {!! '.notification__message{ background-color  : '.$qParams['ntf_color_1'].'; }' !!}
        {!! '.notification__message{ background-color  : '.$qParams['ntf_color_2'].'; }' !!}
        {!! '.notification { color  : '.$qParams['ntf_color_3'].'; }' !!}

        @media(max-width:320px){
            .notification{
                padding: 0;
            }
            .img-notif img {
                width: 30px;
                height: 30px;
            }
            .message--info{
                background-size: 15px;
            }
            div#textdata h5 {
                font-size: 12px;
                margin-bottom: 5px;
            }
            div#textdata p {
                font-size: 10px;
                margin-bottom: 0px;
            }
            main.py-4 {
                margin-top: -20px;
            }
            img.rounded-circle.mx-3 {
                margin: 15px 10px !important;
            }
            .bd-highlight{
                font-size: 12px;
            }
            .cardnav .bd-highlight {
                font-size: 6px !important;
            }
        }
        @media(max-width:300px){
            .notification__message {
                padding: 5px;
            }
            .img-notif img {
                width: 15x;
                height: 15x;
            }
            img.rounded-circle.mx-3 {
                margin: 8px 5px !important;
            }
            .notification__message{
                margin: 0;
            }div#textdata p {
                font-size: 9px;
                margin-bottom: 0px;
            }
        }

    </style>
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
        
       
       
        <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8" id="apprender" >
                        <div class="notification {{ ($qParams['real_data'])?'d-none':'' }}  received animate__animated {{ $dataArray[$qParams['ntf_direction']] }} positio-relative" data-direction="{{ $dataArray[$qParams['ntf_direction']] }}" >
                            <div class="notification__message ">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 img-notif">
                                        <img src="{{ asset('template/images/user/user.png') }}" class="rounded-circle mx-3" alt="Sample Image">
                                    </div>
                                    <div id="textdata" class="flex-grow-1 ms-3">
                                        <h5>New Tip</h5>
                                        <p>Someone</p>
                                        <p>{{ $qParams['ntf_template_text'] }}</p>
                                    </div>
                                </div>
                                <!-- x icon through a path element -->
                                <button aria-labelledby="button-dismiss" hidden>
                                    <span id="button-dismiss" hidden>Dismiss</span>
                                    <svg viewBox="0 0 100 100" width="10" height="10">
                                        <!-- group to style the path -->
                                        <g
                                            stroke="currentColor"
                                            stroke-width="6"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            fill="none">
                                            <!-- group to center and rotate the + sign to show an x sign instead -->
                                            <g transform="translate(50 50) rotate(45)">
                                                <!-- path describing two perpendicular lines -->
                                                <path
                                                    d="M 0 -30 v 60 z M -30 0 h 60">
                                                </path>
                                            </g>
                                        </g>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="{{asset('template/js/jquery.fontselect.min.js')}}"></script>
    @if(!empty($ntf_font))
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
         useFont('{{ $ntf_font }}');
    </script>
    @endif

</body>
</html>
