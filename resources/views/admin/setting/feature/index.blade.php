@extends('layouts.admin.omg')

@section('title',  __('Data Master - Feature'))

@section('styles')
    <link rel="stylesheet" href="{{ asset('template/vendor/datatable/DataTables-1.11.4/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/vendor/datatable/ext/Responsive-2.2.9/css/responsive.bootstrap5.min.css') }}">
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
                       <li class="breadcrumb-item">@lang('Setting')</li>
                       <li class="breadcrumb-item active" aria-current="page">@lang('Feature')</li>
                    </ol>
                 </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                           <h5 class="card-title">@lang('Feature')</h5>
                        </div>
                        <div class="card-header-toolbar d-flex align-items-center">
                            {{-- <a href="#" type="button" class="btn btn-outline-primary mb-1" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="las la-plus-circle"></i> @lang('page.create')</a> --}}
                        </div>
                    </div>
                    <div class="card-body">
                        
                        @include('components.flash-message', ['flashName' => 'message'])
                        <div class="card m-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-10">
                                        <table class="table pb-3 pt-3" id="table">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Title</th>
                                                    <th>Feature</th>
                                                    <th>Description</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#" type="button" class="btn btn-outline-primary mb-1" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="las la-plus-circle"></i> @lang('page.create')</a>
                                    </div>
                                </div>
                            </div>
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

              <form action="{{ route('admin.setting.feature.store') }}" method="POST" class="mt-2 needs-validation" id="input-form" enctype="multipart/form-data" onsubmit="doSubmit($('#btn-submit'))">
              <div class="modal-body">
                @include('components.flash-message', ['flashName' => 'message'])
                    @csrf
                    <div class="row">
                        <div class="col-md-9">
                            <div class="form-group">
                                <label class="form-label" for="title">{{ __('Title') }} *</label>
                                <input name="title" type="text" id="title" class="form-control mb-0 @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="@lang('Title')" required>
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <label class="form-label" for="feature">{{ __('Feature') }} *</label>
                                <input name="feature" type="text" id="feature" class="form-control mb-0 @error('feature') is-invalid @enderror" value="{{ old('feature') }}" placeholder="@lang('Feature')" required>
                                @error('feature')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <label class="form-label" for="description">{{ __('Description') }}</label>
                                <input name="description" type="text" id="description" class="form-control mb-0 @error('description') is-invalid @enderror" value="{{ old('description') }}" placeholder="@lang('Describe about this feature')">
                                @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <label class="form-label" for="item_feature">{{ __('Status') }}</label>
                                <select name="status" class="form-select" id="status">
                                    <option value="1">Active</option>
                                    <option value="2">Inactive</option>
                                </select>
                                @error('status')
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

              <form action="{{ route('admin.setting.feature.edit') }}" method="POST" class="mt-2 needs-validation" id="input-form" enctype="multipart/form-data" onsubmit="doSubmit($('#btn-submit'))">
              <div class="modal-body">
                @include('components.flash-message', ['flashName' => 'message'])
                    @csrf
                    <div class="row">
                        <div class="col-md-9">
                            <div class="form-group">
                                <label class="form-label" for="item_title">{{ __('Title') }} *</label>
                                <input type="hidden" name="id" id="edit_id">
                                <input name="title" type="text" id="edit_title" class="form-control mb-0 @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="@lang('Title')" required>
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <label class="form-label" for="item_feature">{{ __('Feature') }} *</label>
                                <input name="feature" type="text" id="edit_feature" class="form-control mb-0 @error('feature') is-invalid @enderror" value="{{ old('feature') }}" placeholder="@lang('Feature')" required>
                                @error('feature')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <label class="form-label" for="item_feature">{{ __('Description') }}</label>
                                <input name="description" type="text" id="edit_description" class="form-control mb-0 @error('description') is-invalid @enderror" value="{{ old('description') }}" placeholder="@lang('Describe your feature')">
                                @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <label class="form-label" for="item_feature">{{ __('Status') }}</label>
                                <select name="status" class="form-select" id="edit_status">
                                    <option value="1">Active</option>
                                    <option value="2">Inactive</option>
                                </select>
                                @error('status')
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
    <form action="{{ route('admin.setting.feature.delete') }}" method="post" id="delete-form" hidden>
        @csrf
        @method("post")
        <input type="hidden" name="id" id="delete-id" value="" required/>
    </form>
@endsection

@section('scripts')
<script src="{{ asset('template/vendor/datatable/DataTables-1.11.4/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('template/vendor/datatable/DataTables-1.11.4/js/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('template/vendor/datatable/ext/Responsive-2.2.9/js/dataTables.responsive.js') }}"></script>
<script src="{{ asset('template/vendor/datatable/ext/Responsive-2.2.9/js/responsive.bootstrap5.min.js') }}"></script>
    <script type="text/javascript">
        $(()=>{
            var table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.setting.feature.list') }}",
                    data: function(d){
                        console.log(d);
                    }
                },
                columns: [
                    {data: 'DT_Number', name: 'DT_Number', orderable: false},
                    {data: 'title', name: 'title', orderable: false},
                    {data: 'feature', name: 'feature', orderable: false},
                    {data: 'description', name: 'description', orderable: false},
                    {data: 'status', name: 'status', orderable: false},
                    {data: 'actions', name: 'actions', orderable: false}
                ],
                destroy: true
            });
        });
        const edit = async (el) => {
            let authToken = document.head.querySelector('meta[name="auth"]');
            const id = $(el).attr("data-id");
            var url = "{{url('api/feature/')}}/"+id+"/detail";
            await axios.get(url)
                .then(function (response) {
                    const { data } = response;
                    const { message, status } = data;
                    $('#edit_id').val(data.data.id);
                    $('#edit_title').val(data.data.title);
                    $('#edit_feature').val(data.data.feature);
                    $('#edit_description').val(data.data.description);
                    const $select = document.querySelector('#edit_status');
                    if (data.data.active_at == null) {
                        $select.value = 2;
                    } else {
                        $select.value = 1;
                    }
                    
                    $('#editModal').modal('show');
                    // console.log(data);
                })
                .catch(function (error) {
                    console.log(error);
                });
        }

        const deleteConfirm = (el) => {
            const id = $(el).attr("data-id");
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