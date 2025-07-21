@extends('layouts.admin.omg')

@section('title',  __('Manage Creator - Reported Content'))

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
                       <li class="breadcrumb-item active" aria-current="page">@lang('page.report_content')</li>
                    </ol>
                 </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                           <h5 class="card-title">@lang('page.report_content')</h5>
                        </div>
                        <div class="card-header-toolbar d-flex align-items-center">
                            <p>&nbsp;</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="msg"></div>
                        @include('components.flash-message', ['flashName' => 'message'])
                        <div class="card">
                            <div class="card-body">
                                <ul class="nav tab-nav-pane nav-tabs  mb-4">
                                <li class="pb-0 mb-0 nav-item"><a data-bs-toggle="tab" data-bs-target="#Process" class="font-weight-bold text-uppercase ms-3 active" href="#Process">@lang('page.process')</a>
                                </li>
                                <li class="pb-0 mb-0 nav-item"><a data-bs-toggle="tab" data-bs-target="#Done" class="font-weight-bold text-uppercase ms-3" href="#Done">@lang('page.done')</a></li>
                                </ul>
                                <div class="tab-pane fade show active" id="Process" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-12 table-responsive">
                                            <table class="table table-striped pb-3 pt-3" id="table">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Link</th>
                                                        <th>Screenshot</th>
                                                        <th>Category</th>
                                                        <th>Description</th>
                                                        <th>Created At</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="Done" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-12 table-responsive">
                                            <table class="table table-striped pb-3 pt-3" id="tableDone" style="width: 100%">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Link</th>
                                                        <th>Screenshot</th>
                                                        <th>Category</th>
                                                        <th>Description</th>
                                                        <th>Created At</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-xl" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
               
               </button>
            </div>
            <div class="modal-body">
              <img src="" class="imagepreview" style="width: 100%;" >
            </div>
          </div>
        </div>
    </div>
    <form action="{{ route('admin.creator.reportedcontent.block') }}" method="POST" id="set-suspend-form" hidden >
        @csrf
        @method("POST")
        <input type="hidden" name="id" id="setsuspend-id" required/>
    </form>
    <form action="{{ route('admin.creator.reportedcontent.unblock') }}" method="POST" id="set-unsuspend-form" hidden >
        @csrf
        @method("POST")
        <input type="hidden" name="id" id="setunsuspend-id" required/>
    </form>
@endsection

@section('scripts')
<script src="{{ asset('template/vendor/datatable/DataTables-1.11.4/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('template/vendor/datatable/DataTables-1.11.4/js/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('template/vendor/datatable/ext/Responsive-2.2.9/js/dataTables.responsive.js') }}"></script>
<script src="{{ asset('template/vendor/datatable/ext/Responsive-2.2.9/js/responsive.bootstrap5.min.js') }}"></script>
    <script type="text/javascript">
        let table;
        let done;
        $(()=>{
            dtReport();
            dtReportDone();
        });

const dtReport = () => {
    table = $('#table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.creator.reportedcontent.getlistcontentprocess') }}",
            data: function(d){
                // console.log(d);
            }
        },
        columns: [
            {data: 'DT_Number', name: 'DT_Number', orderable: false},
            {data: 'name', name: 'name', orderable: false},
            {data: 'email', name: 'email', orderable: false},
            {data: 'link', name: 'link', orderable: false},
            {data: 'screenshot', name: 'screenshot', orderable: false},
            {data: 'category', name: 'category', orderable: false},
            {data: 'description', name: 'description', orderable: false},
            {data: 'created_at', name: 'created_at', orderable: false},
            {data: 'action', name: 'action', orderable: false},
        ],
        destroy: true
    });
}

const dtReportDone = () => {
    done = $('#tableDone').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.creator.reportedcontent.getlistcontentdone') }}",
            data: function(d){
                // console.log(d);
            }
        },
        columns: [
            {data: 'DT_Number', name: 'DT_Number', orderable: false},
            {data: 'name', name: 'name', orderable: false},
            {data: 'email', name: 'email', orderable: false},
            {data: 'link', name: 'link', orderable: false},
            {data: 'screenshot', name: 'screenshot', orderable: false},
            {data: 'category', name: 'category', orderable: false},
            {data: 'description', name: 'description', orderable: false},
            {data: 'created_at', name: 'created_at', orderable: false},
        ],
        destroy: true
    });
}

const preview = (el) => {
    const src = $(el).attr("data-src");
    $('.imagepreview').attr('src', src);
    $('#imagemodal').modal('show'); 
}

const setDone = (el) => {
    const id = $(el).attr("data-id");
    Swal.fire({
        title: "{{ __('Are you sure?') }}",
        html: "{!! __('You will set this report as <cite>\"Done?\"</cite>') !!}",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#50b5ff",
        confirmButtonText: "{{ __('OK') }}",
    }).then((result) => {
        if (result.isConfirmed) {
            $(el).attr({"disabled": true}).html("Loading...");
            setStatus(id);
            // $('#setdone-id').val(id);
            // $('#setdone-status').val(1);
            // $('#set-done-form').submit();
        }
    }).catch(swal.noop);
}

const setStatus = async (id) => {
    let authToken = document.head.querySelector('meta[name="auth"]');
    // const id = $(el).attr("data-id");
    var url = "{{url('api/report/setstatus')}}";
    const params = {'id': id, 'status': 1};
    await axios.put(url, params)
        .then(function (response) {
            const { data } = response;
            const { message, status } = data;
            // $('#edit_id').val(data.data.id);
            // $('#edit_name').val(data.data.name);
            // $('#edit_price').val(data.data.price.replace(/\D/g, ""));
            // $('#edit_description').val(data.data.description);
            // $('#enlarge-img').attr('src', $(`#pm-icon-${id}`).attr('src'));
            // $('#editModal').modal('show');
            console.log(data);
            table.draw();
            done.draw();
            $("#msg").html('<div class="alert alert-left alert-success alert-dismissible fade show mb-3" role="alert"><span><i class="fas fa-check"></i></span><span> The data status has change successfully. </span><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
        })
        .catch(function (error) {
            console.log(error);
        });
}

const Block = (el) => {
    const id = $(el).attr("data-id");
    Swal.fire({
        title: "{{ __('Are you sure?') }}",
        html: "{!! __('You will set this content as <cite>\"Blocked?\"</cite>') !!}",
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

const Unblock = (el) => {
    const id = $(el).attr("data-id");
    Swal.fire({
        title: "{{ __('Are you sure?') }}",
        html: "{!! __('You will Unblock this content?') !!}",
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
    </script>
@endsection