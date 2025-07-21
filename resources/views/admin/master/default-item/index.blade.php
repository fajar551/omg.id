@extends('layouts.admin.omg')

@section('title',  __('Data Master - Default Item'))

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
                       <li class="breadcrumb-item active" aria-current="page">@lang('Default Item')</li>
                    </ol>
                 </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                           <h5 class="card-title">@lang('Default Item')</h5>
                        </div>
                        <div class="card-header-toolbar d-flex align-items-center">
                            <a href="#" type="button" class="btn btn-outline-primary mb-1" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="las la-plus-circle"></i> @lang('page.create')</a>
                        </div>
                    </div>
                    <div class="card-body">
                        
                        @include('components.flash-message', ['flashName' => 'message'])
                        <div class="row">
                            {{-- <div class="col-sm-12"> --}}
                                @foreach ($data as $item)
                                    <div class="col-sm-4 col-md-4">
                                        <div class="card card-dark-80">
                                            <div class="card-header card-dark-80 d-flex justify-content-between p-2">
                                                <div class="header-title">
                                                <h5 class="card-title">{{ $item["name"] }}</h5>
                                                </div>
                                                <div class="card-header-toolbar d-flex align-items-center">
                                                    <div class="dropdown">
                                                        <span class="dropdown-toggle btn btn-sm btn-outline-primary " id="dropdownMenuButton01" data-bs-toggle="dropdown" aria-expanded="true" role="button">
                                                            <i class="ri-menu-3-line"></i>
                                                        </span>
                                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton01">
                                                            <a class="dropdown-item" href="{{url('backend/admin/master/default-item/update')}}/{{ $item['id'] }}"><i class="ri-pencil-fill me-2"></i>Edit</a>
                                                            <a class="dropdown-item" href="#" data-id="{{ $item['id'] }}" onclick="deleteConfirm({{ $item['id'] }})"><i class="ri-delete-bin-fill me-2"></i>Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body p-2">
                                                <div class="iq-birthday-block">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div class="d-flex align-items-center">
                                                            <a href="javascript:void(0);" onclick="changeIcon({{ $item['id'] }})">
                                                                <img src="{{ $item['icon'] ?? asset('assets/img/image.png') }}" alt="profile-img" id="pm-icon-{{ $item['id'] }}" class="img-fluid rounded" style="width: 90px; height: 90px;">
                                                            </a>
                                                        </div>
                                                        <div class=" ms-0 ms-md-2 mt-md-0 mt-2" style="min-width: 70%">
                                                            <div class="d-flex d-flex justify-content-between " >
                                                                <div class="col-md-6">
                                                                    {{ __('Name') }}:
                                                                </div>
                                                                <div class="col-md-6 d-flex justify-content-end">
                                                                    <small class="ms-2 text-end">{!! $item["name"] !!}</small>
                                                                </div>
                                                            </div>
                                                            <hr class="mt-1 mb-2">
                                                            <div class="d-flex d-flex justify-content-between">
                                                                <div class="col-md-6">
                                                                    {{ __('Price') }}:
                                                                </div>
                                                                <div class="col-md-6 d-flex justify-content-end">
                                                                    <small class="ms-2 text-end">{!! $item["price"] ?? __('page.na') !!}</small>
                                                                </div>
                                                            </div>
                                                            <hr class="mt-1 mb-2">
                                                            <div class="d-flex d-flex justify-content-between">
                                                                <div class="col-md-6">
                                                                    {{ __('Description') }}:
                                                                </div>
                                                                <div class="col-md-6 d-flex justify-content-end">
                                                                    <small class="ms-2 text-end">{!! $item["description"] ?? __('page.na') !!}</small>
                                                                </div>                                                                
                                                            </div>
                                                            <hr class="mt-1 mb-2">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            {{-- </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
           <div class="modal-content">
              <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">@lang('page.create') @lang('page.item')</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                 
                 </button>
              </div>

              <form action="{{ route('admin.master.defaultitem.create') }}" method="POST" class="mt-2 needs-validation" id="input-form" enctype="multipart/form-data">
              <div class="modal-body">
                @include('components.flash-message', ['flashName' => 'message'])
                    @csrf
                    <div class="row">
                        <div class="col-md-9">
                            <div class="form-group">
                                <label class="form-label" for="item_name">{{ __('Name') }} *</label>
                                <input name="name" type="text" id="name" class="form-control mb-0 @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="@lang('Name')" required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <label class="form-label" for="item_price">{{ __('Price') }} *</label>
                                <input name="price" type="number" id="price" min="1000" max="500000" step="1000" class="form-control mb-0 @error('price') is-invalid @enderror" value="{{ old('price') }}" placeholder="@lang('Price')" required>
                                @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <label class="form-label" for="item_description">{{ __('Description') }} </label>
                                <input name="description" type="text" id="description" class="form-control mb-0 @error('description') is-invalid @enderror" value="{{ old('description') }}" placeholder="@lang('Description')">
                                @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="table-responsive">
                                    <img id="enlarge-img-create" src="{{ asset('assets/img/image.png') }}" class="img-fluid rounded" style="width: 120px; height: 120px;">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <label class="form-label custom-file-input @error('icon') is-invalid @enderror" for="item_icon">{{ __('Icon') }} *</label>
                                <input name="icon" type="file" id="icon" class="form-control mb-0" onchange="document.getElementById('enlarge-img-create').src = window.URL.createObjectURL(this.files[0])" accept="image/*">
                                @error('icon')
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
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
           <div class="modal-content">
              <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">@lang('page.edit') @lang('page.item')</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                 
                 </button>
              </div>

              <form action="{{ route('admin.master.defaultitem.edit') }}" method="POST" class="mt-2 needs-validation" id="input-form" enctype="multipart/form-data" onsubmit="doSubmit($('#btn-submit'))">
              <div class="modal-body">
                @include('components.flash-message', ['flashName' => 'message'])
                    @csrf
                    <div class="row">
                        <div class="col-md-9">
                            <div class="form-group">
                                <label class="form-label" for="item_name">{{ __('Name') }} *</label>
                                <input type="hidden" name="id" id="edit_id">
                                <input name="name" type="text" id="edit_name" class="form-control mb-0 @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="@lang('Name')" required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <label class="form-label" for="item_price">{{ __('Price') }} *</label>
                                <input name="price" type="text" id="edit_price" class="form-control mb-0 @error('price') is-invalid @enderror" value="{{ old('price') }}" placeholder="@lang('Price')" required>
                                @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <label class="form-label" for="item_description">{{ __('Description') }} </label>
                                <input name="description" type="text" id="edit_description" class="form-control mb-0 @error('description') is-invalid @enderror" value="{{ old('description') }}" placeholder="@lang('Description')">
                                @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="table-responsive">
                                    <img id="enlarge-img" src="" class="img-fluid rounded" style="width: 120px; height: 120px;">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <label class="form-label custom-file-input @error('icon') is-invalid @enderror" for="item_icon">{{ __('Icon') }} *</label>
                                <input name="icon" type="file" id="edit_icon" class="form-control mb-0" onchange="document.getElementById('enlarge-img').src = window.URL.createObjectURL(this.files[0])" accept="image/*">
                                @error('icon')
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
    <div class="modal fade" id="preview-modal" tabindex="-1" role="dialog" aria-labelledby="preview-modal-label" aria-hidden="true">
        <div class="modal-md modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="preview-modal-label">@lang('Preview')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.master.defaultitem.changeicon') }}" method="POST" class="mt-2 needs-validation" id="input-form" enctype="multipart/form-data" onsubmit="doSubmit($('#btn-submit'))">
                    @csrf
                    @method('POST')
                    <input type="number" name="id" id="pm-icon-id" required hidden>
                    <div class="modal-body">

                        @include('components.flash-message', ['flashName' => 'message'])
                        
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <div class="table-responsive text-center">
                                        <img id="enlarge-img-prev" src="" class="img-fluid rounded" style="width: 120px; height: 120px;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <label for="pm-icon-file" class="form-label custom-file-input @error('icon') is-invalid @enderror">@lang('Change Icon')</label>
                                    <input class="form-control" type="file" name="icon" id="pm-icon-file" onchange="document.getElementById('enlarge-img-prev').src = window.URL.createObjectURL(this.files[0])" accept="image/*" required>
                                    @error('icon')
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
    <form action="{{ route('admin.master.defaultitem.delete') }}" method="post" id="delete-form" hidden>
        @csrf
        @method("post")
        <input type="hidden" name="id" id="delete-id" value="" required/>
    </form>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/utils.js') }}"></script>
    <script type="text/javascript">
        $(()=>{

            @error('icon')
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
            $('#enlarge-img-prev').attr('src', $(`#pm-icon-${id}`).attr('src'));
        }
        const edit = async (id) => {
            let authToken = document.head.querySelector('meta[name="auth"]');
            // const id = $(el).attr("data-id");
            var url = "{{url('api/item/')}}/"+id+"/detail";
            await axios.get(url)
                .then(function (response) {
                    const { data } = response;
                    const { message, status } = data;
                    $('#edit_id').val(data.data.id);
                    $('#edit_name').val(data.data.name);
                    $('#edit_price').val(data.data.price.replace(/\D/g, ""));
                    $('#edit_description').val(data.data.description);
                    $('#enlarge-img').attr('src', $(`#pm-icon-${id}`).attr('src'));
                    $('#editModal').modal('show');
                    // console.log(data);
                })
                .catch(function (error) {
                    console.log(error);
                });
        }

        const deleteConfirm = (id) => {
            Swal.fire({
                title: "{{ __('Are you sure?') }}",
                html: "{!! __('You will permanently <cite>\"Delete\"</cite> this data.') !!}",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#50b5ff",
                confirmButtonText: "{{ __('OK') }}",
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#delete-id').val(id);
                    $('#delete-form').submit();
                }
            }).catch(swal.noop);
        }
    </script>
@endsection