@extends('layouts.template-body')

@section('title')
<title>@lang('page.title_setting') - @lang('page.support_page')</title>
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
                    '#' => __('page.support_page'),
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
            <form action="{{ route('setting.supportpage.store') }}" method="POST" class="mt-2 needs-validation new-form" id="input-form" enctype="multipart/form-data" onsubmit="doSubmit($('#btn-submit'))">
                @csrf
                <input type="number" name="id" value="{{ $id }}" required hidden>
                <div class="card shadow border-0 rounded-small card-dark">
                    <div class="card-body">
                        @php
                            $url = route('support.index', ['page_name' => old("page_url", $page_url)]);
                        @endphp

                        <label for="page_url" class="form-label">@lang('form.lbl_support_page_url') <span class="text-danger fw-bold" >*</span></label>
                        <div class="form-group mb-3">
                            <div class="input-group">
                                <span class="social-label d-none d-md-block input-group-text bg-primary rounded-0 py-2 px-3 text-white"> {{ env('APP_SECURE_URL') }}/</span>
                                <input type="text" name="page_url" class="form-control control-group pe-5 @error('page_url') is-invalid @enderror" id="page_url" placeholder="username" value="{{ old('page_url', $page_url) }}" required>
                                <span class="input-group-text group-addon bg-primary">
                                    <a href="{{ $url }}" target="_blank" class="text-white">/support <i class="ri-external-link-fill "></i></a>
                                </span>
                            </div>
                            <input type="hidden" class="@error("page_url") is-invalid @enderror">
                            @error('page_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-sm-12 mb-3">
                            <label class="form-label">@lang('form.lbl_support_page_message')</label>
                            <textarea name="page_message" class="form-control @error('page_message') is-invalid @enderror notif " rows="5" style="line-height: 22px;" placeholder="Dukung saya di omg.id yaa!" required>{{ old('page_message', $page_message) }}</textarea>
                            @error('page_message')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer border-0 bg-transparent py-3">
                        <div class="d-flex justify-content-md-end justify-content-center gap-2">
                            <button type="reset" class="btn btn-outline-danger rounded-pill">@lang('form.btn_reset')</button>
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
<script type="text/javascript" src="{{ asset('assets/js/submit.js') }}"></script>
<script type="text/javascript">
    $(() => {

    });
</script>
@endsection