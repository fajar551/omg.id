<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      
      <title>@yield('title')</title>

      <!-- BASIC STYLES -->
      <link rel="shortcut icon" href="{{ asset('template/images/favicon.ico') }}" />
      <link rel="stylesheet" href="{{ asset('template/css/libs.min.css') }}">
      <link rel="stylesheet" href="{{ asset('template/css/socialv.css?v=4.0.0') }}">
      <link rel="stylesheet" href="{{ asset('template/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
      <link rel="stylesheet" href="{{ asset('template/vendor/remixicon/fonts/remixicon.css') }}">
      <link rel="stylesheet" href="{{ asset('template/vendor/vanillajs-datepicker/dist/css/datepicker.min.css') }}">
      <link rel="stylesheet" href="{{ asset('template/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
      <link rel="stylesheet" href="{{ asset('template/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
      <style>
         .dark section.sign-in-page .bg-white {
            margin-top: 55px;
            margin-bottom: 50px;
            border-radius: 15px;
         }

         @media(max-width: 425px){
            .dark section.sign-in-page .bg-white {
               margin-top: 20px;
               margin-bottom: 15px;
               border-radius: 10px;
            }
         }

         .lds-ripple {
            display: inline-block;
            position: fixed;
            width: 90px;
            height: 91px;
            top: 35%;
            right: 45%;
         }

         .lds-ripple div {
            position: absolute;
            border: 4px solid #fff;
            opacity: 1;
            border-radius: 50%;
            animation: lds-ripple 1s cubic-bezier(0, 0.2, 0.8, 1) infinite;
         }

         .lds-ripple div:nth-child(2) {
            animation-delay: -0.5s;
         }

         @keyframes lds-ripple {
            0% {
               top: 36px;
               left: 36px;
               width: 0;
               height: 0;
               opacity: 1;
            }
            100% {
               top: 0px;
               left: 0px;
               width: 72px;
               height: 72px;
               opacity: 0;
            }
         }

         section.sign-in-page .bg-white {
            margin-top: 55px;
            margin-bottom: 50px;
            border-radius: 15px;
         }

         @media (max-width:2024px){
            .sign-in-page{
                overflow-y:scroll
            }
         }
      </style>
      <!-- END BASIC STYLES -->
      
      <!-- CUSTOM STYLES -->
      @yield('styles')
      <!-- END CUSTOM STYLES -->

      {!! htmlScriptTagJsApi() !!}
   </head>

   <body >
      <!-- loader Start -->
      <div id="loading">
         @include('includes.loader')
      </div>
      <!-- loader END -->
      
      <!-- MAIN CONTENT -->
      <div class="wrapper">
      @yield('content')
      </div>
      <!-- END MAIN CONTENT -->

      <!-- BASIC SCRIPTS -->
      <!-- Backend Bundle JavaScript -->
      <script src="{{ asset('template/js/libs.min.js') }}"></script>
      <!-- slider JavaScript -->
      <script src="{{ asset('template/js/slider.js') }}"></script>
      <!-- masonry JavaScript --> 
      <script src="{{ asset('template/js/masonry.pkgd.min.js') }}"></script>
      <!-- SweetAlert JavaScript -->
      <script src="{{ asset('template/js/enchanter.js') }}"></script>
      <!-- SweetAlert JavaScript -->
      <script src="{{ asset('template/js/sweetalert.js') }}"></script>
      <!-- Chart Custom JavaScript -->
      <script src="{{ asset('template/js/customizer.js') }}"></script>
      <!-- app JavaScript -->
      <script src="{{ asset('template/js/charts/weather-chart.js') }}"></script>
      <script src="{{ asset('template/js/app.js') }}"></script>
      <script src="{{ asset('template/vendor/vanillajs-datepicker/dist/js/datepicker.min.js') }}"></script>
      <script src="{{ asset('template/js/lottie.js') }}"></script>

      <!-- CUSTOM SCRIPTS -->
      @yield('scripts')
      <!-- END CUSTOM SCRIPTS -->

   </body>
</html>
