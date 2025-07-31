@extends('layouts.template-error')

@section('content')
<div class="container p-0" style="height: 100vh;" >
   <div class="row no-gutters height-self-center mb-5">
      <div class="col-sm-12 text-center align-self-center pt-3">

      <img src="{{ asset('template/images/error') }}/@yield('code').png" class="img-fluid" alt="" style="height: auto;" >
         <div class="">
            <h2 class="text-4xl fw-bold text-center color-palette-1 mb-3">Oops! @yield('title')</h2>
            <p class="text-lg text-center color-palette-1 m-0">@yield('message')</p>
         </div>

         @auth
         <a class="btn btn-lg btn-primary rounded-pill mt-3"  href="{{ auth()->user()->hasRole(['admin', 'moderator']) ? route('admin.home') : route('home') }}" role="button" >Home</a>
         @else
            @if (request()->segment(1) == 'backend' && request()->segment(2) == 'admin')
            <a class="btn btn-lg btn-primary rounded-pill mt-3"  href="{{ route('admin.home') }}" role="button" >Home</a>
            @else 
            <a class="btn btn-lg btn-primary rounded-pill mt-3"  href="{{ route('home') }}" role="button" >Home</a>
            @endif
         @endauth

         <!-- <div class="">
               <h1 class="mb-0 mt-3 text-center fw-bold">Oops! @yield('title')</h1>
                <h4 class="text-center">@yield('message')</h4>
                @auth
                <a class="btn btn-primary mt-3" href="{{ auth()->user()->hasRole('creator') ? route('home') : route('admin.home') }}">
                  <i class="ri-home-4-line"></i> Back to Homefcdgxx
                </a>
                @endauth
               </div> -->

      </div>
   </div>
</div>
@endsection