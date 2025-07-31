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
                            <p class="m-0">@lang('page.reset_password_description')</p>
                        </div>
                        <div class="card-body">
        
                            @include('components.flash-message', ['flashName' => 'status'])
        
                            <form method="POST" action="{{ route('password.email') }}" class="needs-validation" id="auth-form" onsubmit="doSubmit($('#btn-submit'))">
                                @csrf
                                <div class="form-group mb-3">
                                    <label class="form-label" for="email">@lang('form.lbl_email') <span class="text-danger">*</span></label>
                                    <input name="email" type="email" class="form-control form-rounded-pill @error('email') is-invalid @enderror" id="email" placeholder="budi@mail.com" required value="{{ old("email") }}" autocomplete="email" autofocus>
                                    @error('email')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                                <div class="d-inline-block w-100">
                                    <button type="submit" id="btn-submit" class="btn btn-primary rounded-pill w-100 mt-4 mb-3">@lang('form.btn_send_password_reset_link')</button>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            @if (Route::has('login'))
                                <div class="sign-info text-center">
                                    <span class="dark-color d-inline-block line-height-2">@lang('page.already_remember_your_password')
                                        <a href="{{ route('login') }}">@lang('form.btn_login')</a>
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
