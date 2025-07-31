@extends('layouts.template-body')

@section('title')
<title>@lang('page.title_setting') - @lang('page.change_password')</title>
@endsection

@section('styles')

@endsection

@section('content')
<div class="container px-5 mb-5">
    <div class="row">
        <div class="col-12">
            @include('components.breadcrumb', [
                'title' => __('page.title_setting'), 
                'pages' => [
                    route('setting.profile.index') => __('page.title_setting'),
                    '#' => __('page.change_password'),
                ]
            ])
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            @include('components.flash-message', ['flashName' => 'message'])
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 d-lg-none ">
            @include('components.nav-setting-mobile')
        </div>
        <div class="col-md-12 d-none  d-lg-block ">
            @include('components.nav-setting')
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mt-3">
            <form action="{{ route('setting.changepw.update') }}" method="POST" class="mt-2 needs-validation new-form" id="input-form" enctype="multipart/form-data" onsubmit="doSubmit($('#btn-submit'))">
                @csrf
                <div class="card shadow border-0 rounded-small card-dark">
                    <div class="card-header d-flex justify-content-end align-items-center border-0 bg-transparent">
                        <div class="card-header-toolbar d-flex align-items-center">
                            @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" target="_blank" class="float-end text-primary">@lang('form.lbl_forgot_your_password')</a>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-12 ">
                                <div class="form-group row mb-3">
                                    <label class="form-label col-sm-4" for="current_password">@lang('form.lbl_current_password') <span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <input name="current_password" type="password" id="current_password" class="form-control control-group pe-5 @error('current_password') is-invalid @enderror" placeholder="@lang('form.lbl_current_password')" required autocomplete="new-password">
                                            <span class="input-group-text group-addon">
                                                <i class="far fa-eye-slash" onclick="showHidePassword(this, $('#current_password'))"></i>
                                            </span>
                                            @error('current_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="form-label col-sm-4" for="password">@lang('form.lbl_new_password') <span class="text-danger" >*</span></label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <input name="password" type="password" id="password" class="form-control control-group pe-5 @error('password') is-invalid @enderror" placeholder="@lang('form.lbl_new_password')" required autocomplete="new-password">
                                            <span class="input-group-text group-addon">
                                                <i class="far fa-eye-slash" onclick="showHidePassword(this, $('#password'))"></i>
                                            </span>
                                            @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="form-label col-sm-4" for="confirm-password">@lang('form.lbl_confirm_new_password') <span class="text-danger" >*</span></label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <input name="password_confirmation" id="confirm-password" type="password" class="form-control control-group pe-5 @error('password') is-invalid @enderror" placeholder="@lang('form.lbl_confirm_new_password')" required autocomplete="new-password">
                                            <span class="input-group-text group-addon">
                                                <i class="far fa-eye-slash" onclick="showHidePassword(this, $('#confirm-password'))"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                       
                    </div>
                    <div class="card-footer border-0 bg-transparent py-3">
                        <div class="d-flex justify-content-md-end justify-content-center gap-2">
                            <button type=" reset" class="btn  btn-outline-danger rounded-pill">@lang('form.btn_reset')</button>
                            <button type="submit" id="btn-submit" class="btn btn-primary rounded-pill">@lang('form.btn_submit')</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('assets/js/utils.js') }}"></script>
<script type="text/javascript">
    $(() => {

    });
</script>
@endsection