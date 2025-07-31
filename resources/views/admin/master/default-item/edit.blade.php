@extends('layouts.admin.omg')

@section('title')
    @lang('page.item') - @lang('page.title_edit')
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
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.master.defaultitem.index') }}">@lang('page.item')</a>
                        </li>
                       <li class="breadcrumb-item active" aria-current="page">@lang('page.title_edit')</li>
                    </ol>
                 </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                           <h5 class="card-title">@lang('page.edit_item')</h5>
                        </div>
                        <div class="card-header-toolbar d-flex align-items-center">
                            &nbsp;
                        </div>
                    </div>
                    <div class="card-body">

                        @include('components.flash-message', ['flashName' => 'message'])

                        <form action="{{ route('admin.master.defaultitem.edit') }}" method="POST" class="mt-2 needs-validation" id="input-form" enctype="multipart/form-data" onsubmit="doSubmit($('#btn-submit'))" autocomplete="off">
                            @csrf
                            @method("POST")
                            <input type="number" name="id" value="{{ $model["id"] }}" required hidden>
                            <div class="row">
                                <div class="col-md-8 ps-3 pe-3">
                                    <div class="form-group">
                                        <label class="form-label" for="item_name">@lang('form.lbl_item_name') *</label>
                                        <input name="name" type="text" id="name" class="form-control mb-0 @error('name') is-invalid @enderror" value="{{ old('name', $model['name']) }}" placeholder="@lang('form.lbl_item_name')" required>
                                        @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="price">@lang('form.lbl_item_price') *</label>
                                        <input name="price" type="number" id="price" min="1000" max="500000" step="1000" class="form-control mb-0 @error('price') is-invalid @enderror" value="{{ old('price', $model['price']) }}" placeholder="@lang('form.phd_item_price_min')" required>
                                        @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="description">@lang('form.lbl_description')</label>
                                        <input name="description" type="text" id="description" class="form-control mb-0 @error('description') is-invalid @enderror" value="{{ old('description', $model['description']) }}" placeholder="@lang('form.lbl_description')">
                                        @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 ps-3 pe-3">
                                    <div class="form-group">
                                        <label for="pm-icon-file" class="form-label custom-file-input @error('icon') is-invalid @enderror">@lang('form.lbl_icon') *</label>
                                        <div class=" align-items-center text-left">
                                            <div class=" profile-img-edit mb-3">
                                                <img class="img-fluid rounded profile-pic" id="enlarge-img" style="width: 150px; height: 170px;" src="{{ $model['icon'] ?? asset('assets/img/image.png') }}" alt="profile-pic">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mt-3">
                                        <input type="file" name="icon" id="pm-icon-file" class="form-control @error('icon') is-invalid @enderror" onchange="document.getElementById('enlarge-img').src = window.URL.createObjectURL(this.files[0])" accept="image/*" >
                                        @error('icon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-md-12">
                                    <div class="form-group row align-items-end text-end">
                                        <div class="col-md-12 pe-3">
                                            <a href="{{ route('admin.master.defaultitem.index') }}" class="btn bg-soft-danger me-2">@lang('form.btn_cancel')</a>
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
        $(() => {
            
        });
    </script>
@endsection