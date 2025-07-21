@extends('layouts.admin.omg')

@section('title',  __('Manage Creator - Creator List'))

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
                       <li class="breadcrumb-item">@lang('Manage Creator')</li>
                       <li class="breadcrumb-item active" aria-current="page">@lang('Creator List')</li>
                    </ol>
                 </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                           <h5 class="card-title">@lang('Creator List')</h5>
                        </div>
                        <div class="card-header-toolbar d-flex align-items-center">
                            <p>&nbsp;</p>
                        </div>
                    </div>
                    <div class="card-body">
                        
                        @include('components.flash-message', ['flashName' => 'message'])

                        <div class="row">
                            <div class="col-md-12 ps-4 pe-4">
                                <div class="accordion card " id="accordionExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading1">
                                        <button class="accordion-button collapsed " type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
                                            Search & Filter
                                        </button>
                                        </h2>
                                        <div id="collapse1" class="accordion-collapse collapse" aria-labelledby="heading1" data-bs-parent="#accordionExample" style="">
                                            <div class="accordion-body ps-3 pe-3 pt-1 pb-1">
                                                <form class="mt-1 needs-validation" id="search-form" onsubmit="return false;" autocomplete="off">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-4 ps-3 pe-3">
                                                            <div class="form-group">
                                                                <label class="form-label" for="name">@lang('Creator Name')</label>
                                                                <input type="text" name="name" id="name" class="form-control " placeholder="@lang('Search by Name')">
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label" for="username">@lang('Username')</label>
                                                                <input type="text" name="username" id="username" class="form-control " placeholder="@lang('Search by Username')">
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label" for="email">@lang('Email Address')</label>
                                                                <input type="text" name="email" id="email" class="form-control " placeholder="@lang('Search by Email')">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 ps-3 pe-3">
                                                            <div class="form-group">
                                                                <label class="form-label" for="page_name">@lang('Page Name')</label>
                                                                <input type="text" name="page_name" id="page_name" class="form-control " placeholder="@lang('Search by Page Name')">
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label" for="page_url">@lang('Support Page')</label>
                                                                <input type="text" name="page_url" id="page_url" class="form-control " placeholder="@lang('Search by Support Page')">
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label" for="status">@lang('Status')</label>
                                                                <select name="status" id="status" class="form-select">
                                                                    <option selected="" disabled="">Select Status</option>
                                                                    <option value="0">Inactive</option>
                                                                    <option value="1">Active</option>
                                                                    <option value="2">Suspend</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 ps-3 pe-3">
                                                            <div class="form-group">
                                                                <div class="form-check form-switch">
                                                                    <label class="form-check-label me-2" for="sensitive_content">@lang('Creator With Sensitive Content') </label>
                                                                    <input type="checkbox" name="sensitive_content" class="form-check-input" value="1" id="sensitive_content">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label" for="address">@lang('Address')</label>
                                                                <textarea name="address" id="address" class="form-control " rows="2" style="line-height: 22px;" placeholder="@lang('Search by Address')"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr class="mt-2">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group row align-items-end text-end">
                                                                <div class="col-md-8"></div>
                                                                <div class="col-md-4 pe-3">
                                                                    <button type="reset" onclick="doSearch(true);" class="btn btn-sm btn-outline-danger me-2">@lang('Reset')</button>
                                                                    <button type="button" onclick="doSearch();" class="btn btn-sm btn-outline-warning">@lang('Apply Search')</button>
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
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive p-3">
                                    <table class="table pb-3 pt-3" id="dtListCreator">
                                        <thead class="">
                                            <tr>
                                                <th scope="col" class="text-center">No</th>
                                                <th scope="col" class="text-center">Creator</th>
                                                <th scope="col" class="text-center">Name</th>
                                                <th scope="col" class="text-center">Username</th>
                                                <th scope="col" class="text-center">Email</th>
                                                <th scope="col" class="text-center">Address</th>
                                                <th scope="col" class="text-center">Phone Number</th>
                                                <th scope="col" class="text-center">Page Name</th>
                                                <th scope="col" class="text-center">Summary</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                        </tbody>
                                    </table>
                                    <form action="{{ "#" }}" method="POST" id="delete-form" hidden>
                                        @csrf
                                        @method("DELETE")
                                        <input type="hidden" name="id" id="delete-id" value="" required/>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
    <form action="{{ route('admin.creator.list.suspend') }}" method="POST" id="set-suspend-form" hidden >
        @csrf
        @method("POST")
        <input type="hidden" name="id" id="setsuspend-id" required/>
    </form>
    <form action="{{ route('admin.creator.list.unsuspend') }}" method="POST" id="set-unsuspend-form" hidden >
        @csrf
        @method("POST")
        <input type="hidden" name="id" id="setunsuspend-id" required/>
    </form>
    <form action="{{ route('admin.creator.list.setpicked') }}" method="POST" id="set-setpicked-form" hidden >
        @csrf
        @method("POST")
        <input type="hidden" name="id" id="setpicked-id" required/>
    </form>
    <form action="{{ route('admin.creator.list.setfeatured') }}" method="POST" id="set-setfeatured-form" hidden >
        @csrf
        @method("POST")
        <input type="hidden" name="id" id="setfeatured-id" required/>
    </form>
