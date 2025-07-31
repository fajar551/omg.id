@extends('layouts.template-body')

@section('title')
    <title>@lang('page.balance')</title>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('template/vendor/datatable/DataTables-1.11.4/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/vendor/datatable/ext/Responsive-2.2.9/css/responsive.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}">
    <style>
        @media only screen and (max-width: 728px) {
            .dataTables_length {
                padding-right: 80px;
                margin-bottom: 10px;
            }

            .dataTables_filter {
                margin-top: 10px;
                padding-right: -190px;
            }
        }

        @media only screen and (max-width: 728px) {
            .dataTables_length {
                padding-left: 10px;
            }
        }

        .page-item.active .page-link {
            background-color: #6103d0 !important;
            border-color: #6103d0 !important;
        }
    </style>
@endsection

@section('content')
    <div class="container px-5 mb-5">
        <div class="row">
            <div class="col-12">
                @include('components.breadcrumb', [
                    'title' => __('page.balance'),
                    'pages' => [
                        '#' => __('page.balance'),
                    ],
                ])
            </div>
        </div>

        @if ($pending_amount == 'Rp0' && $active_amount == 'Rp0')
            @include('components.is-empty-data', [
                'message' => 'Anda belum memiliki Balance',
                'text' => 'Selamat Streaming dan kumpulkan supporter sebanyak-banyaknya',
                'link' => [
                    [
                        'url' => route('overlay.index'),
                        'icon' => '<i class="las la-video"></i>',
                        'title' => 'Mulai Streaming',
                    ],
                ],
            ])
        @else
            <div class="row px-0 mx-0">
                <div class="col-md-12 px-0 mx-0">
                    <div class="card mb- border-0 4 bg-transparent shadow-none">
                        <div class="card-body px-0 mx-0 card-balance">
                            <div class="row">
                                @include('components.flash-message', ['flashName' => 'message'])
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12  bg-transparent">
                                    <div class="card img-dashboard rounded-small shadow border-0 px-0 card-bg1 mb-3">
                                        <div class="card-body d-flex flex-column justify-content-start step11">
                                            <p class=" mb-1">@lang('page.pending_amount')</h2>
                                            <h2 class="mb-5 d-flex ">
                                                <span class="text-sm">Rp</span>
                                                <div class="pt-2 mx-2">
                                                    {{ number_format($pending_amount, 0, ',', '.') }}
                                                </div>
                                                </h3>
                                                <p class="text-sm">@lang('page.pending_amount_desc') </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 py-0 bg-transparent" style="position: relative;">
                                    <div class="card img-dashboard rounded-small shadow border-0 p-0 card-bg2 mb-3">
                                        <div class="card-body step12">
                                            <p class=" mb-1">@lang('page.active_amount')</p>
                                            <h2 class="mb-5 d-flex">
                                                <span class="text-sm">Rp</span>
                                                <div class="pt-2 mx-2">
                                                    {{ number_format($active_amount, 0, ',', '.') }}
                                                </div>

                                            </h2>
                                            <p class="text-sm">@lang('page.active_amount_desc') </p>
                                            <div class="d-flex justify-content-end">
                                                <button type="button" class="btn btn-outline-primary rounded-pill shadow step16" style="text-decoration: none; position: absolute; bottom: 15px; " data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                    @lang('page.disbursements')
                                                </button>
                                            </div>
                                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">
                                                                @lang('page.disbursements')</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                                                            </button>
                                                        </div>
                                                        <form action="{{ route('payout.create') }}" method="POST" class="mt-2 needs-validation" id="input-form" enctype="multipart/form-data" onsubmit="doSubmit($('#btn-submit'))" autocomplete="off">
                                                            <div class="modal-body">
                                                                @include('components.flash-message', [
                                                                    'flashName' => 'message',
                                                                ])
                                                                @csrf
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label class="form-label" for="amount">@lang('page.total_payout') <span class="text-danger">*</span></label>
                                                                            <input name="amount" type="text" type-currency="IDR" placeholder="Rp 50.000" min="50000" id="amount" class="form-control mb-0 @error('amount') is-invalid @enderror" value="{{ old('amount') }}" placeholder="@lang('page.minimum_payout')" required>
                                                                            <div class="mt-1">
                                                                                <small class="">*) @lang('page.desc_payout'){{ $payout_fee }} (@lang('page.include_ppn')) </small>
                                                                            </div>
                                                                            @error('amount')
                                                                                <div class="invalid-feedback">
                                                                                    {{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12 mt-3">
                                                                        <div class="form-group">
                                                                            <label class="form-label" for="password">@lang('form.lbl_confirm_password') <span class="text-danger">*</span></label>
                                                                            <input name="password" type="password" placeholder="Input your password for validation" class="form-control mb-0 @error('password') is-invalid @enderror" value="{{ old('password') }}" placeholder="@lang('page.minimum_payout')" required>
                                                                            @error('password')
                                                                                <div class="invalid-feedback">
                                                                                    {{ $message }}</div>
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
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 py-0 bg-transparent">
                                    <div class="card img-dashboard rounded-small shadow border-0 p-0 card-bg4 mb-3">
                                        <div class="card-body step13">
                                            @if ($payout_account)
                                                <div class="d-flex align-items-end justify-content-between">
                                                    <h5 class="fw-semibold">@lang('page.payout_account')</h5>
                                                    <div class="float-end">
                                                        @if ($payout_account['status'] == 1)
                                                            <span class="badge bg-success mt-2 text-end">Verified</span>
                                                        @else
                                                            <span class="badge bg-warning mt-2 text-end">Unverified</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div>
                                                    {{ ucwords($payout_account['channel_code'] . ' - ' . $payout_account['account_number']) }}<span class="d-iflex pointer-none ml-5 p-1"><i class="las la-check-circle"></i></span></div>
                                                <p>{{ $payout_account['account_name'] }}</p>
                                                <a href="{{ route('payoutaccount.index') }}">@lang('page.list_payout_account')</a>
                                            @else
                                                <h5>@lang('page.set_payout_account')</h5>
                                                <a href="{{ route('payoutaccount.index') }} " style="color: #6103d0 !important;">@lang('page.create')</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-md-12 px-0 mx-0 mt-3">
                    <div class="card shadow border-0 rounded-small card-dark">
                        <div class="card-header ">
                            <h4 class="card-title">@lang('page.transaction_history')</h4>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <div class="form-group">
                                        <select class="form-select inner-card-dark" id="type_filter" name="type">
                                            <option class="option" value="all">All</option>
                                            <option class="option" value="support">Support</option>
                                            <option class="option" value="payout">Disbursement</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6 ">
                                    <div class="float-end">
                                        <button class="btn btn-outline-primary step15" type="button" data-bs-toggle="modal" data-bs-target="#exportcsv"> @lang('Export')</button>
                                    </div>
                                    <div class="modal fade" id="exportcsv" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <form class="mt-1 needs-validation" id="search-form" autocomplete="off">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel"> @lang('Export')
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <div class="form-group mb-2">
                                                            <label class="form-label" for="start">@lang('page.date_range')</label>
                                                            <div class="input-group input-daterange" id="filter-date">
                                                                <input type="text" class="form-control @error('start_at') is-invalid @enderror" id="start_at" placeholder="From ({{ $jsDateFormat }})" value="{{ old('start_at') }}" autocomplete="off" required>
                                                                @error('start_at')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                                &nbsp;
                                                                <input type="text" class="form-control @error('end_at') is-invalid @enderror" id="end_at" placeholder="To ({{ $jsDateFormat }})" value="{{ old('end_at') }}" autocomplete="off" required>
                                                                @error('end_at')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label" for="start">Type</label>
                                                            <div class="form-group">
                                                                <select class="form-select" id="type_filter1" name="type" required>
                                                                    <option value="all">All</option>
                                                                    <option value="support">Support</option>
                                                                    <option value="payout">Disbursement</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        @csrf
                                                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="button" id="btn-export" class="btn btn-sm btn btn-primary"><i class="las la-file-excel"></i> @lang('Export')</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table table-striped pb-3 pt-3 step14" id="table">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center">@lang('form.lbl_number')</th>
                                                <th scope="col" class="text-center">@lang('form.lbl_type')</th>
                                                <th scope="col" class="text-center">@lang('form.lbl_fee')</th>
                                                <th scope="col" class="text-center">@lang('form.lbl_amount_get')</th>
                                                <th scope="col" class="text-center">@lang('form.lbl_status')</th>
                                                <th scope="col" class="text-center">@lang('form.lbl_created_at')</th>
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
        @endif
    </div>
    <form action="{{ route('balance.exporttransactions') }}" method="post" id="export_excel" hidden>
        @csrf
        @method('post')
        <input type="hidden" name="start_at" id="ex_start_at">
        <input type="hidden" name="end_at" id="ex_end_at">
        <input type="hidden" name="type" id="ex_type">
    </form>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('template/vendor/datatable/DataTables-1.11.4/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/vendor/datatable/DataTables-1.11.4/js/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('template/vendor/datatable/ext/Responsive-2.2.9/js/dataTables.responsive.js') }}"></script>
    <script src="{{ asset('template/vendor/datatable/ext/Responsive-2.2.9/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('template/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/utils.js') }}"></script>
    @if ($pending_amount == 'Rp0' && $active_amount == 'Rp0')
    <script type="text/javascript" src="{{ asset('assets/js/guide/balanceEmpty.js') }}"></script>
    @else
    <script type="text/javascript" src="{{ asset('assets/js/guide/balance.js') }}"></script>
    @endif
    <script type="text/javascript">
        (function($) {
            "use strict";
            $(() => {

                $('#filter-date').datepicker(datePickerSetting('{{ $jsDateFormat }}'));

                @error('amount')
                    $('#exampleModal').modal("show");
                @enderror
                @error('password')
                    $('#exampleModal').modal("show");
                @enderror
                @error('start_at')
                    $('#exportcsv').modal("show");
                @enderror

                @error('end_at')
                    $('#exportcsv').modal("show");
                @enderror


                @error('amount')
                    $('#amount').val(({{ preg_replace('/[^0-9]+/', '', old('amount')) }}).toLocaleString('id-ID', {
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

                var table = $('#table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('balance.transaction.list') }}",
                        data: function(d) {
                            d.type = $('#type_filter').val() //this is the main point
                        }
                    },
                    columns: [{
                            data: 'DT_Number',
                            name: 'DT_Number',
                            className: 'text-center',
                            orderable: false
                        },
                        {
                            data: 'type',
                            name: 'type',
                            className: 'text-center',
                            orderable: false
                        },
                        {
                            data: 'fee',
                            name: 'fee',
                            className: 'text-center',
                            orderable: false
                        },
                        {
                            data: 'amount',
                            name: 'amount',
                            className: 'text-center',
                            orderable: false
                        },
                        {
                            data: 'status',
                            name: 'status',
                            className: 'text-center',
                            orderable: false
                        },
                        {
                            data: 'created_at',
                            className: 'text-center',
                            name: 'created_at'
                        }
                    ],
                    destroy: true
                });
                $('#type_filter').on('change', function() {
                    // console.log($('#type_filter').val());
                    table.draw();
                });

                $("#btn-export").on("click", function() {
                    exportexcel();
                });
            });

            const exportexcel = () => {
                let type = $('#type_filter1').val();
                let start_at = $('#start_at').val();
                let end_at = $('#end_at').val();

                $('#ex_start_at').val(start_at);
                $('#ex_end_at').val(end_at);
                $('#ex_type').val(type);
                $('#export_excel').submit();
            }
        })(jQuery);
    </script>
@endsection
