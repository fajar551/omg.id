@extends('layouts.template-auth')

@section('title', __('page.title_register'))

@section('styles')
    {!! htmlScriptTagJsApi() !!}
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
                            <h2 class="fw-bold text-center">@lang('page.register')</h2>
                        </div>
                        <div class="card-body">
        
                            @include('components.flash-message', ['flashName' => 'message'])
        
                            <form method="POST" action="{{ route('register') }}" class="needs-validation" id="auth-form" onsubmit="doSubmit($('#btn-submit'))">
                                @csrf
                                <div class="form-group mb-3">
                                    <label class="form-label" for="username">@lang('form.lbl_username') <span class="text-danger">*</span></label>
                                    <input name="username" type="text" id="username" class="form-control form-rounded-pill @error('username') is-invalid @enderror" value="{{ old("username") }}" placeholder="budi" required autocomplete="username" autofocus>
                                    <small>*) @lang('form.lbl_username_rule')</small>
                                    @error('username')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label" for="name">@lang('form.lbl_full_name') <span class="text-danger">*</span></label>
                                    <input name="name" type="text" id="name" class="form-control form-rounded-pill @error('name') is-invalid @enderror" value="{{ old("name") }}" placeholder="Budi Luhur" required autocomplete="name">
                                    @error('name')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label" for="email">@lang('form.lbl_email') <span class="text-danger">*</span></label>
                                    <input name="email" type="email" id="email" class="form-control form-rounded-pill @error('email') is-invalid @enderror" value="{{ old("email") }}" placeholder="budi@mail.com" required autocomplete="email">
                                    @error('email')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group form-group-invalid mb-3">
                                    <label class="form-label" for="password">@lang('form.lbl_password') <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input name="password" type="password" id="password" class="form-control form-rounded-pill control-group pe-5 @error('password') is-invalid @enderror" placeholder="Budi123" required autocomplete="new-password">
                                        <span class="input-group-text group-addon">
                                            <i class="far fa-eye-slash" onclick="showHidePassword(this, $('#password'))"></i>
                                        </span>
                                    </div>
                                    <input type="hidden" class="@error('password') is-invalid @enderror">
                                    @error('password')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label" for="confirm-password">@lang('form.lbl_confirm_password') <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input name="password_confirmation" id="confirm-password" type="password" class="form-control form-rounded-pill control-group pe-5 @error('password') is-invalid @enderror" placeholder="Budi123" required autocomplete="new-password">
                                        <span class="input-group-text group-addon">
                                            <i class="far fa-eye-slash" onclick="showHidePassword(this, $('#confirm-password'))"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label" for="">@lang('form.lbl_recaptcha') <span class="text-danger">*</span></label>
                                    <div class="table-responsive">
                                    {!! htmlFormSnippet(["callback" => "recaptchaCallback", "expired-callback" => "recaptchaExpireCallback", ]) !!}
                                    </div>
                                    @error('g-recaptcha-response')
                                    <div class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                                <div class="d-inline-block w-100 mb-3">
                                    <div class="form-check d-inline-block mt-1 pt-1">
                                        <input type="checkbox" class="form-check-input" id="accept-term">
                                        <label class="form-check-label" for="accept-term">@lang('page.i_accept') <a href="{{ route('pages.termofservice') }}" target="_blank">@lang('page.terms_and_condition')</a></label>
                                    </div>
                                    <button type="submit" disabled id="btn-submit" class="btn rounded-pill btn-primary w-100 btn-block mt-4">@lang('form.btn_register')</button>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            @if (Route::has('login'))
                                <div class="sign-info text-center">
                                    <span class="dark-color d-inline-block line-height-2 ">@lang('page.already_have_an_account')
                                        <a class="text-center" href="{{ route('login') }}">@lang('form.btn_login')</a>
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
    <script type="text/javascript">

        let termChecked, captchaChecked = false;

        $(() => {
            $('#accept-term').on('change', function() {
                termChecked = $(this).is(':checked');
                enableBtnRegist();
            });
        });

        function recaptchaCallback() {
            captchaChecked = true;
            enableBtnRegist();
        }

        function recaptchaExpireCallback() {
            captchaChecked = false;
            enableBtnRegist();
        }

        function enableBtnRegist() {
            $('#btn-submit').attr({
                "disabled": !(termChecked && captchaChecked),
            });
        }
    </script>
@endsection
