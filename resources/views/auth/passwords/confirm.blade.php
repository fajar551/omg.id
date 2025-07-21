@extends('layouts.template-auth')

@section('title', __('Confirm Password'))

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
                            <h2 class="fw-bold text-center">@lang('page.confirm_password')</h2>
                        </div>
                        <div class="card-body">
        
                            <p>@lang('page.confirm_password_description')</p>
                            
                            @include('components.flash-message', ['flashName' => 'message'])

                            <form method="POST" action="{{ route('password.confirm') }}" class="mt-4 needs-validation" id="auth-form" onsubmit="doSubmit($('#btn-submit'))">
                                @csrf
                                <div class="form-group form-group-invalid mb-3">
                                    <label class="form-label" for="password">@lang('form.lbl_password') <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input name="password" type="password" id="password" class="form-control form-rounded-pill control-group pe-5 @error('password') is-invalid @enderror" placeholder="@lang('form.lbl_password')" required autocomplete="new-password">
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
                                <div class="d-inline-block w-100">
                                    <button type="submit" id="btn-submit" class="btn btn-primary rounded-pill w-100 mt-4">@lang('page.confirm')</button>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            @if (Route::has('password.request'))
                                <div class="sign-info text-center">
                                    <span class="d-inline-block line-height-2">@lang('page.forgot_description')
                                        <a href="{{ route('password.request') }}">@lang('Forgot Password')</a>
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
