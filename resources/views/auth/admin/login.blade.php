@extends('layouts.admin.omg-full')

@section('title', __('page.title_login'))

@section('styles')

@endsection

@section('content')
    <section class="sign-in-page">
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
                        <h3 class="mb-0">@lang('page.login') @lang('(Admin Area)')</h3>
                        <p>@lang('page.login_description')</p>
                        
                        @include('components.flash-message', ['flashName' => 'message'])

                        <form method="POST" action="{{ route('admin.login') }}" class="mt-4 needs-validation" id="auth-form" onsubmit="doSubmit($('#btn-submit'))">
                            @csrf
                            <div class="form-group">
                                <label class="form-label" for="email">@lang('form.lbl_email_or_username') *</label>
                                <input name="identity" type="text" class="form-control mb-0 @error('identity') is-invalid @enderror" id="email" placeholder="@lang('form.lbl_email_or_username')" required value="{{ old("identity") }}" autofocus>
                                @error('identity')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                 </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="password">@lang('form.lbl_password') *</label>
                                @if (Route::has('admin.password.request'))
                                <a href="{{ route('admin.password.request') }}" class="float-end">@lang('form.lbl_forgot_your_password')</a>
                                @endif
                                <div class="input-group ">
                                    <input name="password" type="password" class="form-control mb-0 @error('password') is-invalid @enderror" id="password" placeholder="Password" required autocomplete="current-password">
                                    <span class="input-group-text" >
                                        <i class="far fa-eye-slash" onclick="showHidePassword(this, $('#password'))"></i>
                                    </span>
                                    @error('password')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="d-inline-block w-100">
                                <div class="form-check d-inline-block mt-2 pt-1">
                                    <input name="remember" type="checkbox" class="form-check-input" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">@lang('form.lbl_remember_me')</label>
                                </div>
                                <button type="submit" id="btn-submit" class="btn btn-primary float-end">@lang('form.btn_login')</button>
                            </div>
                            <div class="sign-info">
                                @if (Route::has('admin.register'))
                                <span class="dark-color d-inline-block line-height-2">@lang('page.dont_have_an_account')
                                    <a href="{{ route('admin.register') }}">@lang('form.btn_register')</a>
                                </span>
                                @endif
                                
                                @if (Route::has('admin.auth.social.provider'))
                                <ul class="iq-social-media">
                                    <li><a href="{{ url('/auth/facebook') }}"><i class="ri-facebook-box-line"></i></a></li>
                                    <li><a href="{{ url('/auth/twitter') }}"><i class="ri-twitter-line"></i></a></li>
                                    <li><a href="{{ url('/auth/google') }}"><i class="ri-google-line"></i></a></li>
                                </ul>
                                @endif
                            </div>
                        </form>
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