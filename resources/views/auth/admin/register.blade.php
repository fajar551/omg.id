@extends('layouts.admin.omg-full')

@section('title', __('page.title_register'))

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
                        <h3 class="mb-0">@lang('page.register') @lang('(Admin Area)')</h3>
                        <p>@lang('page.register_description')</p>
                        
                        @include('components.flash-message', ['flashName' => 'message'])

                        <form method="POST" action="{{ route('admin.register') }}" class="mt-4 needs-validation" id="auth-form" onsubmit="doSubmit($('#btn-submit'))">
                            @csrf
                            <div class="form-group">
                                <label class="form-label" for="username">@lang('form.lbl_username') * @lang('form.lbl_username_rule')</label>
                                <input name="username" type="text" id="username" class="form-control mb-0 @error('username') is-invalid @enderror" value="{{ old("username") }}" placeholder="@lang('form.lbl_username')" required autocomplete="username" autofocus>
                                @error('username')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                 </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="name">@lang('form.lbl_full_name') *</label>
                                <input name="name" type="text" id="name" class="form-control mb-0 @error('name') is-invalid @enderror" value="{{ old("name") }}" placeholder="@lang('form.lbl_full_name')" required autocomplete="name" >
                                @error('name')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                 </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="email">@lang('form.lbl_email') *</label>
                                <input name="email" type="email" id="email" class="form-control mb-0 @error('email') is-invalid @enderror" value="{{ old("email") }}" placeholder="budi@mail.com" required autocomplete="email">
                                @error('email')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                 </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="password">@lang('form.lbl_password') *</label>
                                <input name="password" type="password" id="password" class="form-control mb-0 @error('password') is-invalid @enderror" placeholder="Budi123" required autocomplete="new-password">
                                @error('password')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                 </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="confirm-password">@lang('form.lbl_confirm_password') *</label>
                                <input name="password_confirmation" id="confirm-password" type="password" class="form-control mb-0 @error('password') is-invalid @enderror" placeholder="Budi123" required autocomplete="new-password">
                            </div>
                            <div class="d-inline-block w-100">
                                <div class="form-check d-inline-block mt-1 pt-1">
                                    <input type="checkbox" class="form-check-input" id="customCheck1">
                                    <label class="form-check-label" for="customCheck1">@lang('page.i_accept') <a href="#">@lang('page.terms_and_condition')</a></label>
                                </div>
                                <button type="submit" id="btn-submit" class="btn btn-primary float-end">@lang('form.btn_register')</button>
                            </div>
                            <div class="sign-info">
                                @if (Route::has('admin.login'))
                                <span class="dark-color d-inline-block line-height-2">@lang('page.already_have_an_account')
                                        <a href="{{ route('admin.login') }}">@lang('form.btn_login')</a>
                                </span>
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