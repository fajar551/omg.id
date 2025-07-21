@extends('layouts.template-auth')

@section('title', __('page.title_reset_password'))

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
                            <h2 class="fw-bold text-center">@lang('page.reset_password')</h2>
                        </div>
                        <div class="card-body">
        
                            @include('components.flash-message', ['flashName' => 'status'])
        
                            <form method="POST" action="{{ route('password.update') }}" class="mt-4 needs-validation" id="auth-form" onsubmit="doSubmit($('#btn-submit'))">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="email">@lang('form.lbl_email') <span class="text-danger">*</span></label>
                                    <input name="email" type="email" value="{{ $email ?? old('email') }}" hidden>
                                    <input type="email" class="form-control form-rounded-pill @error('email') is-invalid @enderror" id="email" placeholder="@lang('form.lbl_email')" required value="{{ $email ?? old('email') }}" autocomplete="email" readonly>
                                    @error('email')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label" for="password">@lang('form.lbl_password') <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input name="password" type="password" id="password" class="form-control form-rounded-pill control-group pe-5 @error('password') is-invalid @enderror" placeholder="@lang('form.lbl_password')" required autocomplete="new-password" autofocus>
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
                                        <input name="password_confirmation" id="confirm-password" type="password" class="form-control form-rounded-pill control-group pe-5 @error('password') is-invalid @enderror" placeholder="@lang('form.lbl_confirm_password')" required autocomplete="new-password">
                                        <span class="input-group-text group-addon">
                                            <i class="far fa-eye-slash" onclick="showHidePassword(this, $('#confirm-password'))"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="d-inline-block w-100">
                                    <button type="submit" id="btn-submit" class="btn btn-primary rounded-pill w-100 mt-4">@lang('form.btn_reset_password')</button>
                                </div>
                            </form>
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
