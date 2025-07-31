@extends('layouts.admin.omg')

@section('title')
    @lang('page.transaction_disbursement')
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('template/vendor/datatable/DataTables-1.11.4/css/dataTables.bootstrap5.min.css') }}">
<link rel="stylesheet" href="{{ asset('template/vendor/datatable/ext/Responsive-2.2.9/css/responsive.bootstrap5.min.css') }}">
{{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" /> --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.2.0/dist/select2-bootstrap-5-theme.min.css" />
<link rel="stylesheet" href="{{ asset('template/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}">

<style>
    .select2-hidden-accessible{
        background-color: aqua;
    }
</style>
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
                       <li class="breadcrumb-item">@lang('page.transaction')</li>
                       <li class="breadcrumb-item active" aria-current="page">@lang('page.transaction_disbursement')</li>
                    </ol>
                 </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                           <h5 class="card-title">@lang('page.transaction_disbursement')</h5>
                        </div>
                        <div class="card-header-toolbar d-flex align-items-center">
                            {{-- <a href="#" type="button" class="btn btn-outline-primary mb-1" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="las la-plus-circle"></i> @lang('page.create')</a> --}}
                        </div>
                    </div>
                    <div class="card-body">
                        
                        @include('components.flash-message', ['flashName' => 'message'])
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6 col-lg-4">
                                        <div class="card card-dark-80">
                                            <div class="card-body">
                                                <div id="total_payout">
                                                    <h3></h3>
                                                </div>
                                                <div>@lang('page.transaction_total_disbursement')</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-lg-4">
                                        <div class="card card-dark-80">
                                            <div class="card-body">
                                                <div id="payoutamount">
                                                    <h3></h3>
                                                </div>
                                                <div>@lang('page.transaction_total_disbursement_amount')</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="accordion card " id="accordionExample">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="heading1">
                                                <button class="accordion-button collapsed " type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
                                                    @lang('page.search_export')
                                                </button>
                                                </h2>
                                                <div id="collapse1" class="accordion-collapse collapse" aria-labelledby="heading1" data-bs-parent="#accordionExample" style="">
                                                    <div class="accordion-body ps-3 pe-3 pt-1 pb-1">
                                                        <form class="mt-1 needs-validation" id="search-form" autocomplete="off">
                                                            @csrf
                                                            <div class="row">
                                                                <div class="col-md-8 ps-3 pe-3">
                                                                    <label class="form-label" for="start">@lang('page.date_range')</label>
                                                                    <div class="input-group input-daterange" id="filter-date">
                                                                        <input type="text" class="form-control @error('start_at') is-invalid @enderror" name="start_at" id="start_at" placeholder="From ({{ $jsDateFormat }})" value="{{ old('start_at') }}" autocomplete="off">
                                                                        @error('start_at')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                        @enderror
                                                                        &nbsp;
                                                                        <input type="text" class="form-control @error('end_at') is-invalid @enderror" name="end_at" id="end_at" placeholder="To ({{ $jsDateFormat }})" value="{{ old('end_at') }}" autocomplete="off">
                                                                        @error('end_at')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 ps-3 pe-3">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="type">@lang('page.transaction_disbursement_type')</label>
                                                                        <select type="text" name="type" id="type" class="form-select " placeholder="@lang('Select Type')">
                                                                            <option value="0">-</option>
                                                                            <option value="1">E-Wallet</option>
                                                                            <option value="2">Bank</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 ps-3 pe-3">
                                                                    <label class="form-label" for="creatorname">@lang('page.creator_name')</label>
                                                                    <div class="form-group">
                                                                        <select class="form-select select2-single" id="creatorname" name="creator_name"></select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <hr class="mt-2">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group row align-items-end text-end">
                                                                        <div class="col-md-8"></div>
                                                                        <div class="col-md-4 pe-3">
                                                                            <button type="submit" class="btn btn-sm btn-outline-primary"><i class="las la-search"></i> @lang('page.search')</button>
                                                                            <button type="button" onclick="exportexcel();" class="btn btn-sm btn-outline-success me-2"><i class="las la-file-excel"></i> @lang('Export')</button>
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
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 table-responsive">
                                        <table class="table pb-3 pt-3" id="table">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Creator Name</th>
                                                    <th>Date</th>
                                                    <th>Amount</th>
                                                    <th>Fee</th>
                                                    <th>Status</th>
                                                    <th>Detail</th>
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
    <form action="{{ route('admin.transaction.disbursement.exportexcel') }}" method="get" id="export_excel" hidden>
        @csrf
        @method("get")
        <input type="hidden" name="start_at" id="ex_start_at">
        <input type="hidden" name="end_at" id="ex_end_at">
        <input type="hidden" name="type" id="ex_type">
        <input type="hidden" name="creator_name" id="ex_creator_name">
    </form>
@endsection
@section('scripts')
<script src="{{ asset('template/vendor/datatable/DataTables-1.11.4/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('template/vendor/datatable/DataTables-1.11.4/js/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('template/vendor/datatable/ext/Responsive-2.2.9/js/dataTables.responsive.js') }}"></script>
<script src="{{ asset('template/vendor/datatable/ext/Responsive-2.2.9/js/responsive.bootstrap5.min.js') }}"></script>
<script src="{{ asset('template/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assets/js/utils.js') }}"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript">
        let table;
        $(()=>{
            totalpayout();
            payoutamount();
            $('#filter-date').datepicker(datePickerSetting('{{ $jsDateFormat }}'));
            
            dtTransactionSupport();
            $('#search-form').on('submit', function(e) {
                table.draw();
                e.preventDefault();
                totalpayout();
                payoutamount();
            });
        });

        $('#creatorname').select2({
            placeholder: '@lang("page.type_to_search")',
            allowClear: true,
            theme: "bootstrap-5",
            selectionCssClass: "select2--small",
            ajax: {
                url: "{{ route('admin.transaction.support.selectSearch') }}",
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    };
                    console.log(data);
                },
                cache: true
            }
        });

        const dtTransactionSupport = () => {
            table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                ajax: {
                    url: "{{ route('admin.transaction.disbursement.dtlist') }}",
                    type: 'GET',
                    data: function(d){
                        // console.log(d);
                        d.creator_name = $('select[name=creator_name]').val();
                        d.start_at = $('input[name=start_at]').val();
                        d.end_at = $('input[name=end_at]').val();
                        d.type = $('select[name=type]').val();
                        // data.dataFiltered = $('#form-filters').serializeJSON();
                    }
                },
                columns: [
                    {data: 'DT_Number', name: 'DT_Number', orderable: false},
                    {data: 'creator_name', name: 'creator_name', orderable: false},
                    {data: 'date', name: 'date', orderable: false},
                    {data: 'payout_amount', name: 'payout_amount', width: '10%', orderable: false},
                    {data: 'payout_fee', name: 'payout_fee', width: '10%', orderable: false},
                    {data: 'status', name: 'status', width: '10%', orderable: false},
                    {data: 'detail', name: 'detail', width: '30%', orderable: false},
                ],
                destroy: true
            });
        }

        const totalpayout = async () => {
            let authToken = document.head.querySelector('meta[name="auth"]');
            let creator_id = $('select[name=creator_name]').val();
            let type = $('select[name=type]').val();
            let start_at = $('input[name=start_at]').val();
            let end_at = $('input[name=end_at]').val();
            const params = {'creator_id': creator_id, 'start_at': start_at, 'end_at': end_at, 'type': type}
            var url = "{{ route('admin.transaction.disbursement.totalpayout') }}";
            await axios.post(url, params)
                .then(function (response) {
                    const { data } = response;
                    const { message, status } = data;
                    console.log(data);
                    $("#total_payout h3").html(data+"X");
                })
                .catch(function (error) {
                    console.log(error);
                });
        }

        const payoutamount = async () => {
            let authToken = document.head.querySelector('meta[name="auth"]');
            let creator_id = $('select[name=creator_name]').val();
            let type = $('select[name=type]').val();
            let start_at = $('input[name=start_at]').val();
            let end_at = $('input[name=end_at]').val();
            const params = {'creator_id': creator_id, 'start_at': start_at, 'end_at': end_at, 'type': type}
            var url = "{{ route('admin.transaction.disbursement.payoutamount') }}";
            await axios.post(url, params)
                .then(function (response) {
                    const { data } = response;
                    const { message, status } = data;
                    console.log(data);
                    $("#payoutamount h3").html(data);
                })
                .catch(function (error) {
                    console.log(error);
                });
        }

        const exportexcel = () => {
            let creator_name = $('select[name=creator_name]').val();
            let type = $('select[name=type]').val();
            let start_at = $('input[name=start_at]').val();
            let end_at = $('input[name=end_at]').val();

            $('#ex_start_at').val(start_at);
            $('#ex_end_at').val(end_at);
            $('#ex_type').val(type);
            $('#ex_creator_name').val(creator_name);
            $('#export_excel').submit();
        }
    </script>
@endsection