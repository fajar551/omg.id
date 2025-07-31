@extends('layouts.template-body')

@section('title')
    <title>{{ $widget_with_settings['name'] }}</title>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/overlay.css') }}">
    <link rel="stylesheet" href="{{ asset('template/css/jquery.fontselect.min.css') }}">
@endsection

@section('content')
    <div class="container px-5 mb-5">

        @include('components.breadcrumb', ['title' => __('page.overlay'), 'pages' => [route('overlay.index') => __('page.overlay'), '#' => $widget_with_settings['name']]])

        <div class="row">
            <div class="col-12">
                @include('components.flash-message', ['flashName' => 'message'])
            </div>
        </div>

        <div class="row  ">
            <div class="col-md-12">
                <div class="col-12 d-none d-lg-block d-lg-block">
                    @include('components.nav-overlay', ['widgets' => $widgets])
                </div>

                @include('components.nav-overlay-mobile', ['widgets' => $widgets, 'widget_with_settings' => $widget_with_settings])

                <div class="row">

                    <div class="col-md-12 col-lg-8 col-sm-12 order-2 order-lg-1">
                        <div class="row mb-3 position-relative">
                            <div class="col-md-12 col-lg-12">
                                <div class="card border-0 shadow rounded-small card-dark">
                                    <div class="card-body ">
                                        <form action="{{ route('overlay.update') }}" method="POST" class="mt-2 needs-validation" id="input-form" enctype="multipart/form-data" onsubmit="doSubmit($('#btn-submit'))" autocomplete="off">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="key" value="{{ $widget_with_settings['key'] }}">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group row d-flex align-items-center mb-3">
                                                        <div class="col-lg-3 col-sm-12">
                                                            <label class="form-label" for="themes-select">@lang('form.lbl_themes')</label>
                                                        </div>
                                                        <div class="col-lg-9 col-sm-12">
                                                            <select name="settings[goa_theme]" id="themes-select" class="form-select  @error('settings.goa_theme') is-invalid @enderror" data-key="goa_theme" onchange="buildWidget(this);" required>
                                                                @foreach ($themes as $k => $v)
                                                                    <option value="{{ strtolower($v) }}" @if (old('settings.goa_theme', $widget_settings_map['goa_theme']['value']) == strtolower($v)) selected @endif>{{ ucwords(str_replace('-', ' ', $v)) }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('settings.goa_theme')
                                                                <div class="invalid-feedback">{{ str_replace('settings.goa', '', $message) }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-3 d-flex align-items-center row">
                                                        <div class="col-lg-3 col-sm-12">
                                                            <label class="form-label" for="font1">@lang('form.lbl_font')</label>
                                                        </div>
                                                        <div class="col-lg-9 col-sm-12">
                                                            <input type="text" name="settings[goa_font]" class="form-control selectfont @error('settings.goa_font') is-invalid @enderror" id="font1" data-key="goa_font" value="{{ old('settings.goa_font', $widget_settings_map['goa_font']['value']) }}" onchange="buildWidget(this);" required>
                                                            @error('settings.goa_font')
                                                                <div class="invalid-feedback">{{ str_replace('settings.goa', '', $message) }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group row d-flex align-items-center mb-3">
                                                        <div class="col-lg-3 col-sm-12">
                                                            <label class="form-label" for="">@lang('form.lbl_color_palete')</label>
                                                        </div>
                                                        <div class="col-lg-9 col-sm-12">
                                                            <div class="row" id="color-palete-default" @if (old('settings.goa_theme', $widget_settings_map['goa_theme']['value']) != 'default') style="display: none" @endif>
                                                                <div class="col-3">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="goa_t1_color_1">@lang('Body')</label>
                                                                        <input type="color" class="form-control p-0 border-0 @error('settings.goa_t1_color_1') is-invalid @enderror" name="settings[goa_t1_color_1]" id="goa_t1_color_1" data-key="goa_t1_color_1" value="{{ old('settings.goa_t1_color_1', $widget_settings_map['goa_t1_color_1']['value']) }}" onchange="buildWidget(this);">
                                                                        @error('settings.goa_t1_color_1')
                                                                            <div class="invalid-feedback">{{ str_replace('settings.goa', '', $message) }}</div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="col-3">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="goa_t1_color_2">@lang('Footer')</label>
                                                                        <input type="color" class="form-control p-0 border-0 @error('settings.goa_t1_color_2') is-invalid @enderror" name="settings[goa_t1_color_2]" id="goa_t1_color_2" data-key="goa_t1_color_2" value="{{ old('settings.goa_t1_color_2', $widget_settings_map['goa_t1_color_2']['value']) }}" onchange="buildWidget(this);">
                                                                        @error('settings.goa_t1_color_2')
                                                                            <div class="invalid-feedback">{{ str_replace('settings.goa', '', $message) }}</div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="col-3">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="goa_t1_color_3">@lang('Text')</label>
                                                                        <input type="color" class="form-control p-0 border-0 @error('settings.goa_t1_color_3') is-invalid @enderror" name="settings[goa_t1_color_3]" id="goa_t1_color_3" data-key="goa_t1_color_3" value="{{ old('settings.goa_t1_color_3', $widget_settings_map['goa_t1_color_3']['value']) }}" onchange="buildWidget(this);">
                                                                        @error('settings.goa_t1_color_3')
                                                                            <div class="invalid-feedback">{{ str_replace('settings.goa', '', $message) }}</div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="col-3">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="goa_t1_color_4">@lang('Progress')</label>
                                                                        <input type="color" class="form-control p-0 border-0 @error('settings.goa_t1_color_4') is-invalid @enderror" name="settings[goa_t1_color_4]" id="goa_t1_color_4" data-key="goa_t1_color_4" value="{{ old('settings.goa_t1_color_4', $widget_settings_map['goa_t1_color_4']['value']) }}" onchange="buildWidget(this);">
                                                                        @error('settings.goa_t1_color_4')
                                                                            <div class="invalid-feedback">{{ str_replace('settings.goa', '', $message) }}</div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row" id="color-palete-simple" @if (old('settings.goa_theme', $widget_settings_map['goa_theme']['value']) != 'simple') style="display: none" @endif>
                                                                <div class="col-3">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="goa_t2_color_1">@lang('Body')</label>
                                                                        <input type="color" class="form-control p-0 border-0 @error('settings.goa_t2_color_1') is-invalid @enderror" name="settings[goa_t2_color_1]" id="goa_t2_color_1" data-key="goa_t2_color_1" value="{{ old('settings.goa_t2_color_1', $widget_settings_map['goa_t2_color_1']['value']) }}" onchange="buildWidget(this);">
                                                                        @error('settings.goa_t2_color_1')
                                                                            <div class="invalid-feedback">{{ str_replace('settings.goa', '', $message) }}</div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="col-3">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="goa_t2_color_2">@lang('Shadow')</label>
                                                                        <input type="color" class="form-control p-0 border-0 @error('settings.goa_t2_color_2') is-invalid @enderror" name="settings[goa_t2_color_2]" id="goa_t2_color_2" data-key="goa_t2_color_2" value="{{ old('settings.goa_t2_color_2', $widget_settings_map['goa_t2_color_2']['value']) }}" onchange="buildWidget(this);">
                                                                        @error('settings.goa_t2_color_2')
                                                                            <div class="invalid-feedback">{{ str_replace('settings.goa', '', $message) }}</div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="col-3">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="goa_t2_color_3">@lang('Text')</label>
                                                                        <input type="color" class="form-control p-0 border-0 @error('settings.goa_t2_color_3') is-invalid @enderror" name="settings[goa_t2_color_3]" id="goa_t2_color_3" data-key="goa_t2_color_3" value="{{ old('settings.goa_t2_color_3', $widget_settings_map['goa_t2_color_3']['value']) }}" onchange="buildWidget(this);">
                                                                        @error('settings.goa_t2_color_3')
                                                                            <div class="invalid-feedback">{{ str_replace('settings.goa', '', $message) }}</div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="col-3">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="goa_t2_color_4">@lang('Progress')</label>
                                                                        <input type="color" class="form-control p-0 border-0 @error('settings.goa_t2_color_4') is-invalid @enderror" name="settings[goa_t2_color_4]" id="goa_t2_color_4" data-key="goa_t2_color_4" value="{{ old('settings.goa_t2_color_4', $widget_settings_map['goa_t2_color_4']['value']) }}" onchange="buildWidget(this);">
                                                                        @error('settings.goa_t2_color_4')
                                                                            <div class="invalid-feedback">{{ str_replace('settings.goa', '', $message) }}</div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row" id="color-palete-pill" @if (old('settings.goa_theme', $widget_settings_map['goa_theme']['value']) != 'pill') style="display: none" @endif>
                                                                <div class="col-3">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="goa_t3_color_1">@lang('Body')</label>
                                                                        <input type="color" class="form-control p-0 border-0 @error('settings.goa_t3_color_1') is-invalid @enderror" name="settings[goa_t3_color_1]" id="goa_t3_color_1" data-key="goa_t3_color_1" value="{{ old('settings.goa_t3_color_1', $widget_settings_map['goa_t3_color_1']['value']) }}" onchange="buildWidget(this);">
                                                                        @error('settings.goa_t3_color_1')
                                                                            <div class="invalid-feedback">{{ str_replace('settings.goa', '', $message) }}</div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="col-3">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="goa_t3_color_2">@lang('Shadow')</label>
                                                                        <input type="color" class="form-control p-0 border-0 @error('settings.goa_t3_color_2') is-invalid @enderror" name="settings[goa_t3_color_2]" id="goa_t3_color_2" data-key="goa_t3_color_2" value="{{ old('settings.goa_t3_color_2', $widget_settings_map['goa_t3_color_2']['value']) }}" onchange="buildWidget(this);">
                                                                        @error('settings.goa_t3_color_2')
                                                                            <div class="invalid-feedback">{{ str_replace('settings.goa', '', $message) }}</div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="col-3">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="goa_t3_color_3">@lang('Text')</label>
                                                                        <input type="color" class="form-control p-0 border-0 @error('settings.goa_t3_color_3') is-invalid @enderror" name="settings[goa_t3_color_3]" id="goa_t3_color_3" data-key="goa_t3_color_3" value="{{ old('settings.goa_t3_color_3', $widget_settings_map['goa_t3_color_3']['value']) }}" onchange="buildWidget(this);">
                                                                        @error('settings.goa_t3_color_3')
                                                                            <div class="invalid-feedback">{{ str_replace('settings.goa', '', $message) }}</div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="col-3">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="goa_t3_color_4">@lang('Progress')</label>
                                                                        <input type="color" class="form-control p-0 border-0 @error('settings.goa_t3_color_4') is-invalid @enderror" name="settings[goa_t3_color_4]" id="goa_t3_color_4" data-key="goa_t3_color_4" value="{{ old('settings.goa_t3_color_4', $widget_settings_map['goa_t3_color_4']['value']) }}" onchange="buildWidget(this);">
                                                                        @error('settings.goa_t3_color_4')
                                                                            <div class="invalid-feedback">{{ str_replace('settings.goa', '', $message) }}</div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr class="mt-4 mb-4">
                                                    <div class="form-group  row d-flex align-items-center mb-3">
                                                        <div class="col-lg-3 col-sm-12">
                                                            <label class="form-label" for="goa_source">@lang('form.lbl_data_source')</label>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <select name="settings[goa_source]" class="form-select @error('settings.goa_source') is-invalid @enderror" data-trigger="" id="goa_source" data-key="goa_source" onchange="buildWidget(this);">
                                                                <option value="active-goal" @if (old('settings.goa_source', $widget_settings_map['goa_source']['value']) == 'active-goal') selected @endif>@lang('form.lbl_data_source_active_goal')</option>
                                                                <option value="tip-history" @if (old('settings.goa_source', $widget_settings_map['goa_source']['value']) == 'tip-history') selected @endif>@lang('form.lbl_data_source_tip_history')</option>
                                                            </select>
                                                            @error('settings.goa_source')
                                                                <div class="invalid-feedback">{{ str_replace('settings.goa', '', $message) }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div id="goa-source-input" @if (old('settings.goa_source', $widget_settings_map['goa_source']['value']) == 'active-goal') ? style="display: none" @endif>
                                                        <div class="form-group triger-data-source row d-flex align-items-center mb-3">
                                                            <div class="col-lg-3 col-sm-12">
                                                                <label class="form-label" for="goa_custom_title">@lang('form.lbl_title')</label>
                                                            </div>
                                                            <div class="col-lg-9 col-sm-12">
                                                                <input type="text" name="settings[goa_custom_title]" class="form-control @error('settings.goa_custom_title') is-invalid @enderror" id="goa_custom_title" data-key="goa_custom_title" value="{{ old('settings.goa_custom_title', $widget_settings_map['goa_custom_title']['value']) }}" oninput="buildWidget(this);" required>
                                                                @error('settings.goa_custom_title')
                                                                    <div class="invalid-feedback">{{ str_replace('settings.goa', '', $message) }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="form-group triger-data-source  row d-flex align-items-center mb-3">
                                                            <div class="col-lg-3 col-sm-12">
                                                                <label class="form-label" for="goa_since_date">@lang('form.lbl_calculate_since_date')</label>
                                                            </div>
                                                            <div class="col-lg-9 col-sm-12">
                                                                <input type="date" name="settings[goa_since_date]" class="form-control @error('settings.goa_since_date') is-invalid @enderror" id="goa_since_date" data-key="goa_since_date" value="{{ old('settings.goa_since_date', $widget_settings_map['goa_since_date']['value']) }}" onchange="buildWidget(this);" required>
                                                                @error('settings.goa_since_date')
                                                                    <div class="invalid-feedback">{{ str_replace('settings.goa', '', $message) }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="form-group triger-data-source  row d-flex align-items-center mb-3">
                                                            <div class="col-lg-3 col-sm-12">
                                                                <label class="form-label" for="goa_custom_target">@lang('form.lbl_target_amount')</label>
                                                            </div>
                                                            <div class="col-lg-9 col-sm-12">
                                                                <input type="number" min="0" step="500000" name="settings[goa_custom_target]" class="form-control notif @error('settings.goa_custom_target') is-invalid @enderror" id="goa_custom_target" data-key="goa_custom_target" value="{{ old('settings.goa_custom_target', $widget_settings_map['goa_custom_target']['value']) }}" oninput="buildWidget(this);" required>
                                                                @error('settings.goa_custom_target')
                                                                    <div class="invalid-feedback">{{ str_replace('settings.goa', '', $message) }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr class="mt-4 mb-4">
                                                    <div class="form-group mb-2 row d-flex align-items-centerr">
                                                        <div class="col-sm-12 col-lg-4">
                                                            <label class="form-check-label" for="goa_show_current_nominal">@lang('form.lbl_show_current_nominal')</label>
                                                        </div>
                                                        <div class="col-lg-8 col-sm-12">
                                                            <div class="form-check form-switch d-block">
                                                                <input type="hidden" name="settings[goa_show_current_nominal]" id="goa_show_current_nominal_input" value="{{ old('settings.goa_show_current_nominal', $widget_settings_map['goa_show_current_nominal']['value']) }}">
                                                                <input type="checkbox" class="form-check-input @error('settings.goa_show_current_nominal') is-invalid @enderror" id="goa_show_current_nominal" data-key="goa_show_current_nominal" value="1" onchange="buildWidget(this);" @if (old('settings.goa_show_current_nominal', $widget_settings_map['goa_show_current_nominal']['value']) == 1) checked @endif>
                                                                {{-- <label class="form-check-label mx-2" for="goa_show_current_nominal">@lang('form.lbl_show_current_nominal')</label> --}}
                                                                @error('settings.goa_show_current_nominal')
                                                                    <div class="invalid-feedback">{{ str_replace('settings.goa', '', $message) }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-2 row d-flex align-items-centerr">
                                                        <div class="col-sm-12 col-lg-4">
                                                            <label class="form-check-label" for="goa_show_target_nominal">@lang('form.lbl_show_nominal_target')</label>
                                                        </div>
                                                        <div class="col-lg-8 col-sm-12">
                                                            <div class="form-check form-switch d-block">
                                                                <input type="hidden" name="settings[goa_show_target_nominal]" id="goa_show_target_nominal_input" value="{{ old('settings.goa_show_target_nominal', $widget_settings_map['goa_show_target_nominal']['value']) }}">
                                                                <input type="checkbox" class="form-check-input @error('settings.goa_show_target_nominal') is-invalid @enderror" id="goa_show_target_nominal" data-key="goa_show_target_nominal" value="1" onchange="buildWidget(this);" @if (old('settings.goa_show_target_nominal', $widget_settings_map['goa_show_target_nominal']['value']) == 1) checked @endif>
                                                                {{-- <label class="form-check-label mx-2" for="goa_show_target_nominal">@lang('form.lbl_show_nominal_target')</label> --}}
                                                                @error('settings.goa_show_target_nominal')
                                                                    <div class="invalid-feedback">{{ str_replace('settings.goa', '', $message) }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-2 row d-flex align-items-centerr">
                                                        <div class="col-sm-12 col-lg-4">
                                                            <label class="form-check-label" for="goa_show_link">@lang('form.lbl_show_support_page_link')</label>
                                                        </div>
                                                        <div class="col-lg-8 col-sm-12">
                                                            <div class="form-check form-switch d-block">
                                                                <input type="hidden" name="settings[goa_show_link]" id="goa_show_link_input" value="{{ old('settings.goa_show_link', $widget_settings_map['goa_show_link']['value']) }}">
                                                                <input type="checkbox" class="form-check-input @error('settings.goa_show_link') is-invalid @enderror" id="goa_show_link" data-key="goa_show_link" value="1" onchange="buildWidget(this);" @if (old('settings.goa_show_link', $widget_settings_map['goa_show_link']['value']) == 1) checked @endif>
                                                                {{-- <label class="form-check-label mx-2" for="goa_show_link">@lang('form.lbl_show_support_page_link')</label> --}}
                                                                @error('settings.goa_show_link')
                                                                    <div class="invalid-feedback">{{ str_replace('settings.goa', '', $message) }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-2 row d-flex align-items-centerr">
                                                        <div class="col-sm-12 col-lg-4">
                                                            <label class="form-check-label" for="goa_show_progress">@lang('form.lbl_show_progress')</label>
                                                        </div>
                                                        <div class="col-lg-8 col-sm-12">
                                                            <div class="form-check form-switch d-block">
                                                                <input type="hidden" name="settings[goa_show_progress]" id="goa_show_progress_input" value="{{ old('settings.goa_show_progress', $widget_settings_map['goa_show_progress']['value']) }}">
                                                                <input type="checkbox" class="form-check-input @error('settings.goa_show_progress') is-invalid @enderror" id="goa_show_progress" data-key="goa_show_progress" value="1" onchange="buildWidget(this);" @if (old('settings.goa_show_progress', $widget_settings_map['goa_show_progress']['value']) == 1) checked @endif>
                                                                {{-- <label class="form-check-label mx-2" for="goa_show_progress">@lang('form.lbl_show_progress')</label> --}}
                                                                @error('settings.goa_show_progress')
                                                                    <div class="invalid-feedback">{{ str_replace('settings.goa', '', $message) }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row d-flex align-items-center mt-3">
                                                        <div class="d-flex justify-content-end mt-3">
                                                            <div class="col-lg-5 col-sm-12 d-flex justify-content-end">
                                                                <button type="submit" class="btn btn-primary rounded-pill mb-1 w-100 " id="btn-submit">@lang('form.btn_save_and_generate_url')</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12 col-lg-12">
                                @include('components.overlay-setting-url', ['url' => $url])
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-4 col-sm-12 order-1 order-lg-2 ">
                        <div class="overlaysticky" id="overlay-preview-div">
                            <div class="accordion col-notifikasi bg-transparent" id="accordionExample">
                                <div class="accordion-item bg-white rounded-small">
                                    <h2 class="accordion-header bg-transparent text-black" id="headingOne">
                                        <button class="accordion-button  bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            @lang('Preview')
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            @include('components.overlay-setting-preview', ['url' => $url, 'url_iframe' => $url_iframe, 'goalAction' => true])
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('template/js/jquery.fontselect.min.js') }}"></script>
    <script src="{{ asset('assets/js/clipboard.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="{{ asset('assets/js/utils.js') }}"></script>
    <script src="{{ asset('assets/js/omg-widget-host.js') }}"></script>
    <script src="{{ asset('assets/js/overlay.js') }}"></script>
    <script>
        $(() => {
            window.addEventListener("message", (e) => {
                var data = e.data;

                if (data === "childCallbacksHasRegistered") {
                    switchColorThemeInput("{{ $widget_settings_map['goa_theme']['value'] }}");
                }
            });

            $('#input-form').on('submit', () => {
                removeSettingElementByTheme($('#themes-select').val());
            });
        });

        const buildWidget = (el) => {
            const elKey = $(el).attr('data-key');
            let value = escape($(el).val());;

            if (isChildCallbackEmpty()) {
                console.log('buildWidget', 'childCallbacks not registered!');
                return false;
            }

            switch (elKey) {
                case 'goa_theme':
                    if (value == "default") {
                        // Hide other
                        $('#color-palete-simple').hide();
                        $('#color-palete-pill').hide();

                        // Show the current
                        $('#color-palete-default').show();
                    } else if (value == "simple") {
                        // Hide other
                        $('#color-palete-default').hide();
                        $('#color-palete-pill').hide();

                        // Show the current
                        $('#color-palete-simple').show();
                    } else if (value == "pill") {
                        // Hide other
                        $('#color-palete-default').hide();
                        $('#color-palete-simple').hide();

                        // Show the current
                        $('#color-palete-pill').show();
                    }

                    // Switch color scheme for color input 
                    switchColorThemeInput(value);

                    childCallbacks.buildParams('goa_theme', value);
                    childCallbacks.reloadWidget();
                    break;
                case 'real_data':
                    value = $(el).is(":checked") ? '1' : '0';
                    childCallbacks.buildParams('real_data', value);
                    childCallbacks.reloadWidget();
                    break;

                    // Color scheme for Default theme
                case 'goa_t1_color_1':
                    childCallbacks.setStyle('--color-card', value);
                    childCallbacks.buildParams(elKey, value);
                    break;
                case 'goa_t1_color_2':
                    childCallbacks.setStyle('--color-card-footer', value);
                    childCallbacks.buildParams(elKey, value);
                    break;
                case 'goa_t1_color_3':
                    childCallbacks.setStyle('--color-text', value);
                    childCallbacks.buildParams(elKey, value);
                    break;
                case 'goa_t1_color_4':
                    childCallbacks.setStyle('--color-progress', value);
                    childCallbacks.buildParams(elKey, value);
                    break;

                    // Color scheme for Simple theme
                case 'goa_t2_color_1':
                    childCallbacks.setStyle('--color-card', value);
                    childCallbacks.buildParams(elKey, value);
                    break;
                case 'goa_t2_color_2':
                    childCallbacks.setStyle('--color-card-shadow', value);
                    childCallbacks.buildParams(elKey, value);
                    break;
                case 'goa_t2_color_3':
                    childCallbacks.setStyle('--color-text', value);
                    childCallbacks.buildParams(elKey, value);
                    break;
                case 'goa_t2_color_4':
                    childCallbacks.setStyle('--color-progress', value);
                    childCallbacks.buildParams(elKey, value);
                    break;

                    // Color scheme for Pill theme
                case 'goa_t3_color_1':
                    childCallbacks.setStyle('--color-card', value);
                    childCallbacks.buildParams(elKey, value);
                    break;
                case 'goa_t3_color_2':
                    childCallbacks.setStyle('--color-card-shadow', value);
                    childCallbacks.buildParams(elKey, value);
                    break;
                case 'goa_t3_color_3':
                    childCallbacks.setStyle('--color-text', value);
                    childCallbacks.buildParams(elKey, value);
                    break;
                case 'goa_t3_color_4':
                    childCallbacks.setStyle('--color-progress', value);
                    childCallbacks.buildParams(elKey, value);
                    break;
                case 'goa_font':
                    childCallbacks.setFont(value);
                    childCallbacks.buildParams(elKey, value);
                    break;
                case 'goa_source':
                    if (value == "active-goal") {
                        $('#goa-source-input').hide();
                    } else if (value == "tip-history") {
                        $('#goa-source-input').show();
                    }

                    childCallbacks.buildParams(elKey, value);
                    childCallbacks.reloadWidget();
                    break;
                case 'goa_custom_title':
                    childCallbacks.setHTML('title', value);
                    childCallbacks.buildParams(elKey, value);
                    break;
                case 'goa_show_link':
                    if ($(el).is(":checked")) {
                        childCallbacks.getElementById('creator_link').removeAttribute('hidden');
                    } else {
                        childCallbacks.getElementById('creator_link').setAttribute('hidden', '');
                    }

                    value = $(el).is(":checked") ? '1' : '0';
                    $('#goa_show_link_input').val(value);
                    childCallbacks.buildParams(elKey, value);
                    break;
                case 'goa_since_date':
                    childCallbacks.buildParams(elKey, value);
                    childCallbacks.reloadWidget();
                    break;
                case 'goa_custom_target':
                    childCallbacks.setHTML('target_value', childCallbacks.toIDR(value));
                    childCallbacks.buildParams(elKey, value);
                    break;
                case 'goa_show_current_nominal':
                case 'goa_show_target_nominal':
                    if ($(el).is(":checked")) {
                        childCallbacks.getElementById(elKey == 'goa_show_current_nominal' ? 'target_achieved' : 'target').removeAttribute('hidden');
                    } else {
                        childCallbacks.getElementById(elKey == 'goa_show_current_nominal' ? 'target_achieved' : 'target').setAttribute('hidden', '');
                    }

                    if ($('#goa_show_current_nominal').is(":checked") || $('#goa_show_target_nominal').is(":checked")) {
                        childCallbacks.getElementById('text_from').setAttribute('hidden', '');
                    }

                    if (!$('#goa_show_current_nominal').is(":checked") && !$('#goa_show_target_nominal').is(":checked")) {
                        childCallbacks.getElementById('text_from').setAttribute('hidden', '');
                    }

                    if ($('#goa_show_current_nominal').is(":checked") && $('#goa_show_target_nominal').is(":checked")) {
                        childCallbacks.getElementById('text_from').removeAttribute('hidden');
                    }

                    value = $(el).is(":checked") ? '1' : '0';
                    $(`#${elKey}_input`).val(value);
                    childCallbacks.buildParams(elKey, value);
                    break;
                case 'goa_show_progress':
                    if ($(el).is(":checked")) {
                        childCallbacks.getElementById('show_progress').removeAttribute('hidden');
                    } else {
                        childCallbacks.getElementById('show_progress').setAttribute('hidden', '');
                    }

                    value = $(el).is(":checked") ? '1' : '0';
                    $('#goa_show_progress_input').val(value);
                    childCallbacks.buildParams(elKey, value);
                    break;
                case 'goa_show_shadow':
                case 'goa_show_border':
                default:
                    break;
            }
        }

        const switchColorThemeInput = (theme) => {
            if (isChildCallbackEmpty() && !childCallbacks.hasOwnProperty('getQParamsByKey')) {
                console.log('switchColorThemeInput', 'childCallbacks not registered!');
                return false;
            }

            switch (theme) {
                case 'default':
                    $('#goa_t1_color_1').val(childCallbacks.getQParamsByKey('goa_t1_color_1') || '#ebebeb');
                    $('#goa_t1_color_2').val(childCallbacks.getQParamsByKey('goa_t1_color_2') || '#6103D0');
                    $('#goa_t1_color_3').val(childCallbacks.getQParamsByKey('goa_t1_color_3') || '#6103D0');
                    $('#goa_t1_color_4').val(childCallbacks.getQParamsByKey('goa_t1_color_4') || '#D0EE26');
                    break;
                case 'simple':
                    $('#goa_t2_color_1').val(childCallbacks.getQParamsByKey('goa_t2_color_1') || '#ebebeb');
                    $('#goa_t2_color_2').val(childCallbacks.getQParamsByKey('goa_t2_color_2') || '#6103D0');
                    $('#goa_t2_color_3').val(childCallbacks.getQParamsByKey('goa_t2_color_3') || '#6103D0');
                    $('#goa_t2_color_4').val(childCallbacks.getQParamsByKey('goa_t2_color_4') || '#D0EE26');
                    break;
                case 'pill':
                    $('#goa_t3_color_1').val(childCallbacks.getQParamsByKey('goa_t3_color_1') || '#ebebeb');
                    $('#goa_t3_color_2').val(childCallbacks.getQParamsByKey('goa_t3_color_2') || '#6103D0');
                    $('#goa_t3_color_3').val(childCallbacks.getQParamsByKey('goa_t3_color_3') || '#6103D0');
                    $('#goa_t3_color_4').val(childCallbacks.getQParamsByKey('goa_t3_color_4') || '#D0EE26');
                    break;
                default:
                    break;
            }
        }

        const removeSettingElementByTheme = (theme) => {
            if (isChildCallbackEmpty()) {
                console.log('removeSettingElementByTheme', 'childCallbacks not registered!');

                // Remove color scheme if childCallback not registered
                $('#color-palete-default').remove();
                $('#color-palete-simple').remove();
                $('#color-palete-pill').remove();
                return false;
            }

            if (theme == "default") {
                $('#color-palete-simple').remove();
                $('#color-palete-pill').remove();
            } else if (theme == "simple") {
                $('#color-palete-default').remove();
                $('#color-palete-pill').remove();
            } else if (theme == "pill") {
                $('#color-palete-default').remove();
                $('#color-palete-simple').remove();
            }
        }
    </script>
@endsection
