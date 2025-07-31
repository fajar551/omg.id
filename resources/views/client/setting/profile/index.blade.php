@extends('layouts.template-body')

@section('title')
    <title>@lang('page.title_setting') - @lang('page.profile')</title>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css" integrity="sha512-zxBiDORGDEAYDdKLuYU9X/JaJo/DPzE42UubfBw9yg8Qvb2YRRIQ8v4KsGHOx2H1/+sdSXyXxLXv5r7tHc9ygg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .bg-infos {
            background: #DABAFF;
            border-radius: 3px;
        }

        .card-karya {
            background: #FFFFFF;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .upload-wrapper {
            width: 200px;
            height: 220px;
            margin: 0 auto;
            border-radius: 50% !important;
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
                        '#' => __('page.profile'),
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
                <form action="{{ route('setting.profile.update') }}" method="POST" class="mt-2 needs-validation " id="input-form" enctype="multipart/form-data" onsubmit="doSubmit($('#btn-submit'))">
                    @csrf
                    <div class="card shadow border-0 rounded-small card-dark">
                        <div class="card-body">
                            <div class="row">
                                {{-- <div class="col-lg-3 col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <div class=" align-items-center text-center">
                                            <div class=" profile-img-edit mb-3">
                                                <img class="img-fluid img-thumbnail rounded-circle profile-pic" id="enlarge-img" style="width: 150px; height: 150px; object-fit: cover;" src="{{ $profile_picture ?? asset('template/images/user/user.png') }}" alt="profile-pic">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group my-3 ">
                                        <label for="pm-icon-file" class="form-label custom-file-input @error('image') is-invalid @enderror">@lang('Change Icon')</label>
                                        <input class="form-control-sm py-2 px-3 border w-100 @error('profile_picture') is-invalid @enderror" type="file" name="profile_picture" id="pm-icon-file" onchange="document.getElementById('enlarge-img').src = window.URL.createObjectURL(this.files[0])" accept="image/*">
                                        <small class="">*) jpg, jpeg, png, Max: 2mb</small>
                                        @error('profile_picture')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div> --}}

                                <div class="col-lg-3 col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <div class="upload-wrapper">
                                            <div id="upload-preview"></div>
                                        </div>
                                    </div>
                                    <div class="form-group my-3 ">
                                        <input type="file" id="upload" class="form-control-sm py-2 px-3 border w-100 @error('profile_picture') is-invalid @enderror" accept="image/*">
                                        <small class="">*) jpg, jpeg, png, Max: 2mb</small>
                                        @error('profile_picture')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group my-3 ">
                                        <button type="button" class="btn btn-outline-success w-100" id="btn-save-crop">Crop & Save</button>
                                    </div>
                                </div>

                                <div class="col-lg-9 col-md-8 col-sm-12">
                                    <div class="form-group mb-2">
                                        <label for="name" class="form-label">@lang('form.lbl_full_name') <span class="text-danger fw-bold"><span class="text-danger fw-bold">*</span></span> </label>
                                        <input type="text" name="name" class="form-control blured-input @error('name') is-invalid @enderror notif" id="name" placeholder="Budi Luhur" value="{{ old('name', $name) }}" required>
                                        <small>*) Double click to edit</small>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="username" class="form-label">@lang('form.lbl_username') <span class="text-danger fw-bold">*</span></label>
                                        <input type="text" name="username" class="form-control blured-input @error('username') is-invalid @enderror notif" id="username" placeholder="budi" value="{{ old('username', $username) }}" required>
                                        <small>*) Double click to edit</small>
                                        @error('username')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="email" class="form-label">@lang('form.lbl_email')</label>
                                        <input type="text" class="form-control blured-input @error('email') is-invalid @enderror notif" id="email" placeholder="budi@mail.com" value="{{ $email }}" readonly disabled>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-2">
                                        <label class="form-label d-block">@lang('form.lbl_gender') <span class="text-danger fw-bold">*</span> <a class="text-dark" title="Click to expand" data-bs-toggle="collapse" data-bs-target=".multi-collapse" aria-expanded="false" aria-controls="multiCollapseExample1 multiCollapseExample2"> <i class="fas fa-caret-down"></i></a></label>
                                        <div class="collapse multi-collapse @error('gender') show @enderror" id="multiCollapseExample1">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input @error('gender') is-invalid @enderror notif" type="radio" name="gender" id="inlineRadio10" value="male" {{ old('gender', $gender) == 'male' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="inlineRadio10">@lang('form.lbl_gender_male')</label>
                                                @error('gender')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input @error('gender') is-invalid @enderror notif" type="radio" name="gender" id="inlineRadio11" value="female" {{ old('gender', $gender) == 'female' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="inlineRadio11">@lang('form.lbl_gender_female')</label>
                                                @error('gender')
                                                    <div class="invalid-feedback">&nbsp;</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="phone_number" class="form-label">@lang('form.lbl_phone_number') @lang('form.lbl_phone_number_rule')</label>
                                        <input type="text" name="phone_number" class="form-control @if (old('phone_number', $phone_number)) blured-input @endif @error('phone_number') is-invalid @enderror notif" id="phone_number" placeholder="+62-8xx-xxx-xxx" value="{{ old('phone_number', $phone_number) }}">
                                        @if (old('phone_number', $phone_number))
                                            <small>*) Double click to edit</small>
                                        @endif
                                        @error('phone_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-2">
                                        <label class="form-label">@lang('form.lbl_address')</label>
                                        <textarea name="address" class="form-control @if (old('address', $address)) blured-input @endif @error('address') is-invalid @enderror notif" rows="5" style="line-height: 22px;" placeholder="Jl.Sukamaju no.123">{{ old('address', $address) }}</textarea>
                                        @if (old('address', $address))
                                            <small>*) Double click to edit</small>
                                        @endif
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    {{-- <div class="d-flex justify-content-end ">
                                    <button type="reset" onclick="$('#enlarge-img').attr('src', '{{ $profile_picture ?? asset('template/images/user/user.png') }}'); return true" class="btn  btn-outline-danger rounded-pill me-2">@lang('form.btn_reset')</button>
                                    <button type="submit" id="btn-submit" class="btn btn-primary rounded-pill">@lang('form.btn_submit')</button>
                                </div> --}}
                                </div>
                            </div>
                            <!-- <div class="row mt-5">
                                <div class="col-md-12">
                                    <div class="form-group row align-items-end text-end content-action">
                                        <div class="col-md-8   "></div>
                                        <div class="col-md-4 col-sm-12 d-flex">
                                            <button type="reset" onclick="$('#enlarge-img').attr('src', '{{ $profile_picture ?? asset('template/images/user/user.png') }}'); return true" class="btn btn-sm btn-outline-danger me-2">@lang('form.btn_reset')</button>
                                            <button type="submit" id="btn-submit" class="btn btn-sm btn-primary">@lang('form.btn_submit')</button>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                        <div class="card-footer border-0 bg-transparent py-3">
                            <div class="d-flex justify-content-md-end justify-content-center gap-2">
                                <button type="reset" class="btn btn-outline-danger rounded-pill" id="btn-reset">@lang('form.btn_reset')</button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js" integrity="sha512-Gs+PsXsGkmr+15rqObPJbenQ2wB3qYvTHuJO6YJzPe/dTLvhy0fmae2BcnaozxDo5iaF8emzmCZWbQ1XXiX2Ig==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="{{ asset('assets/js/submit.js') }}"></script>
    <script src="{{ asset('assets/js/alert.js') }}"></script>
    <script type="text/javascript">
        /**
         * Setting page script
         * Version: 1.0
         */
        (function($) {
            "use strict";

            const event = {
                focus: function() {
                    if (!$(this).data('disabled')) this.blur()
                },
                dblclick: function() {
                    $(this).data('disabled', true);
                    this.focus()
                },
                blur: function() {
                    $(this).data('disabled', false);
                }
            }

            $('input[name="name"]').on(event);
            $('input[name="username"]').on(event);

            @if (old('phone_number', $phone_number))
                $('input[name="phone_number"]').on(event);
            @endif

            @if (old('address', $address))
                $('textarea[name="address"]').on(event);
            @endif

            let $uploadCrop;

            function croppyUpload() {
                function readFile(input) {
                    if (input.files && input.files[0]) {
                        const reader = new FileReader();
                        
                        reader.onload = function (e) {
                            $uploadCrop.croppie('bind', {
                                url: e.target.result
                            }).then(function(){
                                console.log('Image cropper is ready');
                            }).catch(function(res) {
                                alert('Something went wrong, please choose another file.');
                            });
                        }
                        
                        reader.readAsDataURL(input.files[0]);
                    } else {
                        alert("Sorry - you're browser doesn't support the FileReader API");
                    }
                }

                $uploadCrop = $('#upload-preview').croppie({
                    viewport: {
                        width: 190,
                        height: 210,
                        type: 'square' // circle
                    },
                    showZoomer: false,
                });

                $('#upload').on('change', function () { 
                    readFile(this); 
                });

                $('#btn-save-crop').on('click', function (e) {
                    $uploadCrop.croppie('result', {
                        type: 'canvas', // blob
                        size: 'viewport'
                    }).then(async function (result) {
                        await saveImage({
                            src: result
                        });
                    });
                });
            }

            async function saveImage(result) {
                const src = result.src;
                $('#btn-save-crop').attr({ disabled: true }).html("Loading...");

                const formData = {
                    "profile_picture": src
                };

                await axios.post(`/client/setting/profile/update/profilepic`, formData)
                    .then(({ data }) => {
                        const { message } = data;

                        Toast2.fire({ 
                            icon: 'success', 
                            title: 'Image cropped and saved successfully!' 
                        });
                    }).catch(({ response: { data }}) => {
                        const { message, errors = {} } = data;

                        Toast2.fire({ 
                            icon: 'error', 
                            title: 'An error occurred! ' +message 
                        });
                        console.log(data);
                    }).finally(() => {
                        $('#btn-save-crop').attr({ disabled: false }).html("Crop & Save");
                    });
            }

            function bindCroppyUrl() {
                if ($uploadCrop) {
                    $uploadCrop.croppie('bind', {
                        url: "{{ $profile_picture ?? asset('template/images/user/user.png') }}",
                    });
                } else {
                    console.log('Croppy instance is not ready.');
                }
            }

            croppyUpload();
            setTimeout(() => {
                bindCroppyUrl();
            }, 600);
            
            $('#btn-reset').on('click', function(e) {
                bindCroppyUrl();
            });
        })(jQuery);
    </script>
@endsection
