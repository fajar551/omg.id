@extends('layouts.template-auth')

@section('title', __('page.title_register'))

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
        margin-left: 70px !important;
    }

    .tes {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 999;
    }

    .footer-1 {
        margin-left: 70px !important;
    }

    nav.mg-auth {
        border-radius: 0px 0px 30px 30px;
        /* z-index: 2; */
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

<section class="vh-100 container-fluid p-0 m-0">

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
        <img src="{{ asset('template/images/bg-auth.svg') }}" alt="" class="img-fluid img">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-4 col-md-7 col-sm-12 col-form col-formlogin mx-auto ">
                    <div class="card-body mt-4 mx-3">
                        <h3 class="mb-3">@lang('page.register')</h3>
                        <!-- <p>@lang('page.register_description')</p> -->

                        @include('components.flash-message', ['flashName' => 'message'])

                        <form method="POST" action="{{ route('register') }}" class="mt-4 needs-validation" id="auth-form" onsubmit="doSubmit($('#btn-submit'))">
                            @csrf
                            <div class="form-group mb-3">
                                <label class="form-label" for="username">@lang('form.lbl_username') * @lang('form.lbl_username_rule')</label>
                                <input name="username" type="text" id="username" class="form-control rounded-pill mb-0 @error('username') is-invalid @enderror" value="{{ old("username") }}" placeholder="@lang('form.lbl_username')" required autocomplete="username" autofocus>
                                @error('username')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="name">@lang('form.lbl_full_name') *</label>
                                <input name="name" type="text" id="name" class="form-control rounded-pill mb-0 @error('name') is-invalid @enderror" value="{{ old("name") }}" placeholder="@lang('form.lbl_full_name')" required autocomplete="name">
                                @error('name')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="email">@lang('form.lbl_email') *</label>
                                <input name="email" type="email" id="email" class="form-control rounded-pill mb-0 @error('email') is-invalid @enderror" value="{{ old("email") }}" placeholder="budi@mail.com" required autocomplete="email">
                                @error('email')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="password">@lang('form.lbl_password') *</label>
                                <div class="input-group">
                                    <input name="password" type="password" id="password" class="form-control rounded-pill mb-0 @error('password') is-invalid @enderror" placeholder="Budi123" required autocomplete="new-password">
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
                            <div class="form-group mb-3">
                                <label class="form-label" for="confirm-password">@lang('form.lbl_confirm_password') *</label>
                                <div class="input-group">
                                    <input name="password_confirmation" id="confirm-password" type="password" class="form-control rounded-pill mb-0 @error('password') is-invalid @enderror" placeholder="Budi123" required autocomplete="new-password">
                                    <!-- <span class="input-group-text">
                                        <i class="far fa-eye-slash" onclick="showHidePassword(this, $('#confirm-password'))"></i>
                                    </span> -->
                                </div>
                            </div>
                            <div class="form-group mb-3">
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
                            </div>
                            <div class="d-inline-block w-100 mb-3">
                                <div class="form-check d-inline-block mt-1 pt-1">
                                    <input type="checkbox" class="form-check-input" id="customCheck1">
                                    <label class="form-check-label" for="customCheck1">@lang('page.i_accept') <a href="#">@lang('page.terms_and_condition')</a></label>
                                </div>
                                <button type="submit" id="btn-submit" disabled class="btn btn-primary float-end">@lang('form.btn_register')</button>
                            </div>
                            <div class="sign-info mb-3">
                                @if (Route::has('login'))
                                <span class="dark-color d-inline-block line-height-2">@lang('page.already_have_an_account')
                                    <a href="{{ route('login') }}">@lang('form.btn_login')</a>
                                </span>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="w-100  position-fixed bottom-0 ">
        <div class="mg-auth">
            <nav class="navbar footer-1  navbar-light right-light px-5">
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

    function recaptchaCallback() {
        $('#btn-submit').attr({
            "disabled": false
        });
    }

    function recaptchaExpireCallback() {
        $('#btn-submit').attr({
            "disabled": true
        });
    }
</script>
@endsection