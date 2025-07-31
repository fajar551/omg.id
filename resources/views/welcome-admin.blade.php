@extends('layouts.omg-full')

@section('title', __('Comingsoon'))

@section('styles')

@endsection

@section('content')
    <div class="iq-comingsoon pt-5">
        <div class="container">
            <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <div class="iq-comingsoon-info">
                    {{-- <a href="index.html">
                    <img src="{{ asset('template/images/logo.png') }}" class="img-fluid w-50" alt="">
                    </a> --}}
                    <h2 class="mt-4 mb-1">Welcome to Admin Area</h2>
                    <p>If you're not the administrator of this app and if you don't know what you're doing, Please go to <a href="{{ route('home') }}">Creator Page</a> or <a href="{{ route('admin.home') }}">Continue</a> to admin area</p>
                </div>
            </div>
            </div>
            <div class="row justify-content-center">
            <div class="col-lg-4">
                <form class="iq-comingsoon-form mt-5">
                    <div class="social-links">
                        <ul class="social-data-block d-flex align-items-center justify-content-between list-inline p-0 m-0">
                           <li class="text-center pe-3">
                              <a href="#"><img src="{{ asset('template/images/icon/full/08.png')}}" class="img-fluid rounded" alt="facebook"></a>
                           </li>
                           <li class="text-center pe-3">
                              <a href="#"><img src="{{ asset('template/images/icon/full/09.png')}}" class="img-fluid rounded" alt="Twitter"></a>
                           </li>
                           <li class="text-center pe-3">
                              <a href="#"><img src="{{ asset('template/images/icon/full/10.png')}}" class="img-fluid rounded" alt="Instagram"></a>
                           </li>
                           <li class="text-center pe-3">
                              <a href="#"><img src="{{ asset('template/images/icon/full/12.png')}}" class="img-fluid rounded" alt="You tube"></a>
                           </li>
                        </ul>
                     </div>

                    {{-- <div class="form-group">
                        <input type="email" class="form-control comming mb-0" id="exampleInputEmail1"  placeholder="Enter email address">
                        <button type="submit" class="btn btn-primary">Subscribe</button>
                    </div> --}}
                </form>
            </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
       
    </script>
@endsection