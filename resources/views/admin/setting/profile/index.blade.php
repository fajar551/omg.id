@extends('layouts.admin.omg')

@section('title')
    @lang('page.title_setting') - @lang('page.profile')
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
                        <li class="breadcrumb-item active" aria-current="page">@lang('page.profile')</li>
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
                           <h5 class="card-title">@lang('page.update_profile')</h5>
                        </div>
                        <div class="card-header-toolbar d-flex align-items-center">
                            <p>&nbsp;</p>
                        </div>
                    </div>
                    <div class="card-body">

                        @include('components.flash-message', ['flashName' => 'message'])

                        <form action="{{ route('admin.setting.profile.update') }}" method="POST" class="mt-2 needs-validation" id="input-form" enctype="multipart/form-data" onsubmit="doSubmit($('#btn-submit'))">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class=" align-items-center text-center">
                                            <div class=" profile-img-edit mb-3">
                                                <img class="img-fluid rounded profile-pic" id="enlarge-img" style="width: 150px; height: 170px;" src="{{ $profile_picture ?? asset('template/images/user/user.png') }}" alt="profile-pic">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mt-3">
                                        {{-- <label for="pm-icon-file" class="form-label custom-file-input @error('image') is-invalid @enderror">@lang('Change Icon')</label> --}}
                                        <input class="form-control @error('profile_picture') is-invalid @enderror" type="file" name="profile_picture" id="pm-icon-file" onchange="document.getElementById('enlarge-img').src = window.URL.createObjectURL(this.files[0])" accept="image/*">
                                        @error('profile_picture')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="name" class="form-label">@lang('form.lbl_full_name') *</label>
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="@lang('form.lbl_full_name')" value="{{ old('name', $name) }}" required>
                                        @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="username" class="form-label">@lang('form.lbl_username') *</label>
                                        <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" id="username" placeholder="@lang('form.lbl_username')" value="{{ old('username', $username) }}" required>
                                        @error('username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="form-label">@lang('form.lbl_email')</label>
                                        <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="budi@mail.com" value="{{ $email }}" readonly disabled>
                                        @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="form-label d-block">@lang('form.lbl_gender') *</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" id="inlineRadio10" value="male" {{ old('gender', $gender) == "male" ? 'checked' : '' }}>
                                            <label class="form-check-label" for="inlineRadio10">@lang('form.lbl_gender_male')</label>
                                            @error('gender')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" id="inlineRadio11" value="female" {{ old('gender', $gender) == "female" ? 'checked' : '' }}>
                                            <label class="form-check-label" for="inlineRadio11">@lang('form.lbl_gender_female')</label>
                                            @error('gender')
                                            <div class="invalid-feedback">&nbsp;</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone_number" class="form-label">@lang('form.lbl_phone_number') @lang('form.lbl_phone_number_rule')</label>
                                        <input type="text" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" placeholder="+62-899-xxx-xxx" value="{{ old('phone_number', $phone_number) }}">
                                        @error('phone_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label class="form-label">@lang('form.lbl_address')</label>
                                        <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="5" style="line-height: 22px;" placeholder="@lang('form.lbl_address')">{{ old('address', $address) }}</textarea>
                                        @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-md-12">
                                    <div class="form-group row align-items-end text-end">
                                        <div class="col-md-8"></div>
                                        <div class="col-md-4">
                                            <button type="reset" onclick="$('#enlarge-img').attr('src', '{{ $profile_picture ?? asset('template/images/user/user.png') }}'); return true" class="btn bg-soft-danger me-2">@lang('form.btn_cancel')</button>
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
    <script type="text/javascript" src="{{ asset('assets/js/submit.js') }}"></script>
    <script type="text/javascript">
        $(()=>{

        });
    </script>
@endsection