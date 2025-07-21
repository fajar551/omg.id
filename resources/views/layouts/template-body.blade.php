<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
   @yield('title')

   <!-- Required meta tags -->
   @include('includes.meta')

   <!-- Vendors -->
   <link rel="shortcut icon" type="image/x-icon" href="{{ asset('template/images/favicon.ico') }}" />
   <link rel="stylesheet" href="{{ asset('template/vendor/bootstrap-5/css/bootstrap.min.css') }}">
   <link rel="stylesheet" href="{{ asset('template/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
   <link rel="stylesheet" href="{{ asset('template/vendor/remixicon/fonts/remixicon.css') }}">
   <link rel="stylesheet" href="{{ asset('template/vendor/sweetalert2/sweetalert2.min.css') }}">
   <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/shepherd.js@8.3.1/dist/css/shepherd.css"/>

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
         z-index: -1;
      }

      .card-balance .card {
         min-height: 220px;
         background-position: center;
         background-repeat: no-repeat;
         background-size: cover;
      }

      .card-bg1 {
         background-image: url('/template/images/bg-1.png');
      }

      .card-bg2 {
         background-image: url('/template/images/bg-2.png');
      }

      .card-bg3 {
         background-image: url('/template/images/bg-3.png');
      }

      .card-bg4 {
         background-image: url('/template/images/bg-4.png');
      }

      .social-label {
         border-top-left-radius: var(--border-radius-xs) !important;
         border-bottom-left-radius: var(--border-radius-xs) !important;
      }

      .nav-link .icon-active {
         display: none;
      }
      
      .nav-link.active .icon-nav {
         display: none;
      }

      .nav-link.active .icon-active {
         display: block;
      }
      
      .list-group-item.active {
         border-top-right-radius: 50px !important;
         border-bottom-right-radius: 50px !important;
      }
      
      .nav-item.active .nav-link.active {
         color: var(--color-text-primary) !important;
         font-weight: 700;
      }  

      @media(max-width: 767.98px) {
         .container.px-5 {
               padding: 0 10px !important;
         }
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
      @include('includes.header-dashboard')

      <section class="section min-vh-100 bg-light m-0">
         <div class="px-lg-5 px-3 pt-lg-5 pt-md-4 pt-1 mt-5" data-aos="zoom-in-up" data-aos-duration="800">
            @yield('content')
         </div>
      </section>

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
   <script src="https://cdn.jsdelivr.net/npm/shepherd.js@8.3.1/dist/js/shepherd.min.js"></script>
   
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
   @desktop
   <script>
         vars.tour = JSON.parse('{!! \Utils::getGuide() !!}');
   </script>    
   @enddesktop
   @if (activeRouteName('supporter.*'))
      <script type="text/javascript" src="{{ asset('assets/js/guide/navbarsupporter.js') }}"></script>
   @else
      <script type="text/javascript" src="{{ asset('assets/js/guide/navbar.js') }}"></script>
   @endif
   <script type="text/javascript">
      const api_url = '{!! url('api') !!}/';
      const app_url = '{!! url('') !!}/';

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


      // $(window).on("shown.bs.modal", function() {
      //    AOS.init({disable:true});
      // });

      // $(window).on("hidden.bs.modal", function() {
      //    AOS.init({disable:false});
      // });

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

      const myOffcanvas = document.getElementById('offcanvasExample')
      myOffcanvas.addEventListener('shown.bs.offcanvas', function () {
         burgerMenu.classList.toggle('active');
      })

      $(document).on('click', '.shepherd-cancel-icon', function(e) {
         updateGuide();
      });

      $(document).on('click', '.shepherd-cancel', function(e) {
         updateGuide();
      });

      const updateGuide = async () => {
         await axios.post('/api/guideupdate', { route: '{{\Route::currentRouteName()}}' });
      };

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