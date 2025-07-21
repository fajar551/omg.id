@extends('layouts.template-body')

@section('title')
    <title>@lang('page.title_setting') - @lang('page.social_link')</title>
@endsection

@section('styles')
    <style>
        @media(max-width:768px) {
            .px-4.social-form {
                padding: 0 10px !important;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container px-5 mb-5">
        <div class="row">
            <div class="col-12">
                @include('components.breadcrumb', [
                    'title' => __('page.title_setting'),
                    'pages' => [
                        route('setting.profile.index') => __('page.title_setting'),
                        '#' => __('page.social_link'),
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

        <div class="row">
            <div class="col-md-12 mt-3">
                <form action="{{ route('setting.social.store') }}" method="POST" class="mt-2 needs-validation" id="input-form" enctype="multipart/form-data" onsubmit="doSubmit($('#btn-submit'))" autocomplete="off">
                    @csrf
                    <div class="card shadow border-0 rounded-small card-dark">
                        <div class="card-body">
                            <div class="row d-flex justify-content-center">
                                <div class="col-sm-12 ">
                                    <div class="px-4 social-form">
                                        @foreach ($social_links as $key => $value)
                                            <div class="form-group mb-3 row use-tooltip" data-toggle="tooltip" data-placement="top" title="{{ $key }} link">
                                                <div class="col-lg-12">
                                                    <div class="input-group">
                                                        <span class="social-label d-none d-md-block input-group-text bg-primary rounded-0 py-2 px-3 text-white" style="width: 140px;"> {{ $key }}.com/</span>
                                                        <span class="social-label d-block d-md-none input-group-text align-items-end bg-primary py-2 px-3 text-white"> <i class="fab fa-{{ strtolower($key) }}"></i></span>
                                                        <input type="text" name="socials[{{ $key }}]" class="form-control control-group pe-5 @error("socials.$key") is-invalid @enderror" id="{{ $key }}" placeholder="@lang('form.lbl_add_social_link', ['social_link' => ucfirst($key)])" value="{{ old("socials.$key", $value) }}">
                                                        <span class="input-group-text group-addon">
                                                            @if (old("socials.$key", $value))
                                                                <a href="https://{{ $key }}.com/{{ old("socials.$key", $value) }}" class="text-primary" target="_blank"><i class="ri-external-link-fill"></i></a>
                                                            @else
                                                                <i class="ri-external-link-fill text-info"></i>
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        <div class="form-group mb-3 row">
                                            @error('socials.*')
                                                <div class="col-sm-3"></div>
                                                <div class="col-sm-9">
                                                    <div class="text-danger">{{ $message }}</div>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer border-0 bg-transparent py-3">
                            <div class="d-flex justify-content-md-end justify-content-center gap-2">
                                <button type="reset" class="btn  btn-outline-danger rounded-pill">@lang('form.btn_reset')</button>
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
