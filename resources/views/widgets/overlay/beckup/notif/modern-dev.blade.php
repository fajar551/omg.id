
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
    <link rel="stylesheet" href="{{asset('assets/notif.css')}}">

    <!-- Scripts -->
    {{--
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    --}}
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/echo.js') }}"></script>

    {{-- Added 08-03-2022 10:13 --}}
    <script src="{{ asset('assets/js/omg-widget.js') }}"></script>
  
    <script  type="text/javascript"> 
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
                    "reloadWidget": reloadWidget,
                });
            }

            // To get query params https://flaviocopes.com/urlsearchparams/
            const params = new URLSearchParams(window.location.search);

            Echo.channel("stream.newtip.{{ $streamKey }}")
                .listen('.stream.newtip', (data) => {
                    const { payloads } = data;

                    renderWidget(payloads);
                });

                

        });

        // const toIDR = (price, decimal = 0) => { 
        //     return 'Rp ' + Number(price.toFixed(decimal)).toLocaleString().replace(/\./g, "@").replace(/,/g, ".").replace(/@/g, ","); 
        // };

        const renderWidget = (payloads) => {
            console.log(payloads);
            $("#example-result").html(JSON.stringify(payloads, null, 2));
            $("#mode").html(`${payloads.test ? "Mode: Test" : ""}`);
            
            // Example notif using sweet alert
            let items = [];
            $.each(payloads.items, (index, value) => {
                const { qty, unit, price } = value;
                const str = ` ${qty} ${unit} senilai ${toIDR(price)}`;

                items.push(str);
            });

            $('#discord-shoutout').addClass('online');
            $('.notification').addClass('received');
            setTimeout(function(){
                $('#discord-shoutout').removeClass('online');
                $('.notification').removeClass('received');
            },5000);

            /* let messageBody = `OMG..!! ${payloads.supporter_name} baru saja mendukungmu dengan memberikan:<br>`; 
            messageBody += `${items.join("<br>")}`; 
            messageBody += `<br><br>`; 
            messageBody += `<strong>Pesan: ${payloads.supporter_message}</strong>`; 

            Toast.fire({
                icon: 'info',
                title: `New Tip Received ${payloads.test ? '(Test)' : ''}`,
                html: `${messageBody}`,
                confirmButtonText: `OK!`,
            }); */

        }

       
        
        
       

    
    </script>

    
</head>
<body>
    <div id="app">
    {{--
        @php(dd($qParams));
    --}}

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
        @if($qParams['ntf_color_1'])
         <style>
            .discord-shoutout{
               filter: drop-shadow({{ $qParams['ntf_color_1'] }} 10px 8px 0px);
            }
         </style>
         @endif
         @if($qParams['ntf_color_2'])
         <style>
               .discord-shoutout .shoutout-inner:after, .discord-shoutout .shoutout-inner:before {
                  background-color: {{$qParams['ntf_color_2']}};
               }
         </style>
         @endif
         @if($qParams['ntf_color_3'])
         <style>
               .shoutout-inner{
                  color : {{ $qParams['ntf_color_3'] }};
               }
         </style>
         @endif



        <main class="py-4">

        
             <div id="discord-shoutout" class="discord-shoutout online ">
                <div class="shoutout-inner">
                    <img src="{{ asset('template/images/user/1.jpg') }}">
                    <span class="title">OMG..!! Qwords</span>
                    <p>
                    New Tip Received
                    </p>
                    <p>
                    baru saja mendukungmu dengan memberikan:
                    </p>
                    <p> Pesan : {{ $qParams['ntf_template_text'] }}</p>
                    <div class="discord-buttons">
                        <!--<a class="discord-button discord-primary" href="https://discord.gg/2nrFVCp" target="_blank">Ok</a> -->
                        <button class="discord-button discord-primary" onclick="hide()">Ok</button>
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

</html>
