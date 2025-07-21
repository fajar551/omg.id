@extends('layouts.admin.omg-full')

@section('title', __('page.title_verify_email'))

@section('styles')

@endsection

@section('content')
    <section class="sign-in-page">
        <div id="container-inside">
            <div id="circle-small"></div>
            <div id="circle-medium"></div>
            <div id="circle-large"></div>
            <div id="circle-xlarge"></div>
            <div id="circle-xxlarge"></div>
        </div>
        <div class="container p-0">
            <div class="row no-gutters">
                <div class="col-md-6 text-center pt-5">
                    <div class="sign-in-detail text-white">
                        <a class="sign-in-logo mb-5" href="#"><img src="{{ asset('template/images/logo-full.png') }}" class="img-fluid" alt="logo"></a>
                        <div class="sign-slider overflow-hidden ">
                            <ul  class="swiper-wrapper list-inline m-0 p-0 ">
                                <li class="swiper-slide">
                                    <img src="{{ asset('template/images/login/1.png') }}" class="img-fluid mb-4" alt="logo">
                                    <h4 class="mb-1 text-white">Find new friends</h4>
                                    <p>It is a long established fact that a reader will be distracted by the readable content.</p>
                                </li>
                                <li class="swiper-slide">
                                    <img src="{{ asset('template/images/login/2.png') }}" class="img-fluid mb-4" alt="logo"> 
                                    <h4 class="mb-1 text-white">Connect with the world</h4>
                                    <p>It is a long established fact that a reader will be distracted by the readable content.</p>
                                </li>
                                <li class="swiper-slide">
                                    <img src="{{ asset('template/images/login/3.png') }}" class="img-fluid mb-4" alt="logo">
                                    <h4 class="mb-1 text-white">Create new events</h4>
                                    <p>It is a long established fact that a reader will be distracted by the readable content.</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 bg-white pt-4 pb-lg-5 pb-5">
                    <div class="sign-in-from">
                        <img src="{{ asset('template/images/login/mail.png')}}" width="80"  alt="">
                        <h3 class="mt-3 mb-0">@lang('page.welcome')</h3>
                        @auth
                        <h4 class="mt-1 mb-0">{{ Auth::user()->email }}</h4>
                        @endauth 

                        @include('components.flash-message', ['flashName' => 'resent', 'message' => __('page.fresh_link_sent') ])

                        <p>@lang('page.verification_description')</p>
                        <form class="d-inline" method="POST" action="{{ route('admin.verification.resend') }}" class="mt-4 needs-validation" id="auth-form" onsubmit="doSubmit($('#btn-submit'))">
                            @csrf
                            <span class="dark-color d-inline-block line-height-2">@lang('page.not_receive_email'), 
                                <button type="submit" id="btn-submit" class="btn btn-link p-0 m-0 align-baseline">@lang('form.btn_click_here_to_resend')</button>.
                            </span>
                        </form>
                        
                        @auth
                        <form class="d-inline" method="POST" action="{{ route('admin.logout') }}" class="mt-4 needs-validation" id="auth-logout-form" onsubmit="doSubmit($('#btn-logout-submit'))">
                            @csrf
                            <span class="dark-color d-inline-block line-height-2">@lang('page.or') 
                                <button type="submit" id="btn-logout-submit" class="btn btn-link p-0 m-0 align-baseline">@lang('form.btn_logout')</button>.
                            </span>
                        </form>
                        @endauth 
                        
                        <div class="d-inline-block w-100">
                            <a href="/" class="btn btn-primary mt-3">@lang('form.btn_back_to_home')</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> 
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/utils.js') }}"></script>
    <script type="text/javascript">
        $(() => {
            
        });
    </script>
@endsection