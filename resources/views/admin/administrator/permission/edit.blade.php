@extends('layouts.admin.omg')

@section('title',  __('Manage Admin - Edit Permission'))

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
                            <a href="{{ route('admin.administrator.permission.index') }}">@lang('Permission')</a>
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
                           <h5 class="card-title">@lang('Edit Permission')</h5>
                        </div>
                        <div class="card-header-toolbar d-flex align-items-center">
                            <p>&nbsp;</p>
                        </div>
                    </div>
                    <div class="card-body">
                        
                        @include('components.flash-message', ['flashName' => 'message'])
                        
                        <form action="{{ route('admin.administrator.permission.update') }}" method="POST" class="mt-2 needs-validation" id="input-form" enctype="multipart/form-data" onsubmit="doSubmit($('#btn-submit'))" autocomplete="off">
                            @csrf
                            @method('PUT')
                            <input type="number" name="id" value="{{ $model->id }}" hidden required>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title" class="form-label">@lang('Permission Name') *</label>
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="@lang('Permission Name')" value="{{ old('name', $model->name) }}" required>
                                        @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="small mt-2">
                                            <strong><i>
                                            *@lang("Warning"): @lang("if you modify this permission, the users that assigned by this permission won't be able to access menus or can't do actions that related to this permissions.") 
                                            </strong></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-md-12">
                                    <div class="form-group row align-items-end text-end">
                                        <div class="col-md-6">
                                            <a href="{{ route('admin.administrator.permission.index') }}" type="reset" class="btn bg-soft-danger me-2">@lang('form.btn_cancel')</a>
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

        });
    </script>
@endsection