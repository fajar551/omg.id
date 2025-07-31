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

      @include('includes.footer-home')

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
      });

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
   
   <!-- Midtrans Snap.js for Sandbox -->
   <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-yXcEzjhVAqWaf3qm"></script>
</body>

</html>