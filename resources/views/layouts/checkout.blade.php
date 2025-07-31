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
      
      /* Product Responsive Global */
      .product-card, .product-card-public {
         transition: all 0.3s ease;
      }
      
      .product-image {
         object-fit: cover;
         width: 100%;
         -webkit-user-select: none;
         -moz-user-select: none;
         -ms-user-select: none;
         user-select: none;
         -webkit-user-drag: none;
         -khtml-user-drag: none;
         -moz-user-drag: none;
         -o-user-drag: none;
         user-drag: none;
         pointer-events: none;
      }
      
      .product-badge {
         font-size: 0.8em !important;
         padding: 4px 12px !important;
         border-radius: 6px !important;
      }
      
      .product-title {
         font-size: 0.9rem;
         line-height: 1.3;
         min-height: 2.4rem;
      }
      
      .product-location {
         font-size: 0.75rem;
      }
      
      .product-price {
         font-size: 0.8rem;
      }
      
      /* Mobile Responsive */
      @media (max-width: 767.98px) {
         .product-card, .product-card-public {
            min-height: 250px;
         }
         
         .product-image {
            height: 140px !important;
         }
         
         .product-title {
            font-size: 0.85rem;
            min-height: 2.2rem;
         }
         
         .product-badge {
            font-size: 0.7em !important;
            padding: 3px 8px !important;
         }
         
         .payment-method-name {
            font-size: 0.7rem;
         }
      }
      
      @media (max-width: 575.98px) {
         .product-card, .product-card-public {
            min-height: 220px;
         }
         
         .product-image {
            height: 120px !important;
         }
         
         .product-title {
            font-size: 0.8rem;
            min-height: 2rem;
         }
         
         .payment-method-name {
            display: none;
         }
         
         .payment-logo {
            width: 35px !important;
            height: 22px !important;
            font-size: 8px !important;
         }
      }
      
      /* Tablet Responsive */
      @media (min-width: 768px) and (max-width: 991.98px) {
         .product-card, .product-card-public {
            min-height: 260px;
         }
         
         .product-image {
            height: 150px !important;
         }
         
         .product-title {
            font-size: 0.88rem;
         }
      }
      
      /* Ensure consistent card heights */
      .card-body {
         display: flex;
         flex-direction: column;
      }
      
      .content-title {
         flex-grow: 1;
      }
      
      /* Fix for flex layout on mobile */
      @media (max-width: 767.98px) {
         .d-flex.flex-column.flex-sm-row {
            align-items: center;
         }
         
         .product-purchase-image, .product-payment-image {
            margin-bottom: 1rem;
         }
      }
      
      /* Prevent right-click and drag on product images */
      .product-purchase-image, .product-payment-image {
         -webkit-user-select: none;
         -moz-user-select: none;
         -ms-user-select: none;
         user-select: none;
         -webkit-user-drag: none;
         -khtml-user-drag: none;
         -moz-user-drag: none;
         -o-user-drag: none;
         user-drag: none;
         pointer-events: none;
      }
      
      /* Global protection for all product images */
      img[src*="storage/products"], 
      img[src*="assets/img/image.png"],
      .card-header-bg,
      .product-image,
      .product-purchase-image,
      .product-payment-image {
         -webkit-user-select: none !important;
         -moz-user-select: none !important;
         -ms-user-select: none !important;
         user-select: none !important;
         -webkit-user-drag: none !important;
         -khtml-user-drag: none !important;
         -moz-user-drag: none !important;
         -o-user-drag: none !important;
         user-drag: none !important;
         pointer-events: none !important;
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
      <!-- No header/navbar for checkout pages -->

      <section class="section min-vh-100 bg-light m-0">
         <div class="px-lg-5 px-3 pt-lg-5 pt-md-4 pt-1 mt-5" data-aos="zoom-in-up" data-aos-duration="800">
            @yield('content')
         </div>
      </section>

      <!-- No footer for checkout pages -->

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
   {{-- <script type="text/javascript" src="{{ asset('assets/js/notification-v2.1.js') }}"></script> --}}
   @endauth
   @desktop
   <script>
         vars.tour = JSON.parse('{!! \Utils::getGuide() !!}');
   </script>    
   @enddesktop
   <script type="text/javascript">
      const api_url = '{!! url('api') !!}/';
      const app_url = '{!! url('') !!}/';

      /**
       * Prevent right-click on product images
       */
      document.addEventListener('DOMContentLoaded', function() {
         const productImages = document.querySelectorAll('.product-image, .product-purchase-image, .product-payment-image');
         
         productImages.forEach(function(img) {
            img.addEventListener('contextmenu', function(e) {
               e.preventDefault();
               return false;
            });
            
            img.addEventListener('dragstart', function(e) {
               e.preventDefault();
               return false;
            });
         });
         
         // Global protection for all product images
         const allProductImages = document.querySelectorAll('img[src*="storage/products"], img[src*="assets/img/image.png"], .card-header-bg');
         
         allProductImages.forEach(function(img) {
            img.addEventListener('contextmenu', function(e) {
               e.preventDefault();
               return false;
            });
            
            img.addEventListener('dragstart', function(e) {
               e.preventDefault();
               return false;
            });
            
            img.addEventListener('selectstart', function(e) {
               e.preventDefault();
               return false;
            });
         });
      });

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

      const myOffcanvas = document.getElementById('offcanvasExample')
      myOffcanvas.addEventListener('shown.bs.offcanvas', function () {
         burgerMenu.classList.toggle('active');
      })

      $(document).on('click', '.shepherd-cancel-icon', function(e) {
         updateGuide();
      });

      $(document).on('click', '.shepherd-button', function(e) {
         updateGuide();
      });

      function updateGuide() {
         $.ajax({
            url: api_url + 'guide/update',
            type: 'POST',
            data: {
               _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
               console.log('Guide updated');
            }
         });
      }
   </script>

   <!-- Midtrans Snap.js for Sandbox -->
   <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-yXcEzjhVAqWaf3qm"></script>
   @yield('scripts')
</body>
</html> 