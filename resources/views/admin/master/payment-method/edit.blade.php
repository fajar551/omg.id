@extends('layouts.admin.omg')

@section('title')
    @lang('page.payment_method') - @lang('page.title_edit')
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
                            <a href="{{ route('admin.master.paymentmethod.index') }}">@lang('page.payment_method')</a>
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
                           <h5 class="card-title">@lang('page.title_edit') @lang('page.payment_method')</h5>
                        </div>
                        <div class="card-header-toolbar d-flex align-items-center">
                            &nbsp;
                        </div>
                    </div>
                    <div class="card-body">

                        @include('components.flash-message', ['flashName' => 'message'])

                        <form action="{{ route('admin.master.paymentmethod.update') }}" method="POST" class="mt-2 needs-validation" id="input-form" enctype="multipart/form-data" onsubmit="doSubmit($('#btn-submit'))" autocomplete="off">
                            @csrf
                            @method("POST")
                            <input type="number" name="id" value="{{ $model["id"] }}" required hidden>
                            <div class="row">
                                <div class="col-md-8 ps-3 pe-3">
                                    <div class="form-group">
                                        <label class="form-label" for="item_name">@lang('form.lbl_name') *</label>
                                        <input name="name" type="text" id="name" class="form-control mb-0 @error('name') is-invalid @enderror" value="{{ old('name', $model['name']) }}" placeholder="@lang('Payment Name')" required>
                                        @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="type" class="form-label">{{ __('form.lbl_type') }}</label> <br>
                                        <div class="form-check custom-radio form-check-inline">
                                            <input type="radio" id="type1" name="type" value="1" onclick="showdiv(1)" class="form-check-input" {{ old('type', $model['type']) == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="customRadio7"> E-Wallet </label>
                                        </div>
                                        <div class="form-check custom-radio form-check-inline">
                                            <input type="radio" id="type2" value="2" name="type" onclick="showdiv(2)" class="form-check-input" {{ old('type', $model['type']) == 2 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="customRadio6"> Bank </label>
                                        </div>
                                    </div>
                                    <div class="form-group" id="div_payment_type">
                                        <label class="form-label" for="item_name">@lang('Channel Code') *</label>
                                        <input name="payment_type" type="text" id="payment_type" class="form-control mb-0 @error('payment_type') is-invalid @enderror" value="{{ old('payment_type', $model['payment_type']) }}" placeholder="@lang('Channel Code')" required>
                                        @error('payment_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group" id="div_bank_name">
                                        <label class="form-label" for="item_name">@lang('Channel Code') *</label>
                                        <input name="bank_name" type="text" id="bank_name" class="form-control mb-0 @error('bank_name') is-invalid @enderror" value="{{ old('bank_name', $model['bank_name']) }}" placeholder="@lang('Channel Code')" required>
                                        @error('bank_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="item_order">@lang('Position')</label>
                                        <input name="order" type="number" id="order" class="form-control mb-0 @error('order') is-invalid @enderror" value="{{ old('order', $model['order']) }}" placeholder="@lang('Payment Method Position')" required>
                                        @error('order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 ps-3 pe-3">
                                    <div class="form-group">
                                        <label for="pm-icon-file" class="form-label custom-file-input @error('icon') is-invalid @enderror">@lang('form.lbl_icon') *</label>
                                        <div class=" align-items-center text-left">
                                            <div class=" profile-img-edit mb-3">
                                                <img class="img-fluid rounded profile-pic" id="enlarge-img" style="width: 150px; height: 170px;" src="{{ $model['image'] ?? asset('assets/img/image.png') }}" alt="profile-pic">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mt-3">
                                        <input type="file" name="image" id="pm-icon-file" class="form-control @error('image') is-invalid @enderror" onchange="document.getElementById('enlarge-img').src = window.URL.createObjectURL(this.files[0])" accept="image/*" >
                                        @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-md-12">
                                    <div class="form-group row align-items-end text-end">
                                        <div class="col-md-12 pe-3">
                                            <a href="{{ route('admin.master.paymentmethod.index') }}" class="btn bg-soft-danger me-2">@lang('form.btn_cancel')</a>
                                            <button type="button" id="btn-submit" class="btn btn-primary" onclick="submitConfirm()">@lang('form.btn_submit')</button>
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
            var id = {{ old('type', $model['type'])}};
            showdiv(id);
        });

        const showdiv = (id)  => {
            // console.log(id);
            var div_payment_type = document.getElementById("div_payment_type");
            var div_bank_name = document.getElementById("div_bank_name");
            if (id == 1) {
                if ({{ $model['type'] }} == 1) {
                    $('input[name=payment_type]').val("{{ old('payment_type', $model['payment_type'])}}");
                    $('input[name=bank_name]').val("");
                } else {
                    $('input[name=payment_type]').val("{{ old('bank_name', $model['bank_name'])}}");
                    $('input[name=bank_name]').val("");
                }
                div_payment_type.style.display = "block";
                div_bank_name.style.display = "none";
            } else {
                if ({{ $model['type'] }} == 1) {
                    $('input[name=payment_type]').val("bank_transfer");
                    $('input[name=bank_name]').val("{{ old('payment_type', $model['payment_type'])}}");
                } else {
                    $('input[name=payment_type]').val("bank_transfer");
                    $('input[name=bank_name]').val("{{ old('bank_name', $model['bank_name'])}}");
                }
                div_payment_type.style.display = "none";
                div_bank_name.style.display = "block";
            }
        }

        const submitConfirm = () => {
            var type = $('input[name=type]:checked').val();
            // console.log(type);
            if (type == 1) {
                $('input[name=bank_name]').val("");
            } else {
                $('input[name=payment_type]').val("bank_transfer");
            }
            $('#input-form').submit();
        }
    </script>
@endsection