@endsection

@section('scripts')
    <script src="{{ asset('template/vendor/datatable/DataTables-1.11.4/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/vendor/datatable/DataTables-1.11.4/js/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('template/vendor/datatable/ext/Responsive-2.2.9/js/dataTables.responsive.js') }}"></script>
    <script src="{{ asset('template/vendor/datatable/ext/Responsive-2.2.9/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('template/vendor/serialize-json/jquery.serializejson.min.js') }}"></script>
    <script src="{{ asset('assets/js/utils.js') }}"></script>
    <script type="text/javascript">

        let dtListCreatorIns;

        $(()=>{
            dtListCreator();
        });

        const dtListCreator = () => {
            dtListCreatorIns = $('#dtListCreator').DataTable({
                stateSave: true,
                processing: true,
                responsive: true,
                serverSide: true,
                destroy: true,
                searching: false,
                autoWidth: false,
                ajax: {
                    url: '{!! route("admin.creator.list.datatable") !!}',
                    type: 'GET',
                    data: (data) => {
                        data.customSearch = $('#search-form').serializeJSON();
                    }
                },
                columns: [
                    { data: 'DT_Number', name: 'DT_Number', width: '5%', className: 'text-center', visible: false, orderable: false, searchable: false },
                    { data: 'creator_card', name: 'creator_card', width: '20%', searchable: false, defaultContent: 'N/A' },
                    { data: 'name', name: 'name', width: '5%', visible: false, defaultContent: 'N/A' },
                    { data: 'username', name: 'username', width: '5%', visible: false, defaultContent: 'N/A' },
                    { data: 'email', name: 'email', width: '5%', visible: false, className: 'text-center', defaultContent: 'N/A' },
                    { data: 'address', name: 'address', width: '5%', visible: false, defaultContent: 'N/A' },
                    { data: 'phone_number', name: 'phone_number', width: '5%', visible: false, defaultContent: 'N/A' },
                    { data: 'page', name: 'page.name', width: '5%', visible: false, defaultContent: 'N/A' },
                    { data: 'summary', name: 'summary', width: '10%', className: 'text-left', defaultContent: 'N/A', orderable: false },
                ]
            });
        }

        const doSearch = (reset = false) => {
            // TODO: Check if all search column is empty
            setTimeout(() => {
                dtListCreatorIns.ajax.reload();
            }, reset ? 250 : 0);
        }
        
        const Suspend = (el) => {
            const id = $(el).attr("data-id");
            Swal.fire({
                title: "{{ __('Are you sure?') }}",
                html: "{!! __('You will set this user as <cite>\"Suspend?\"</cite>') !!}",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#50b5ff",
                confirmButtonText: "{{ __('OK') }}",
            }).then((result) => {
                if (result.isConfirmed) {
                    $(el).attr({"disabled": true}).html("Loading...");
                    $('#setsuspend-id').val(id);
                    $('#set-suspend-form').submit();
                }
            }).catch(swal.noop);
        }

        const Unsuspend = (el) => {
            const id = $(el).attr("data-id");
            Swal.fire({
                title: "{{ __('Are you sure?') }}",
                html: "{!! __('You will Unsuspend this user?') !!}",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#50b5ff",
                confirmButtonText: "{{ __('OK') }}",
            }).then((result) => {
                if (result.isConfirmed) {
                    $(el).attr({"disabled": true}).html("Loading...");
                    $('#setunsuspend-id').val(id);
                    $('#set-unsuspend-form').submit();
                }
            }).catch(swal.noop);
        }

        const Featured = (el) => {
            const id = $(el).attr("data-id");
            Swal.fire({
                title: "{{ __('Are you sure?') }}",
                html: "{!! __('You will edit Featured of this user?') !!}",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#50b5ff",
                confirmButtonText: "{{ __('OK') }}",
            }).then((result) => {
                if (result.isConfirmed) {
                    $(el).attr({"disabled": true}).html("Loading...");
                    $('#setfeatured-id').val(id);
                    $('#set-setfeatured-form').submit();
                }
            }).catch(swal.noop);
        }

        const Editorpick = (el) => {
            const id = $(el).attr("data-id");
            Swal.fire({
                title: "{{ __('Are you sure?') }}",
                html: "{!! __('You will edit Editor Pick of this user?') !!}",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#50b5ff",
                confirmButtonText: "{{ __('OK') }}",
            }).then((result) => {
                if (result.isConfirmed) {
                    $(el).attr({"disabled": true}).html("Loading...");
                    $('#setpicked-id').val(id);
                    $('#set-setpicked-form').submit();
                }
            }).catch(swal.noop);
        }
    </script>
@endsection