@extends('layouts.template-auth')

@section('title', __('page.title_verify_email'))

@section('styles')

@endsection

@section('content')
    <section class="section min-vh-100 m-0">
        <div class="container position-relative pt-3 mt-5">
            <div class="row" data-aos="zoom-in-up" data-aos-duration="1000">
                <div class="col-xl-7 col-lg-6 col-md-4 col-sm-12">
                    {{-- <img src="{{ asset('template/images/bg-auth.svg') }}" alt="" class="img-fluid d-none"> --}}
                </div>
    
                <div class="col-xl-5 col-lg-6 col-md-8 col-sm-12 mx-auto">
                    <div class="card shadow rounded-small border-0 py-3 card-dark">
                        <div class="card-header bg-transparent border-0">
                            <h4 class="fw-semibold">
                                @lang('page.welcome'), 
                                @auth
                                {{ Auth::user()->email }}
                                @endauth
                            </h4>
                        </div>
                        <div class="card-body">
        
                            @include('components.flash-message', ['flashName' => 'resent', 'message' => __('page.fresh_link_sent') ])

                            <p class="p-0 m-0">@lang('page.verification_description')</p>
                            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}" class="needs-validation" id="auth-form" onsubmit="doSubmit($('#btn-submit'))">
                                @csrf
                                <span class="d-inline-block">@lang('page.not_receive_email'),
                                    <button type="submit" id="btn-submit" class="btn btn-link p-0 m-0 align-baseline">@lang('form.btn_click_here_to_resend')</button>.
                                </span>
                            </form>

                            <div class="d-flex align-items-center justify-content-center w-100 mt-3 gap-2">
                                <a href="/" class="btn btn-outline-primary rounded-pill">@lang('form.btn_back_to_home')</a>
                                @auth
                                <form class="d-inline" method="POST" action="{{ route('logout') }}" class="needs-validation" id="auth-logout-form" onsubmit="doSubmit($('#btn-logout-submit'))">
                                    @csrf
                                    <button type="submit" id="btn-logout-submit" class="btn btn-link p-0 m-0 align-baseline">@lang('form.btn_logout')</button>
                                </form>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/utils.js') }}"></script>
@endsection
