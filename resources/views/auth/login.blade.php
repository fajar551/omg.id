@extends('layouts.template-auth')

@section('title', __('page.title_login'))

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
                            <h2 class="fw-bold text-center">@lang('page.login')</h2>
                        </div>
                        <div class="card-body">
        
                            @include('components.flash-message', ['flashName' => 'message'])
        
                            @if (Route::has('auth.social.provider'))
                                <ul class="nav-link d-grid gap-3 px-md-4 px-0">
                                    @feature('auth_facebook')
                                    <li class="nav-item social-signin text-center">
                                        <a href="{{ url('/auth/facebook') }}" class="btn btn-outline-info rounded-pill w-100 "> 
                                            <i class="fab fa-facebook fs-4 align-middle"></i>
                                            <span class="ms-1">Masuk dengan facebook</span> 
                                        </a>
                                    </li>
                                    @endfeature
                                    @feature('auth_twitter')
                                    <li class="nav-item social-signin text-center">
                                        <a href="{{ url('/auth/twitter') }}" class="btn btn-outline-info rounded-pill w-100">
                                            <i class="fab fa-twitter fs-4 align-middle"></i>
                                            <span class="ms-1"> Masuk dengan twitter</span>
                                        </a>
                                    </li>
                                    @endfeature
                                    @feature('auth_google')
                                    <li class="nav-item social-signin text-center">
                                        <a href="{{ url('/auth/google') }}" class="btn btn-outline-info rounded-pill w-100">
                                            <i class="fab fa-google fs-4 align-middle"></i>
                                            <span class="ms-1">Masuk dengan google</span>
                                        </a>
                                    </li>
                                    @endfeature
                                </ul>
                                @if (Features::accessible('auth_facebook') || Features::accessible('auth_twitter') || Features::accessible('auth_google'))
                                <div class="px-5 mb-4">
                                    <div class="d-flex justify-content-center border-bottom">
                                        <h5>atau</h5>
                                    </div>
                                </div>
                                @endif
                            @endif
        
                            <form method="POST" action="{{ route('login') }}" class="needs-validation" id="auth-form" onsubmit="doSubmit($('#btn-submit'))">
                                @csrf
                                <div class="form-group mb-3">
                                    <label class="form-label" for="email">@lang('form.lbl_email_or_username') <span class="text-danger">*</span></label>
                                    <input name="identity" type="text" class="form-control form-rounded-pill @error('identity') is-invalid @enderror" id="email" placeholder="budi@mail.com" required value="{{ old("identity") }}" autofocus>
                                    @error('identity')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label" for="password">@lang('form.lbl_password') <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input name="password" type="password" class="form-control form-rounded-pill control-group pe-5 @error('password') is-invalid @enderror" id="password" placeholder="Budi123" required autocomplete="current-password">
                                        <span class="input-group-text group-addon">
                                            <i class="far fa-eye-slash" onclick="showHidePassword(this, $('#password'))"></i>
                                        </span>
                                    </div>
                                    <input type="hidden" class="@error('password') is-invalid @enderror">
                                    @error('identity')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                                <div class="d-flex align-items-center justify-content-between w-100">
                                    <div class="form-check d-inline-block mt-2">
                                        <input name="remember" type="checkbox" class="form-check-input" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember">@lang('form.lbl_remember_me')</label>
                                    </div>
                                    @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="float-end pt-2 forgot-pass-label">@lang('form.lbl_forgot_your_password')</a>
                                    @endif
                                </div>
                                <button type="submit" id="btn-submit" class="btn rounded-pill btn-primary w-100 btn-block mb-3 mt-4">@lang('form.btn_login')</button>
                            </form>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            @if (Route::has('register'))
                            <div class="sign-info text-center">
                                <span class="dark-color d-inline-block line-height-2">@lang('page.dont_have_an_account')
                                    <a href="{{ route('register') }}">@lang('form.btn_register')</a>
                                </span>
                            </div>
                            @endif
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
