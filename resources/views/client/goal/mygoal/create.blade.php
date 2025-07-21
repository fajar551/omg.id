@extends('layouts.template-body')

@section('title')
    <title>@lang('page.title_goal') - @lang('page.title_create')</title>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('template/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('content')
    <div class="container px-5 page-my-goal" style="margin-bottom: 200px;">
        <div class="row">
            <div class="col-12">
                @include('components.breadcrumb', [
                    'title' => __('page.create_new_goal'),
                    'pages' => [
                        route('goal.mygoal.index') => __('page.my_goal'),
                        '#' => __('page.title_create'),
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
            <div class="col-md-12 col-sm-12">
                <form action="{{ route('goal.mygoal.store') }}" method="POST" class="mt-2 needs-validation" id="input-form" enctype="multipart/form-data" onsubmit="doSubmit($('#btn-submit'))">
                    @csrf
                    <div class="card shadow border-0 rounded-small card-dark">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group row d-flex align-items-center mb-3">
                                        <div class="col-lg-3 col-sm-12">
                                            <label for="title" class="form-label pt-2">@lang('form.lbl_title') <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-lg-9 col-sm-12">
                                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="title" placeholder="@lang('form.lbl_title')" value="{{ old('title') }}" required>
                                            @error('title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row d-flex align-items-center mb-3">
                                        <div class="col-lg-3 col-sm-12">
                                            <label for="description" class="form-label">@lang('form.lbl_description')</label>
                                        </div>
                                        <div class="col-lg-9 col-sm-12">
                                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3" style="line-height: 22px;" placeholder="@lang('form.lbl_description')">{{ old('description') }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row d-flex align-items-center mb-3">
                                        <div class="col-lg-3 col-sm-12">
                                            <label for="target" class="form-label">@lang('form.lbl_target') <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-lg-9 col-sm-12">
                                            <input type="text" type-currency="IDR" placeholder="Rp" name="target" class="form-control @error('target') is-invalid @enderror notif" id="target" placeholder="@lang('form.lbl_target')" value="{{ old('target') }}" required>
                                            @error('target')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row d-flex align-items-center m">
                                        <div class="form-group mb-3 col-lg-3 col-sm-12">
                                            <div class="form-check form-checkbox form-check-inline">
                                                <input type="checkbox" name="enable_milestone" class="form-check-input" value="1" id="enable-milestone" {{ old('enable_milestone') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="enable-milestone">
                                                    @lang('form.lbl_enable_milestone')</label>
                                            </div>
                                        </div>
                                        <div class="form-group mb-3 col-lg-9 col-sm-12" id="input-milestone" style="display: {{ old('enable_milestone') ? 'block;' : 'none;' }}">
                                            {{-- <label for="milestone" class="form-label">@lang('form.lbl_milestone') <span class="text-danger">*</span></label> --}}
                                            <div class="row input-daterange input-group" id="milestone">
                                                <div class="col">
                                                    <input type="text" class="form-control @error('start_at') is-invalid @enderror" name="start_at" id="start_at" placeholder="From ({{ $jsDateFormat }})" value="{{ old('start_at') }}" autocomplete="off" {{ old('enable_milestone') ? 'required' : '' }}>
                                                    @error('start_at')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col">
                                                    <input type="text" class="form-control @error('end_at') is-invalid @enderror" name="end_at" id="end_at" placeholder="To ({{ $jsDateFormat }})" value="{{ old('end_at') }}" autocomplete="off" {{ old('enable_milestone') ? 'required' : '' }}>
                                                    @error('end_at')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row d-flex align-items-center mb-3">
                                        <div class="col-lg-3 col-sm-12">
                                            <label class="form-label d-block"> @lang('form.lbl_target') @lang('form.lbl_visibility') <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-lg-9 col-sm-12">
                                            <div class="form-check form-check-inline">
                                                <input name="target_visibility" class="form-check-input @error('target_visibility') is-invalid @enderror" type="radio" id="target_visibility-public" value="1" {{ old('target_visibility') == 1 ? 'checked' : '' }} required>
                                                <label class="form-check-label" for="target_visibility-public">@lang('form.lbl_show')</label>
                                                @error('target_visibility')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-check form-check-inline mb-3">
                                                <input name="target_visibility" class="form-check-input @error('target_visibility') is-invalid @enderror" type="radio" id="target_visibility-private" value="2" {{ old('target_visibility') == 2 ? 'checked' : '' }} required>
                                                <label class="form-check-label" for="target_visibility-private">@lang('form.lbl_hide')</label>
                                                @error('target_visibility')
                                                    <div class="invalid-feedback">&nbsp;</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row d-flex align-items-center mb-3">
                                        <div class="col-lg-3 col-sm-12">
                                            <label class="form-label d-block">@lang('form.lbl_visibility') <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-lg-9 col-sm-12">
                                            <div class="form-check form-check-inline">
                                                <input name="visibility" class="form-check-input @error('visibility') is-invalid @enderror" type="radio" id="visibility-public" value="1" {{ old('visibility') == 1 ? 'checked' : '' }} required>
                                                <label class="form-check-label" for="visibility-public">@lang('form.lbl_visibility_public')</label>
                                                @error('visibility')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input name="visibility" class="form-check-input @error('visibility') is-invalid @enderror" type="radio" id="visibility-private" value="2" {{ old('visibility') == 2 ? 'checked' : '' }} required>
                                                <label class="form-check-label" for="visibility-private">@lang('form.lbl_visibility_private')</label>
                                                @error('visibility')
                                                    <div class="invalid-feedback">&nbsp;</div>
                                                @enderror
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input name="visibility" class="form-check-input @error('visibility') is-invalid @enderror" type="radio" id="visibility-supporter" value="3" {{ old('visibility') == 3 ? 'checked' : '' }} required>
                                                <label class="form-check-label" for="visibility-supporter">@lang('form.lbl_visibility_supporter')</label>
                                                @error('visibility')
                                                    <div class="invalid-feedback">&nbsp;</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <div class="col-lg-3  col-sm-12">
                                            <label class="form-label d-block">@lang('form.lbl_status') <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-lg-9 col-sm-12">
                                            <div class="form-check form-check-inline">
                                                <input name="status" class="form-check-input @error('status') is-invalid @enderror" type="radio" id="status-inactive" value="0" {{ old('status') == 0 ? 'checked' : (old('status') == 1 ? '' : 'checked') }} required>
                                                <label class="form-check-label" for="status-inactive">@lang('form.lbl_status_inactive')</label>
                                                @error('status')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input name="status" class="form-check-input @error('status') is-invalid @enderror" type="radio" id="status-active" value="1" {{ old('status') == 1 ? 'checked' : '' }} required>
                                                <label class="form-check-label" for="status-active">@lang('form.lbl_status_active')</label>
                                                @error('status')
                                                    <div class="invalid-feedback">&nbsp;</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer border-0 bg-transparent py-3">
                            <div class="d-flex justify-content-md-end justify-content-center gap-2">
                                <a href="{{ route('goal.mygoal.index') }}" class="btn btn-outline-danger rounded-pill">@lang('form.btn_cancel')</a>
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
    <script src="{{ asset('template/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/utils.js') }}"></script>
    <script type="text/javascript">
        /**
         * My goal create script
         * Version: 1.0
         */
        (function($) {
            @error('target')
                $('#target').val(({{ preg_replace('/[^0-9]+/', '', old('target')) }}).toLocaleString('id-ID', {
                    currency: 'IDR',
                    style: 'currency',
                    minimumFractionDigits: 0
                }));
            @enderror
            $('#milestone').datepicker(datePickerSetting('{{ $jsDateFormat }}'));

            $(document).on('change', '#enable-milestone', function() {
                if ($(this).is(':checked')) {
                    $('#input-milestone').show();
                    $('#start_at').attr('required', true);
                    $('#end_at').attr('required', true);
                } else {
                    $('#input-milestone').hide();
                    $('#start_at').attr('required', false);
                    $('#end_at').attr('required', false);
                }
            })

            document.querySelectorAll('input[type-currency="IDR"]').forEach((element) => {
                element.addEventListener('keyup', function(e) {
                    let cursorPostion = this.selectionStart;
                    let value = parseInt(this.value.replace(/[^,\d]/g, ''));
                    let originalLenght = this.value.length;
                    if (isNaN(value)) {
                        this.value = "";
                    } else {
                        this.value = value.toLocaleString('id-ID', {
                            currency: 'IDR',
                            style: 'currency',
                            minimumFractionDigits: 0
                        });
                        cursorPostion = this.value.length - originalLenght + cursorPostion;
                        this.setSelectionRange(cursorPostion, cursorPostion);
                    }
                });
            });
        })(jQuery);
    </script>
@endsection
