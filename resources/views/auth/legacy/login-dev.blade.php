@extends('layouts.template-auth')

@section('title', __('page.title_login'))

@section('styles')

<style>
    li.nav-item {
        list-style: none;
    }

    a {
        text-decoration: none;
    }

    .navbar {
        width: 90% !important;
    }

    /* .col-form {
        z-index: -1;
    } */

    .mg-auth {
        margin-left: 60px !important;
    }

    .tes {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
    }

    .footer-1 {
        margin-left: 60px !important;
    }

    nav.mg-auth {
        border-radius: 0px 0px 30px 30px;

    }

    .card {
        z-index:  !important;
    }



    nav.footer-1 {
        border-radius: 30px 30px 0px 0px;

    }

    .img {
        height: 100vh;
    }
</style>

@endsection

@section('content')


<section class="container-fluid p-0 m-0 ">
    <div class="w-100  tes ">
        <div class="mg-auth">
            <nav class="navbar mg-auth  navbar-light right-light">
                <div class="container d-flex justify-content-center">
                    <a class="navbar-brand text-warning " href="#">
                        <img src="{{ asset('template/images/omg.png') }}" alt="" class="" width="30" height="30">
                        OMG
                    </a>
                </div>
            </nav>
        </div>
    </div>
    <div class="d-flex align-items-center">
        <img src="{{ asset('template/images/bg-auth.svg') }}" alt="" class="img-fluid ">

        <div class="container ">
            <div class="d-flex justify-content-center">
                <div class="col-md-8 col-form bg-white pt-4 pb-lg-5 px-5 mc-3 pb-5">
                    <h3 class="mb-5 fw-semibold">@lang('page.login')</h3>
                    <!-- <p>@lang('page.login_description')</p> -->


                    @if (Route::has('auth.social.provider'))
                    <ul class="iq-social-media">
                        <li class="nav-item border rounded-pill p-2 text-center"><a href="{{ url('/auth/facebook') }}"> <img src="{{ asset('template/images/faceebook.svg') }}" alt="" class="" width="30" height="30"> <span class="mx-2">Masuk dengan facebook</span> </a></li>
                        <li class="nav-item border rounded-pill p-2 my-3 text-center"><a href="{{ url('/auth/twitter') }}"><img src="{{ asset('template/images/twiter.svg') }}" alt="" class="" width="30" height="30"><span class="mx-2"> Masuk dengan twiter</span></a></li>
                        <li class="nav-item border rounded-pill p-2 text-center"><a href="{{ url('/auth/google') }}"><img src="{{ asset('template/images/google.svg') }}" alt="" class="" width="30" height="30"> <span class="mx-2">Masuk dengan google</span></a></li>
                    </ul>
                    @endif


                    @include('components.flash-message', ['flashName' => 'message'])

                    <div class="d-flex justify-content-center">
                        <div>
                            <hr>
                        </div>
                        <div>
                            <h5>Atau</h5>
                        </div>
                        <div>
                            <hr>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('login') }}" class="mt-4 needs-validation" id="auth-form" onsubmit="doSubmit($('#btn-submit'))">
                        @csrf
                        <div class="form-group mb-3">
                            <label class="form-label" for="email">@lang('form.lbl_email_or_username') *</label>
                            <input name="identity" type="text" class="form-control rounded-pill mb-0 @error('identity') is-invalid @enderror" id="email" placeholder="@lang('form.lbl_email_or_username')" required value="{{ old("identity") }}" autofocus>
                            @error('identity')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="password">@lang('form.lbl_password') *</label>
                            @if (Route::has('password.request'))

                            @endif
                            <div class="input-group">
                                <input name="password" type="password" class="form-control  rounded-pill mb-0 @error('password') is-invalid @enderror" id="password" placeholder="Password" required autocomplete="current-password">
                                <!-- <span class="input-group-text">
                                            <i class="far fa-eye-slash" onclick="showHidePassword(this, $('#password'))"></i>
                                        </span> -->
                                @error('password')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>
                        {{-- <div class="form-group">
                            <label class="form-label" for="">@lang('form.lbl_recaptcha') *</label>
                            {!! htmlFormSnippet([
                                "callback" => "recaptchaCallback",
                                "expired-callback" => "recaptchaExpireCallback",
                            ]) !!}
                            @error('g-recaptcha-response')
                            <div class="text-danger">
                                <strong>{{ $message }}</strong>
                </div>
                @enderror
            </div> --}}
            <div class="d-inline-block mb-3 w-100">
                <div class="form-check d-inline-block mt-2 pt-1">
                    <input name="remember" type="checkbox" class="form-check-input" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">@lang('form.lbl_remember_me')</label>
                </div>
                <a href="{{ route('password.request') }}" class="float-end">@lang('form.lbl_forgot_your_password')</a>

            </div>
            <button type="submit" id="btn-submit" class="btn rounded-pill btn-primary w-100 btn-block mb-3">@lang('form.btn_login')</button>

            <div class="sign-info text-center">
                @if (Route::has('register'))
                <span class="dark-color d-inline-block line-height-2">@lang('page.dont_have_an_account')
                    <a href="{{ route('register') }}">@lang('form.btn_register')</a>
                </span>
                @endif

            </div>
            </form>
        </div>
    </div>
    </div>
    </div>

    <div class="w-100 s position-fixed bottom-0">
        <div class="mg-auth shadow">
            <nav class="navbar footer-1 shadow  navbar-light right-light px-5">
                <div class="cols pt-1">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link footer" aria-current="page" href="#">@lang('page.terms_and_condition')</a>
                        </li>
                        <li class="nav-item ">
                            <div class="pt-1">
                                <svg width="6" height="6" viewBox="0 0 6 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="3" cy="3" r="3" fill="#7422D6" />
                                </svg>

                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link footer" href="#">@lang('page.privacy_police')</a>
                        </li>
                    </ul>
                </div>

                <div class="cols pt-1">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link footer" aria-current="page" href="#">omg.id</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/utils.js') }}"></script>
<script type="text/javascript">
    $(() => {

    });

    // function recaptchaCallback() {
    //     $('#btn-submit').attr({"disabled": false});
    // }

    // function recaptchaExpireCallback() {
    //     $('#btn-submit').attr({"disabled": true});
    // }
</script>
@endsection