@extends('layouts.admin.omg')

@section('title',  __('Manage Admin - Edit Admin'))

@section('styles')

@endsection

@section('content')
    <div class="container-xl">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-soft-primary">
                        <li class="breadcrumb-item">
                           <a href="{{ route('admin.home') }}"><i class="ri-home-4-line me-1"></i>@lang('page.title_home')</a>
                        </li>
                        <li class="breadcrumb-item">@lang('Manage Admin')</li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.administrator.list.index') }}">@lang('Administrator List')</a>
                        </li>
                       <li class="breadcrumb-item active" aria-current="page">@lang('Edit')</li>
                    </ol>
                 </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                           <h5 class="card-title">@lang('Edit Admin')</h5>
                        </div>
                        <div class="card-header-toolbar d-flex align-items-center">
                            <p>&nbsp;</p>
                        </div>
                    </div>
                    <div class="card-body">
                        
                        @include('components.flash-message', ['flashName' => 'message'])
                        
                        <form action="{{ route('admin.administrator.list.update') }}" method="POST" class="mt-2 needs-validation" id="input-form" enctype="multipart/form-data" onsubmit="doSubmit($('#btn-submit'))" autocomplete="off">
                            @csrf
                            @method('PUT')
                            <input type="number" name="id" value="{{ $model->id }}" required hidden>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="ms-2 me-3">
                                        <div class="form-group">
                                            <label for="name" class="form-label">@lang('form.lbl_full_name') *</label>
                                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="@lang('form.lbl_full_name')" value="{{ old('name', $model->name) }}" required>
                                            @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="username" class="form-label">@lang('form.lbl_username') *</label>
                                            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" id="username" placeholder="@lang('form.lbl_username')" value="{{ old('username', $model->username) }}" required>
                                            @error('username')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="email" class="form-label">@lang('form.lbl_email')</label>
                                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="budi@mail.com" value="{{ old('email', $model->email) }}" required>
                                            @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="password">@lang('form.lbl_password') *</label>
                                            <div class="input-group">
                                                <input name="password" type="password" id="password" class="form-control mb-0 @error('password') is-invalid @enderror" placeholder="Budi123" autocomplete="new-password">
                                                <span class="input-group-text" >
                                                    <i class="far fa-eye-slash" onclick="showHidePassword(this, $('#password'))"></i>
                                                </span>
                                                @error('password')
                                                <div class="invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="confirm-password">@lang('form.lbl_confirm_password') *</label>
                                            <div class="input-group">
                                                <input name="password_confirmation" id="confirm-password" type="password" class="form-control mb-0 @error('password') is-invalid @enderror" placeholder="Budi123" autocomplete="new-password">
                                                <span class="input-group-text" >
                                                    <i class="far fa-eye-slash" onclick="showHidePassword(this, $('#confirm-password'))"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label d-block">@lang('form.lbl_gender') *</label>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" id="inlineRadio10" value="male" {{ old('gender', $model->gender) == "male" ? 'checked' : '' }} required>
                                                        <label class="form-check-label" for="inlineRadio10">@lang('form.lbl_gender_male')</label>
                                                        @error('gender')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" id="inlineRadio11" value="female" {{ old('gender', $model->gender) == "female" ? 'checked' : '' }} required>
                                                        <label class="form-check-label" for="inlineRadio11">@lang('form.lbl_gender_female')</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label d-block">@lang('form.lbl_status') *</label>
                                                    <div class="form-check form-check-inline">
                                                        <input name="status" class="form-check-input @error('status') is-invalid @enderror" type="radio" id="status-active" value="1" {{ old('status', $model->status) == '1' ? 'checked' : '' }} required>
                                                        <label class="form-check-label" for="status-active">@lang('form.lbl_status_active')</label>
                                                        @error('status')
                                                        <div class="invalid-feedback">&nbsp;</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input name="status" class="form-check-input @error('status') is-invalid @enderror" type="radio" id="status-inactive" value="0" {{ old('status', $model->status) == '0' ? 'checked' : '' }} required>
                                                        <label class="form-check-label" for="status-inactive">@lang('form.lbl_status_inactive')</label>
                                                        @error('status')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">@lang('form.lbl_address')</label>
                                            <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="3" style="line-height: 22px;" placeholder="@lang('form.lbl_address')">{{ old('address', $model->address) }}</textarea>
                                            @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <div class=" align-items-center text-left">
                                                <div class=" profile-img-edit ">
                                                    <img class="img-fluid rounded profile-pic" id="enlarge-img" style="width: 160px; height: 160px;" src="{{ $model->profile_picture ? route('api.profile.preview', ['file_name' => $model->profile_picture]) : asset('template/images/user/user.png') }}" alt="profile-pic">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="form-label">@lang('form.lbl_profile_picture')</label>
                                            <input class="form-control @error('profile_picture') is-invalid @enderror" type="file" name="profile_picture" id="pm-icon-file" onchange="document.getElementById('enlarge-img').src = window.URL.createObjectURL(this.files[0])" accept="image/*">
                                            @error('profile_picture')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="ms-3 me-2">
                                        <div class="mt-1 mb-2">
                                            <h4>@lang('User Privileges')</h4>
                                            {{-- <p>@lang('Add user privileges')</p> --}}
                                        </div>
                                        <div class="form-group" id="role-checkbox">
                                            <label class="form-label">@lang('form.lbl_roles') *</label>
                                            <br>
                                            @foreach ($roles as $key => $role)
                                            <div class="form-check me-3">
                                                <input type="checkbox" name="roles[{{$key}}]" class="form-check-input @error("roles.$key") is-invalid @enderror" value="{{ $key }}" id="roles-{{ $key }}" 
                                                @if(old("roles.$key")) 
                                                    checked 
                                                @elseif($model->isRoleIdSelected($key))
                                                    checked 
                                                @endif>
                                                <label class="form-check-label" for="roles-{{ $key }}">{{ ucwords($role) }}</label>
                                                @error("roles.$key")
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            @endforeach
                                        </div>
                                        <div class="form-group" id="permission-checkbox">
                                            <label class="form-check-label me-2" for="checkAll">@lang('form.lbl_check_all_permissions') *</label>
                                            <div class="form-check form-switch">
                                                <input type="checkbox" name="checkall" class="form-check-input" id="checkAll" 
                                                @if(old("checkall")) 
                                                    checked 
                                                @elseif(count($permissions) == $model->permissions->count())
                                                    checked 
                                                @endif>
                                            </div>
                                            <br>
                                            @foreach (collect($permissions)->chunk(2) as $chunkPermissions)
                                                <div class="row">
                                                @foreach ($chunkPermissions as $key => $permission)
                                                    <div class="col-md-6">
                                                        <div class="form-check me-3">
                                                            <input type="checkbox" name="permissions[{{$key}}]" class="form-check-input @error("permissions.$key") is-invalid @enderror" value="{{ $key }}" id="permissions-{{ $key }}" 
                                                            @if(old("permissions.$key")) 
                                                                checked 
                                                            @elseif($model->isPermissionIdSelected($key))
                                                                checked
                                                            @endif >
                                                            <label class="form-check-label" for="permissions-{{ $key }}">{{ ucwords($permission) }}</label>
                                                            @error("permissions.$key")
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                @endforeach
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-md-12">
                                    <div class="form-group row align-items-end text-end  me-2">
                                        <div class="col-md-12">
                                            <a href="{{ route('admin.administrator.list.index') }}" type="reset" class="btn bg-soft-danger me-2">@lang('form.btn_cancel')</a>
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
    <script src="{{ asset('assets/js/utils.js') }}"></script>
    <script type="text/javascript">
        $(()=>{
            // const requiredCb = $('#role-checkbox :checkbox[required]');
            // const requiredCb = $('#role-checkbox input[type=checkbox]');
            // requiredCb.change(function(){
            //     if(requiredCb.is(':checked')) {
            //         requiredCb.removeAttr('required');
            //     } else {
            //         requiredCb.attr('required', 'required');
            //     }
            // });

            requiredOneCheckbox('#role-checkbox');
            requiredOneCheckbox('#permission-checkbox', 1);
            
            $("#checkAll").change(function() {
                $("#permission-checkbox input[type=checkbox]").prop('checked', $(this).prop('checked'));
                requiredOneCheckbox('#permission-checkbox', 1);
            });
        });

        function requiredOneCheckbox(el, firstCbIndex = 0) {
            // const form = document.querySelector('#role-checkbox');
            const form = document.querySelector(el);
            const checkboxes = form.querySelectorAll('input[type=checkbox]');
            const checkboxLength = checkboxes.length;
            const firstCheckbox = checkboxLength > 0 ? checkboxes[firstCbIndex] : null;
    
            function init() {
                if (firstCheckbox) {
                    for (let i = 0; i < checkboxLength; i++) {
                        checkboxes[i].addEventListener('change', checkValidity);
                    }
    
                    checkValidity();
                }
            }
    
            function isChecked() {
                for (let i = 0; i < checkboxLength; i++) {
                    if (checkboxes[i].checked) return true;
                }
    
                return false;
            }
    
            function checkValidity() {
                const errorMessage = !isChecked() ? 'At least one or more checkbox must be checked.' : '';
                firstCheckbox.setCustomValidity(errorMessage);
            }

            init();
        }


    </script>
@endsection