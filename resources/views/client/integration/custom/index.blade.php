@extends('layouts.template-body')

@section('title')
    <title>@lang('page.title_integration') - @lang('page.webhook')</title>
@endsection

@section('styles')

@endsection

@section('content')
<div class="container px-5 mb-5">
    <div class="row">
        <div class="col-12">
            @include('components.breadcrumb', [
                'title' => __('page.title_integration'), 
                'pages' => [
                    '#' => __('page.webhook'),
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
            @include('components.nav-webhook-integration-mobile')
        </div>
        <div class="col-md-12 d-none  d-lg-block ">
            @include('components.nav-webhook-integration')
        </div>
    </div>

    <div class="row row-items">
        <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 mb-3">
            <form action="{{ route('integration.custom.store') }}" method="POST" class="needs-validation" id="input-form" enctype="multipart/form-data" onsubmit="doSubmit($('#btn-submit'))">
                @csrf
                <input type="number" name="status" id="status" value="{{ old('status', $status) }}" hidden>
                <div class="card shadow border-0 rounded-small min-vh-50 card-dark">
                    <div class="card-header d-flex justify-content-end border-0 bg-transparent mt-2">
                        <div class="card-header-toolbar d-flex align-items-center">
                            <div class="form-check form-switch form-check-inline">
                                <input type="checkbox" name="status" class="form-check-input" value="1" id="switch-status" data-type="custom_webhook" {{ (!$url) ? 'disabled' : '' }} {{ old('status', $status) ? 'checked' : '' }}>
                                <label class="form-check-label ms-1" for="switch-status" id="lbl-switch-status">@lang('form.lbl_turn_on_off')</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row mb-3">
                            <label class="form-label form-label col-sm-3">@lang('form.lbl_webhook_url') *</label>
                            <div class="col-sm-9">
                                <input type="url" name="url" class="form-control @error('url') is-invalid @enderror" placeholder="www.yoursite.com" value="{{ old('url', $url) }}">
                                @error('url')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label class="form-label form-label col-sm-3">@lang('form.lbl_template_message')</label>
                            <div class="col-sm-9">
                                <textarea name="template_message" class="form-control mb-2 @error('template_message') is-invalid @enderror" rows="5" style="line-height: 22px;" placeholder="Makasih {supporter} udah ngasih aku {amount}!" required>{{ old('template_message', $template_message) }}</textarea>
                                <span class="form-label mt-5 optional-label">* @lang('form.lbl_template_message_description')</span>
                                @error('template_message')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer border-0 bg-transparent py-3">
                        <div class="d-flex justify-content-md-end justify-content-center gap-2">
                            {{-- <button type="reset" class="btn btn-danger rounded-pill me-2">@lang('form.btn_cancel')</button> --}}
                            <button type="submit" id="btn-submit" class="btn btn-primary rounded-pill">@lang('form.btn_submit')</button>
                            <button type="button" id="btn-test" data-type="custom" {{ (!$status || !$url) ? 'disabled' : '' }} class="btn rounded-pill btn-outline-success btn-test">@lang('form.btn_send_test_notification')</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-3">
            <div class="card shadow border-0 rounded-small min-vh-50 card-dark">
                <div class="card-header border-0 bg-transparent">
                    <div class="header-title">
                        <h6 class="card-title fw-semibold pt-3">@lang('page.post_payloads')</h6>
                    </div>
                </div>
                <div class="card-body">
<pre>{
    "title": "[TEST] New tip from Someone",
    "subtitle": "Support me at omg.id.",
    "description": "Someone memberimu dukungan senilai Rp. 100.000",
    "url": "https://omg.id/your-page-name/support",
    "message": "Pesan: [TEST] THIS IS TEST MESSAGE!"
}</pre>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script type="text/javascript">
        const enableAction = '{{ $status || $url ? 1 : 0 }}';
    </script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/webhook.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/submit.js') }}"></script>
@endsection