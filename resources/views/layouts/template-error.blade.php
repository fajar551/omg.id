<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>@yield('title')</title>
    
    <!-- Required meta tags -->
    @include('includes.meta')

    <!-- Vendors -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('template/images/favicon.ico') }}" />
    <link rel="stylesheet" href="{{ asset('template/vendor/bootstrap-5/css/bootstrap.min.css') }}">

    <!-- App Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/preloader.css') }}">

    @yield('styles')

</head>

<body class="d-flex flex-column min-vh-100">
    <div id="loader">
        @include('includes.loader')
    </div>

    <div class="pb-5" style="display: none !important;" id="main-content">

        @yield('content')

    </div>

    <!-- Vendors -->
    <script type="text/javascript" src="{{ asset('template/vendor/jquery/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('template/vendor/bootstrap-5/js/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('template/vendor/bootstrap-5/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript">
        window.addEventListener('DOMContentLoaded', (event) => {
            loaderPage();
        });

        /**
         * Loader
         */
        function loaderPage() {
            document.getElementById("loader").style.display = "none";
            document.getElementById("main-content").style.display = "block";
        }
    </script>

    <!-- Page Scripts -->
    @yield('scripts')

</body>

</html>
