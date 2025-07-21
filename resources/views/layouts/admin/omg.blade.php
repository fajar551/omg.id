<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <meta name="auth" content="@if(Session::has('access_token')) {{ Session::get('access_token') }} @endif">
   <title>@yield('title')</title>

   @include('includes.admin.styles')

   @yield('styles')
</head>

{{-- tes branch --}}
<body class="">
   {{-- <div id="loading">
      @include('includes.loader')
   </div> --}}
   
   <div class="wrapper">
      @include('includes.admin.header')

      @include('includes.admin.sidebar')
      
      <div id="content-page" class="content-page">
         <div class="custom-box">
            @yield('content')
         </div>
      </div>
   </div>

   <div class="wrapper">
      <div class="content-page-footer">
         <div class="custom-box">
         @include('includes.admin.footer')
         </div>
      </div>
   </div>
   
   @include('includes.admin.scripts')

   @yield('scripts')

   <script src="{{ asset('js/echo.js') }}"></script>
   <script src="{{ asset('assets/js/scroll.js') }}"></script>
   <script src="{{ asset('assets/js/notification-v2.1.js') }}"></script>

</body>

</html>