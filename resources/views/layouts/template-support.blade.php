<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
   <title>@yield('title')</title>

   <!-- Required meta tags -->
   @include('includes.meta')

   <!-- Vendors -->
   <link rel="shortcut icon" type="image/x-icon" href="{{ asset('template/images/favicon.ico') }}" />
   <link rel="stylesheet" href="{{ asset('template/vendor/bootstrap-5/css/bootstrap.min.css') }}">
   <link rel="stylesheet" href="{{ asset('template/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
   <link rel="stylesheet" href="{{ asset('template/vendor/remixicon/fonts/remixicon.css') }}">
   <link rel="stylesheet" href="{{ asset('template/vendor/sweetalert2/sweetalert2.min.css') }}">
   <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">

   <!-- App Styles -->
   <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/css/preloader.css') }}">

   {{-- Dark Mode --}}
   <link rel="stylesheet" href="{{ asset('template/vendor/dark-mode-switch/dark-mode.css') }}">
   
   <!-- Page Styles -->
   @yield('styles')

   <style>      
      .container-fluid.footer {
         background-color: var(--color-light) !important;
      }

      .card-text.creator {
         font-family: "Helvetica Neue", sans-serif;
         font-style: normal;
         font-weight: 700;
         font-size: 14px;
         text-align: center;
         color: #141414;
      }

      .text-elipsis {
         overflow: hidden;
         text-overflow: ellipsis;
         display: -webkit-box;
         -webkit-line-clamp: 2;
         line-clamp: 2;
         -webkit-box-orient: vertical;
      }

      /* .card.card-content {
         border-radius: var(--border-radius-sm) !important;
         height: 300px; 
         min-height: 300px;
      } */

      .card .content-title {
         min-height: 55px !important;
      }

      .bg-card-creator {
         background: rgba(254, 254, 254, 0.2);
         height: 100%;
         width: 100%;
         border-radius: 0px 0px 8px 8px;
         overflow:hidden ;
         top: 0;
      }
   </style>

</head>

<body class="d-flex flex-column min-vh-100">
   <script>      
      var isdark = localStorage.getItem('darkSwitch');
      if (isdark == "dark") {
         document.body.setAttribute("data-theme","dark");
      }
   </script>
   <div id="loader">
      @include('includes.loader')
   </div>

   <div style="display: none !important;" id="main-content"> 
      @include('includes.header-home')

      @yield('content')

      @include('includes.footer-small')

      <!-- Place the modal outside the aos animate, to avoid break the modal backdrop-->
      <div id="modal-container"></div>

   </div>

   <!-- Vendors -->
   <script type="text/javascript" src="{{ asset('template/vendor/jquery/js/jquery.min.js') }}"></script>
   <script type="text/javascript" src="{{ asset('template/vendor/bootstrap-5/js/popper.min.js') }}"></script>
   <script type="text/javascript" src="{{ asset('template/vendor/bootstrap-5/js/bootstrap.min.js') }}"></script>
   <script type="text/javascript" src="{{ asset('template/vendor/sweetalert2/sweetalert2.min.js') }}"></script>
   <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
   
   <!-- App Scripts -->
   <script type="text/javascript" src="{{ asset('assets/js/scroll.js') }}"></script>
   <script type="text/javascript" src="{{ asset('assets/js/search-explore.js') }}"></script>
   <script type="text/javascript" src="{{ asset('js/axios.js') }}"></script>
   <script type="text/javascript" src="{{ route('lang') }}"></script>
   <script type="text/javascript" src="{{ route('vars.omg.js') }}"></script>

   {{-- Dark Mode --}}
   <script type="text/javascript" src="{{ asset('template/vendor/dark-mode-switch/dark-mode-switch.min.js') }}"></script>
   @auth
   <script type="text/javascript" src="{{ asset('js/echo.js') }}"></script>
   <script type="text/javascript" src="{{ asset('assets/js/notification-v2.1.js') }}"></script>
   @endauth
   <script type="text/javascript">
      /**
       * Aos animation
       */
      window.addEventListener('DOMContentLoaded', (event) => {
         loaderPage();

         setTimeout(() => {
            AOS.init({
               once: true
            });
         }, 500);
      });

      /**
       * Loader
       */
      function loaderPage() {
         document.getElementById("loader").style.display = "none";
         document.getElementById("main-content").style.display = "block";
      }

      /**
       * burgerMenu toggler
       */
      const burgerMenu = document.querySelector('.burger')
      $(document).on('click', '.burger', function(e) {
         burgerMenu.classList.toggle('active');
      })

      $(() => {
         var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-tooltip="tooltip"]'))
         var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
         });

         $('.modal').insertAfter($('#modal-container'));
      });
   </script>

   <!-- Page Scripts -->
   @yield('scripts')
   
</body>

</html>