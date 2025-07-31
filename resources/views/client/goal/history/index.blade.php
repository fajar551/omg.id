@extends('layouts.template-body')

@section('title')
    <title>@lang('page.goal_history')</title>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('template/vendor/datatable/DataTables-1.11.4/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/vendor/datatable/ext/Responsive-2.2.9/css/responsive.bootstrap5.min.css') }}">
@endsection

@section('content')
<div class="container px-5">
    <div class="row">
        <div class="col-12">
            @include('components.breadcrumb', [
                'title' => __('page.goal_history'), 
                'pages' => [
                    '#' => __('page.menu_goal'),
                ]
            ])
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            @include('components.flash-message', ['flashName' => 'message'])
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 d-none  d-lg-block">
            @include('components.nav-goal')
        </div>
        <div class="col d-lg-none  ">
            @include('components.nav-goal-mobile')
        </div>
    </div>

    <div class="row" style="margin-bottom: 200px;">
        <div class="col-md-12">
            <div class="card shadow rounded-small card-dark">
                <div class="card-body">
                    <div class="table-responsive p-3">
                        <table class="table table-striped pb-3 pt-3" id="dtGoalHistory">
                            <thead class="">
                                <tr>
                                    {{-- <th scope="col" class="text-center">No</th> --}}
                                    <th scope="col" class="text-center">@lang('form.lbl_title')</th>
                                    <th scope="col" class="text-center">@lang('form.lbl_description')</th>
                                    <th scope="col" class="text-center">@lang('form.lbl_target_progress')</th>
                                    <th scope="col" class="text-center">@lang('form.lbl_status')</th>
                                    <th scope="col" class="text-center">@lang('form.lbl_milestone')</th>
                                    <th scope="col" class="text-center">@lang('form.lbl_actions')</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                        <form action="{{ route('goal.history.delete') }}" method="POST" id="delete-form" hidden>
                            @csrf
                            @method("DELETE")
                            <input type="hidden" name="id" id="delete-id" value="" required />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detail-modal"  role="dialog" aria-labelledby="detail-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detail-modal-label">@lang('page.view_goal')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal-body">
                <div id="loading-container"></div>
                <div id="div-result"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('form.btn_close')</button>
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
    <script src="{{ asset('assets/js/alert.js') }}"></script>
    <script type="text/javascript">
        /**
        * Goal history index script
        * Version: 1.0
        */
        (function($) {
            let dtGoalHistoryIns;
            let detailResult = {};

            $('#dtGoalHistory').DataTable({
                stateSave: true,
                processing: true,
                responsive: true,
                serverSide: true,
                destroy: true,
                ajax: {
                    url: '{!! route('goal.history.dtgoal')!!}',
                    type: 'GET',
                    // For custom filtered
                    // data: (data) => {
                    //     data.dataFiltered = $('#form-filters').serializeJSON();
                    // }
                },
                columns: [
                    // { data: 'DT_Number', name: 'DT_Number', width: '5%', orderable: false, searchable: false },
                    {
                        data: 'title',
                        name: 'title',
                        width: '15%',
                        defaultContent: 'N/A'
                    },
                    {
                        data: 'description',
                        name: 'description',
                        width: '20%',
                        defaultContent: 'N/A'
                    },
                    {
                        data: 'formated_target',
                        name: 'formated_target',
                        width: '5%',
                        className: 'text-center',
                        defaultContent: 'N/A'
                    },
                    {
                        data: 'formated_status',
                        name: 'formated_status',
                        width: '5%',
                        className: 'text-center',
                        defaultContent: 'N/A'
                    },
                    {
                        data: 'milestone',
                        name: 'milestone',
                        width: '15%',
                        defaultContent: 'N/A'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        width: '5%',
                        className: 'text-center',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        
            const renderDetail = (html) => {
                $('#div-result').html(html);
            }

            $(document).on('click', '.detail', async function() {
                $('#div-result').html('')
                loading($('#loading-container'), true);
        
                const id = $(this).attr("data-id");
                const myModal = new bootstrap.Modal($('#detail-modal'), {
                    show: true,
                    keyboard: false,
                    backdrop: 'static'
                }).show();
        
                if (detailResult[id] !== undefined) {
                    const tempData = detailResult[id];
        
                    loading($('#loading-container'), false);
                    renderDetail(tempData.data.goal_template);
        
                    return true;
                }
        
                await axios.get(`/api/goal/${id}/detail`)
                    .then(function(response) {
                        const { data } = response;
        
                        if (data) {
                            loading($('#loading-container'), false);
                            renderDetail(data.data.goal_template);
                            detailResult[id] = data;
                        }
                    }).catch(function(error) {
                        loading($('#loading-container'), false);
                        renderDetail("@lang('page.error_occurred')");
        
                        console.log(error);
                    });
            });

            $(document).on('click', '.delete', function() {
                const id = $(this).attr("data-id");
                ToastDelete.fire({
                    title: "@lang('page.are_you_sure')",
                    html: "@lang('page.sure_delete')",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#delete-id').val(id);
                        $('#delete-form').submit();
                    }
                }).catch(swal.noop);
            });
        })(jQuery);
    </script>
@endsection