@extends('layouts.admin.omg')

@section('title',  __('Manage Admin - Create Permission'))

@section('styles')
    <style>
        .icon-text {
            font-size: 1.0rem;;
        }
    </style>
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
                       <li class="breadcrumb-item active" aria-current="page">@lang('Create')</li>
                    </ol>
                 </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                           <h5 class="card-title">@lang('Create New Permission')</h5>
                        </div>
                        <div class="card-header-toolbar d-flex align-items-center">
                            <p>&nbsp;</p>
                        </div>
                    </div>
                    <div class="card-body">
                        
                        @include('components.flash-message', ['flashName' => 'message'])
                        
                        <form action="{{ route('admin.administrator.permission.store') }}" method="POST" class="mt-2 needs-validation" id="input-form" enctype="multipart/form-data" onsubmit="doSubmit($('#btn-submit'))" autocomplete="off">
                            @csrf
                            @method('POST')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="input-name">@lang('Permission Name') *</label>
                                        <div class="input-group">
                                            <input name="name[]" id="input-name" type="text" class="form-control mb-0 @error('name.0') is-invalid @enderror" placeholder="@lang('Permission Name')" value="{{ old('name.0') }}" required>
                                            <span class="input-group-text" >
                                                <a href="javascript:void(0);" class="text-primary icon-text" onclick="addInputField()">
                                                    <i class="ri-add-circle-line"></i> 
                                                </a>
                                            </span>
                                            @error('name.0')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group" id="div-input-more">
                                        @if ($oldVal = old('name'))
                                            @foreach ($oldVal as $key => $item)
                                            
                                            @if ($key === 0) @continue @endif

                                            <div class="row more-attachment mt-3">
                                                <div class="input-group">
                                                    <input name="name[]" type="text" class="form-control mb-0 @error("name.$key") is-invalid @enderror" placeholder="@lang('Permission Name')" value="{{ old("name.$key") }}" required>
                                                    <span class="input-group-text" >
                                                        <a href="javascript:void(0);" class="text-danger icon-text" onclick="removeInputField(this)">
                                                            <i class="ri-indeterminate-circle-line"></i>
                                                        </a>
                                                    </span>
                                                    @error("name.$key")
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            @endforeach
                                        @endif
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
    
        let maxAllowedFields = 50;
        let counterFlag = 1;

        $(()=>{

        });

        const addInputField = () => {
            if(counterFlag < maxAllowedFields) {
                counterFlag++;
                let html = `
                    <div class="row more-attachment mt-3">
                        <div class="input-group">
                            <input name="name[]" id="input-name" type="text" class="form-control mb-0" placeholder="@lang('Permission Name')" value="" required>
                            <span class="input-group-text" >
                                <a href="javascript:void(0);" class="text-danger icon-text" onclick="removeInputField(this)">
                                    <i class="ri-indeterminate-circle-line"></i>
                                </a>
                            </span>
                        </div>
                    </div>`;

                $("#div-input-more").append(html);
            }
        }

        const removeInputField = (el) => {
            $(el).parents(".more-attachment").remove(); 
            counterFlag--;
        }
    </script>
@endsection