@extends('layouts.template-body')

@section('title')
    <title>@lang('page.title_setting') - @lang('page.general')</title>
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
                        '#' => __('page.general'),
                    ],
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

        <div class="setup-general">
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 mt-3">
                    <form action="{{ route('setting.general.system.store') }}" method="POST" class="needs-validation" id="system-setting-form" enctype="multipart/form-data" onsubmit="doSubmit($('#btn-submit'))">
                        @csrf
                        <div class="card shadow border-0 rounded-small  min-vh-50 card-dark">
                            <div class="card-body ">
                                <div class="form-group mb-3 row">
                                    <label class="form-label col-lg-3 col-sm-12" for="choices-single-default">@lang('form.lbl_language') <span class="text-danger">*</span></label>
                                    <div class="col-lg-9 col-sm-12">
                                        <select name="settings[language]" class="form-select @error('language') is-invalid @enderror" data-trigger="">
                                            <option value="en" @if (old('settings.language', $settings['language'] ?? config('app.locale')) == 'en') selected @endif>English</option>
                                            <option value="id" @if (old('settings.language', $settings['language'] ?? config('app.locale')) == 'id') selected @endif>Indonesia</option>
                                        </select>
                                        @error('language')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group mb-3 row">
                                    <label class="form-label col-lg-3 col-sm-12" for="choices-single-default">@lang('form.lbl_email_notification')</label>
                                    <div class="col-lg-9 col-sm-12">
                                        <div class="form-check form-checkbox ">
                                            <input type="hidden" name="settings[allow_new_support]" id="allow_new_support_input" value="{{ old('settings.allow_new_support', $settings['allow_new_support']) }}">
                                            <input type="checkbox" name="allow_new_support" class="form-check-input  @error('allow_new_support') is-invalid @enderror" id="allow_new_support" value="1" {{ old('settings.allow_new_support', $settings['allow_new_support']) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="allow_new_support"> @lang('form.lbl_allow_new_support')</label>
                                            @error('allow_new_support')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-check form-checkbox">
                                            <input type="hidden" name="settings[allow_news_and_update]" id="allow_news_and_update_input" value="{{ old('settings.allow_news_and_update', $settings['allow_news_and_update']) }}">
                                            <input type="checkbox" name="allow_news_and_update" class="form-check-input  @error('allow_news_and_update') is-invalid @enderror" id="allow_news_and_update" value="1" {{ old('settings.allow_news_and_update', $settings['allow_news_and_update']) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="allow_news_and_update"> @lang('form.lbl_news_and_update')</label>
                                            @error('allow_news_and_update')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3 row">
                                    <label class="form-label col-lg-3 col-sm-12">@lang('form.lbl_filter_word')</label>
                                    <div class="col-lg-9 col-sm-12">
                                        <textarea name="settings[profanity_custom_filter]" maxlength="2000" class="form-control  @error('profanity_custom_filter') is-invalid @enderror mb-0 notif" rows="5" style="line-height: 22px;" placeholder="Ayam;Pahit;Asam;ayam;pahit;asam">{{ old('settings.profanity_custom_filter', $settings['profanity_custom_filter']) }}</textarea>
                                        <small class="mt-2">*) @lang('form.lbl_filter_word_desc') @lang('form.lbl_filter_word_rule')</small>
                                        @error('profanity_custom_filter')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group mb-3 row">
                                    <label class="form-label col-lg-3 col-sm-12 d-none d-lg-block">&nbsp;</label>
                                    <div class="col-lg-9 col-sm-12">
                                        <div class="form-check form-checkbox">
                                            <input type="hidden" name="settings[profanity_by_system]" id="profanity_by_system_input" value="{{ old('settings.profanity_by_system', $settings['profanity_by_system']) }}">
                                            <input type="checkbox" name="profanity_by_system" class="form-check-input" id="profanity_by_system" value="1" {{ old('settings.profanity_by_system', $settings['profanity_by_system']) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="profanity_by_system"> @lang('form.lbl_filter_by_system')</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer border-0 bg-transparent py-3">
                                <div class="d-flex justify-content-center gap-2">
                                    <button type="submit" id="btn-submit" class="btn btn-primary rounded-pill">@lang('form.btn_save_changes')</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mt-3">
                    <form action="{{ route('setting.general.streamkey.store') }}" method="POST" class="needs-validation" id="renew-stream-form" enctype="multipart/form-data" onsubmit="doSubmit($('#btn-renew-submit'))">
                        @csrf
                        <div class="card shadow border-0 rounded-small card-dark">
                            <div class="card-body ">
                                <div class="form-group row mb-3">
                                    <label class="form-label col-lg-12 col-sm-12" for="streamkey">@lang('form.lbl_streamkey') <span class="text-danger">*</span></label>
                                    <div class="col-lg-12 col-sm-12">
                                        <div class="input-group">
                                            <input name="streamkey" type="password" id="streamkey" class="form-control control-group pe-5 @error('streamkey') is-invalid @enderror" value="{{ $streamKey }}" placeholder="@lang('form.lbl_streamkey')" required autocomplete="off" readonly>
                                            <span class="input-group-text group-addon">
                                                <i class="far fa-eye-slash" onclick="showHidePassword(this, $('#streamkey'))"></i>
                                            </span>
                                            @error('streamkey')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <small class="">*) @lang('form.lbl_renew_stream_key_desc')</small>
                            </div>
                            <div class="card-footer border-0 bg-transparent py-3">
                                <div class="d-flex justify-content-center gap-2">
                                    <button type="submit" id="btn-renew-submit" class="btn btn-outline-primary rounded-pill">@lang('form.btn_renew_streamkey')</button>
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
        $(() => {
            $('#profanity_by_system').on('change', function() {
                $('#profanity_by_system_input').val($(this).is(':checked') ? 1 : 0);
            });

            $('#allow_new_support').on('change', function() {
                $('#allow_new_support_input').val($(this).is(':checked') ? 1 : 0);
            });

            $('#allow_news_and_update').on('change', function() {
                $('#allow_news_and_update_input').val($(this).is(':checked') ? 1 : 0);
            });
        });
    </script>
@endsection
