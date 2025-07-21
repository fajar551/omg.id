@extends('layouts.template-body')

@section('title')
    <title>@lang('page.item') - @lang('page.title_create')</title>
@endsection

@section('styles')
@endsection

@section('content')
    <div class="container px-5">
        <div class="row">
            <div class="col-12">
                @include('components.breadcrumb', [
                    'title' => __('page.create_new_item'),
                    'pages' => [
                        route('item.index') => __('page.item'),
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

        <form action="{{ route('item.store') }}" method="POST" class="needs-validation" id="input-form" enctype="multipart/form-data" onsubmit="doSubmit($('#btn-submit'))" autocomplete="off">
            @csrf
            <div class="row row-items">
                <div class="col-md-8 order-md-1 order-2">
                    <div class="card shadow border-0 rounded-small min-vh-50 card-dark">
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <div class="row d-flex justify-content-center">
                                    <label class="col-lg-3 col-sm-12 form-label" for="item_name">@lang('form.lbl_item_name') <span class="text-danger">*</span></label>
                                    <div class="col-lg-9 col-sm-12">
                                        <input name="name" type="text" maxlength="50" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Eskrim" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <div class="row d-flex justify-content-center">
                                    <label class="form-label col-lg-3 col-sm-12" for="price">@lang('form.lbl_item_price') <span class="text-danger">*</span></label>
                                    <div class="col-lg-9 col-sm-12">
                                        <input name="price" type="text" type-currency="IDR" id="price" min="1000" max="500000" step="1000" class="form-control @error('price') is-invalid @enderror" value="" placeholder="Rp 20.000" required>
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <div class="row d-flex justify-content-center">
                                    <label class="form-label col-lg-3 col-sm-12" for="description">@lang('form.lbl_description')</label>
                                    <div class="col-lg-9 col-sm-12">
                                        <input name="description" max="10" type="text" id="description" maxlength="100" class="form-control @error('description') is-invalid @enderror" value="{{ old('description') }}" placeholder="Makan Eskrim enak nih, jadi semangat bikin konten!">
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer border-0 bg-transparent py-3">
                            <div class="d-flex justify-content-md-end justify-content-center gap-2">
                                <a href="{{ route('item.index') }}" class="btn btn-outline-danger rounded-pill">@lang('form.btn_cancel')</a>
                                <button type="submit" id="btn-submit" class="btn btn-primary rounded-pill">@lang('form.btn_submit')</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 order-md-2 order-1 mb-3">
                    <div class="card shadow border-0 rounded-small min-vh-50 card-dark">
                        <div class="card-header border-0 bg-transparent">
                            <label class="form-label" for="enlarge-img">Icon <span class="text-danger">*</span></label>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                {{-- <label for="pm-icon-file" class="form-label custom-file-input @error('icon') is-invalid @enderror">@lang('form.lbl_icon') *</label> --}}
                                <div class="d-flex justify-content-center">
                                    <img class="img-thumbnail rounded icon-160" id="enlarge-img" src="{{ $profile_picture ?? asset('assets/img/image.png') }}" alt="">
                                </div>
                            </div>

                            <div class="form-group mt-3 ">
                                <div class="custom-file">
                                    <input type="file" name="icon" id="pm-icon-file" class="form-control-sm py-2 px-3 border w-100 @error('icon') is-invalid @enderror" onchange="document.getElementById('enlarge-img').src = window.URL.createObjectURL(this.files[0])" accept="image/*" required>
                                    <small class="">*) jpg, jpeg, png, Max: 1mb</small>
                                    @error('icon')
                                        <div class="invalid-feedback text-danger mt-3">{{ $message }}</div>
                                    @enderror
                                    {{-- <div class="input-group mb-3 mask-input">                                            
                                        <div class="input-group-prepend">
                                        <span class="btn btn-primary" id="basic-addon1">Choose File</span>
                                        </div>
                                        <input type="text" class="form-control form-control notif px-0" aria-label="Username" aria-describedby="basic-addon1">
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/utils.js') }}"></script>
    <script type="text/javascript">
        $(() => {

            @error('price')
                $('#price').val(({{ preg_replace('/[^0-9]+/', '', old('price')) }}).toLocaleString('id-ID', {
                    currency: 'IDR',
                    style: 'currency',
                    minimumFractionDigits: 0
                }));
            @enderror

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

        });
    </script>
@endsection
