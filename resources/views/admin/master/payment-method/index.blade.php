@extends('layouts.admin.omg')

@section('title',  __('Data Master - Payment Method'))

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
                       <li class="breadcrumb-item">@lang('Data Master')</li>
                       <li class="breadcrumb-item active" aria-current="page">@lang('page.support_payment_method')</li>
                    </ol>
                 </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                           <h5 class="card-title">@lang('page.support_payment_method')</h5>
                        </div>
                        <div class="card-header-toolbar d-flex align-items-center">
                            <a href="{{ route('admin.master.paymentmethod.create') }}" type="button" class="btn btn-outline-primary mb-1"><i class="las la-plus-circle"></i> @lang('page.create')</a>
                        </div>
                    </div>
                    <div class="card-body">
                        
                        @include('components.flash-message', ['flashName' => 'message'])
                        
                        <div class="row">
                            <div class="col-sm-12">
                                @foreach ($paymentMethods as $key => $payments)
                                <div class="row">
                                    <div class="mt-2 mb-3">
                                        <h4>{{ ucwords($key) }}</h4>
                                        <p>List all available {{ ucwords($key) }} payment method</p>
                                    </div>
                                    @foreach ($payments as $pm)
                                    <div class="col-sm-4 col-md-4">
                                        <div class="card card-dark-80 ">
                                            <div class="card-header card-dark-80 d-flex justify-content-between p-2">
                                                <div class="header-title">
                                                    <a href="javascript:void(0);" onclick="changeIcon({{ $pm['id'] }})">
                                                        <img src="{{ $pm['image'] ?? asset('assets/img/image.png') }}" alt="profile-img" id="pm-icon-{{ $pm['id'] }}" class="img-fluid rounded" style="width: auto; height: 70px; border-color:">
                                                    </a>
                                                </div>
                                                <div class="card-header-toolbar d-flex align-items-center">
                                                    <div class="dropdown">
                                                        <span class="dropdown-toggle btn btn-sm btn-outline-primary " id="dropdownMenuButton01" data-bs-toggle="dropdown" aria-expanded="true" role="button">
                                                            <i class="ri-menu-3-line"></i>
                                                        </span>
                                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton01">
                                                            <a type="button" class="dropdown-item" onclick="disabledPayment({{ $pm['id'] }})"><i class="{{ $pm['disabled']==null ? 'fa fa-toggle-on' : 'fa fa-toggle-off' }} me-2"></i>{{ $pm['disabled']==null ? 'Disabled' : 'Activate' }}</a>
                                                            <a class="dropdown-item" href="{{url('backend/admin/master/payment-method/edit')}}/{{ $pm['id'] }}"><i class="ri-pencil-fill me-2"></i>Edit</a>
                                                            <a class="dropdown-item" href="javascript:void(0);" onclick="changeIcon({{ $pm['id'] }})"><i class="ri-gallery-upload-line me-2"></i>Change Icon</a>
                                                        </div>
                                                     </div>
                                                </div>
                                            </div>
                                            <div class="card-body p-2">
                                                <div class="d-flex d-flex justify-content-between " >
                                                    {{ __('Payment Name') }}:
                                                    <div class="ms-2 text-end">{{ $pm["name"] }}</div>
                                                </div>
                                                <div class="d-flex d-flex justify-content-between " >
                                                    {{ __('Type') }}:
                                                    <div class="ms-2 text-end">{{ $pm["payment_type"] == 'bank_transfer' ? "Bank Transfer" : "E-Wallet" }}</div>
                                                </div>
                                                <div class="d-flex d-flex justify-content-between">
                                                    {{ __('Status') }}:
                                                    <div class="ms-2 text-end">
                                                        @if ($pm["disabled"] == 1)
                                                            <span class="badge bg-warning mt-2 text-end">Disabled</span>
                                                        @else
                                                            <span class="badge bg-success mt-2 text-end">Active</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <hr class="mt-1 mb-2">
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="preview-modal" tabindex="-1" role="dialog" aria-labelledby="preview-modal-label" aria-hidden="true">
        <div class="modal-md modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="preview-modal-label">@lang('Preview')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.master.paymentmethod.changeicon') }}" method="POST" class="mt-2 needs-validation" id="input-form" enctype="multipart/form-data" onsubmit="doSubmit($('#btn-submit'))">
                    @csrf
                    @method('PUT')
                    <input type="number" name="id" id="pm-icon-id" required hidden>
                    <div class="modal-body">

                        @include('components.flash-message', ['flashName' => 'message'])
                        
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <div class="table-responsive text-center">
                                        <img id="enlarge-img" src="" class="img-fluid rounded" style="width: 120px; height: 120px;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <label for="pm-icon-file" class="form-label custom-file-input @error('image') is-invalid @enderror">@lang('Change Icon')</label>
                                    <input class="form-control" type="file" name="image" id="pm-icon-file" onchange="document.getElementById('enlarge-img').src = window.URL.createObjectURL(this.files[0])" accept="image/*" required>
                                    @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="btn-submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
           </div>
        </div>
    </div>
    <form action="{{ route('admin.master.paymentmethod.setactive') }}" method="POST" id="set-disabled-form" hidden >
        @csrf
        <input type="hidden" name="id" id="active-id" value="" required/>
    </form>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/utils.js') }}"></script>
    <script type="text/javascript">
        $(()=>{
            @error('image')
                changeIcon({{ old('id') }});
            @enderror
        });

        const changeIcon = (id) => {
            new bootstrap.Modal($('#preview-modal'), {
                show: true,
                keyboard: false,
                backdrop: 'static'
            }).show();

            $("#pm-icon-file").val(null);
            $('#pm-icon-id').val(id);
            $('#enlarge-img').attr('src', $(`#pm-icon-${id}`).attr('src'));
        }
        

        const disabledPayment = (id) => {
            Swal.fire({
                title: "@lang('page.are_you_sure')",
                html: "@lang('page.change_status_payment_method')",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#50b5ff",
                confirmButtonText: "@lang('page.ok')",
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#active-id').val(id);
                    $('#set-disabled-form').submit();
                }
            }).catch(swal.noop);
        }
    </script>
@endsection