@extends('layouts.admin.omg')

@section('title')
    @lang('page.title_setting') - @lang('page.change_password')
@endsection

@section('styles')

@endsection

@section('content')
    <div class="container-xl">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-soft-primary">
                       <li class="breadcrumb-item">
                           <a href="{{ route('home') }}"><i class="ri-home-4-line me-1"></i>@lang('page.title_home')</a>
                        </li>
                       <li class="breadcrumb-item">@lang('page.title_setting')</li>
                       <li class="breadcrumb-item active" aria-current="page">@lang('page.change_password')</li>
                    </ol>
                 </nav>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                @include('components.nav-admin-settings')
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                           <h5 class="card-title">@lang('page.change_password')</h5>
                        </div>
                        <div class="card-header-toolbar d-flex align-items-center">
                            @if (Route::has('password.request'))
                                <a href="{{ route('admin.password.request') }}" target="_blank" class="float-end">@lang('form.lbl_forgot_your_password')</a>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        @include('components.flash-message', ['flashName' => 'message'])

                        <form action="{{ route('admin.setting.changepw.update') }}" method="POST" class="mt-2 needs-validation" id="input-form" enctype="multipart/form-data" onsubmit="doSubmit($('#btn-submit'))">
                            @csrf
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label class="form-label" for="current_password">@lang('form.lbl_current_password') *</label>
                                        <div class="input-group">
                                            <input name="current_password" type="password" id="current_password" class="form-control mb-0 @error('current_password') is-invalid @enderror" placeholder="@lang('form.lbl_current_password')" required autocomplete="new-password">
                                            <span class="input-group-text" >
                                                <i class="far fa-eye-slash" onclick="showHidePassword(this, $('#current_password'))"></i>
                                            </span>
                                            @error('current_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="password">@lang('form.lbl_new_password') *</label>
                                        <div class="input-group">
                                            <input name="password" type="password" id="password" class="form-control mb-0 @error('password') is-invalid @enderror" placeholder="@lang('form.lbl_new_password')" required autocomplete="new-password">
                                            <span class="input-group-text" >
                                                <i class="far fa-eye-slash" onclick="showHidePassword(this, $('#password'))"></i>
                                            </span>
                                            @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="confirm-password">@lang('form.lbl_confirm_new_password') *</label>
                                        <div class="input-group">
                                            <input name="password_confirmation" id="confirm-password" type="password" class="form-control mb-0 @error('password') is-invalid @enderror" placeholder="@lang('form.lbl_confirm_new_password')" required autocomplete="new-password">
                                            <span class="input-group-text" >
                                                <i class="far fa-eye-slash" onclick="showHidePassword(this, $('#confirm-password'))"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-md-12">
                                    <div class="form-group row align-items-end text-end">
                                        <div class="col-md-9">
                                            <button type="reset" class="btn bg-soft-danger me-2">@lang('form.btn_cancel')</button>
                                            <button type="submit" id="btn-submit" class="btn btn-primary">@lang('form.btn_submit')</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('assets/js/utils.js') }}"></script>
    <script type="text/javascript">
        $(()=>{
            
        });
    </script>
@endsection