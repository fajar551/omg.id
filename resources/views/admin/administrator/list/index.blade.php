@extends('layouts.admin.omg')

@section('title',  __('Manage Admin - Administrator List'))

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
                       <li class="breadcrumb-item active" aria-current="page">@lang('Administrator List')</li>
                    </ol>
                 </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                           <h5 class="card-title">@lang('Administrator List')</h5>
                        </div>
                        <div class="card-header-toolbar d-flex align-items-center">
                            <a href="{{ route('admin.administrator.list.create') }}" type="button" class="btn btn-outline-primary mb-1"><i class="las la-plus-circle"></i> @lang('Create New Admin')</a>
                        </div>
                    </div>
                    <div class="card-body">
                        
                        @include('components.flash-message', ['flashName' => 'message'])
                        
                        <div class="table-responsive p-3">
                            <table class="table pb-3 pt-3" id="dtAdmin">
                                <thead class="">
                                    <tr>
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col" class="text-center">Name</th>
                                        <th scope="col" class="text-center">Username / Email</th>
                                        <th scope="col" class="text-center">Username</th>
                                        <th scope="col" class="text-center">Email</th>
                                        <th scope="col" class="text-center">Summary</th>
                                        <th scope="col" class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                
                                </tbody>
                            </table>
                            <form action="{{ route('admin.administrator.list.delete') }}" method="POST" id="delete-form" hidden>
                                @csrf
                                @method("DELETE")
                                <input type="number" name="userid" id="delete-id" value="" required/>
                            </form>
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

        let dtAdmin;

        $(()=>{
            dtListAdmin();
        });

        const dtListAdmin = () => {
            dtAdmin = $('#dtAdmin').DataTable({
                stateSave: true,
                processing: true,
                responsive: true,
                serverSide: true,
                destroy: true,
                ajax: {
                    url: '{!! route("admin.administrator.list.dtindex") !!}',
                    type: 'GET',
                    // For custom filtered
                    // data: (data) => {
                    //     data.dataFiltered = $('#form-filters').serializeJSON();
                    // }
                },
                columns: [
                    { data: 'DT_Number', name: 'DT_Number', width: '5%', className: 'text-center', visible: false, orderable: false, searchable: false },
                    { data: 'name', name: 'name', width: '5%', defaultContent: 'N/A' },
                    { data: 'username_email', username_email: 'name', width: '10%', defaultContent: 'N/A' },
                    { data: 'username', name: 'username', width: '5%', visible: false, defaultContent: 'N/A' },
                    { data: 'email', name: 'email', width: '5%', visible: false, className: 'text-center', defaultContent: 'N/A' },
                    { data: 'summary', name: 'summary', width: '10%', className: 'text-left', defaultContent: 'N/A', orderable: false },
                    { data: 'actions', name: 'actions', width: '5%', className: 'text-center', orderable: false, searchable: false }
                ]
            });
        }

        const deleteConfirm = (el) => {
            const id = $(el).attr("data-id");

            Swal.fire({
                title: "@lang('page.are_you_sure')",
                html: "@lang('page.sure_delete')",
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