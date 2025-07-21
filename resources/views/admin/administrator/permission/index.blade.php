@extends('layouts.admin.omg')

@section('title',  __('Manage Admin - Permission'))

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
                       <li class="breadcrumb-item">@lang('Manage Admin')</li>
                       <li class="breadcrumb-item active" aria-current="page">@lang('Permission')</li>
                    </ol>
                 </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                           <h5 class="card-title">@lang('Permission')</h5>
                        </div>
                        <div class="card-header-toolbar d-flex align-items-center">
                            <a href="{{ route('admin.administrator.permission.create') }}" class="btn btn-outline-primary mb-1"><i class="las la-plus-circle"></i> @lang('Create New Permission')</a>
                        </div>
                    </div>
                    <div class="card-body">
                        
                        @include('components.flash-message', ['flashName' => 'message'])
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="table-responsive p-3">
                                    <table class="table pb-3 pt-3" id="dtPermission">
                                        <thead class="">
                                            <tr>
                                                <th scope="col" class="text-center">No</th>
                                                <th scope="col" class="text-center">Name</th>
                                                <th scope="col" class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                        </tbody>
                                    </table>
                                    <form action="{{ route('admin.administrator.permission.delete') }}" method="POST" id="delete-form" hidden>
                                        @csrf
                                        @method("DELETE")
                                        <input type="number" name="id" id="delete-id" value="" required/>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('template/vendor/datatable/DataTables-1.11.4/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/vendor/datatable/DataTables-1.11.4/js/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('template/vendor/datatable/ext/Responsive-2.2.9/js/dataTables.responsive.js') }}"></script>
    <script src="{{ asset('template/vendor/datatable/ext/Responsive-2.2.9/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/js/utils.js') }}"></script>
    <script type="text/javascript">

        let dtPermission;

        $(()=>{
            dtListPermission();
        });

        const dtListPermission = () => {
            dtPermission = $('#dtPermission').DataTable({
                stateSave: true,
                processing: true,
                responsive: true,
                serverSide: true,
                destroy: true,
                ajax: {
                    url: '{!! route("admin.administrator.permission.dtindex") !!}',
                    type: 'GET',
                },
                columns: [
                    { data: 'DT_Number', name: 'DT_Number', width: '5%', className: 'text-center', visible: false, orderable: false, searchable: false },
                    { data: 'name', name: 'name', width: '10%', defaultContent: 'N/A' },
                    { data: 'actions', name: 'actions', width: '5%', className: 'text-center', orderable: false, searchable: false }
                ]
            });
        }

        const deleteConfirm = (el) => {
            const id = $(el).attr("data-id");

            Swal.fire({
                title: "@lang('page.are_you_sure')",
                html: "@lang('if you delete this permission, the users that assigned by this permission won\'t be able to access menus or can\'t do actions that related to this permissions.')",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#50b5ff",
                confirmButtonText: "@lang('form.btn_ok')",
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#delete-id').val(id);
                    $('#delete-form').submit();
                }
            }).catch(swal.noop);
        }
    </script>
@endsection