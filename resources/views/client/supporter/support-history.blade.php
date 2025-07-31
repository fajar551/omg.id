@extends('layouts.template-body')

@section('title')
    <title>Riwayat Dukungan</title>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('template/vendor/datatable/DataTables-1.11.4/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/vendor/datatable/ext/Responsive-2.2.9/css/responsive.bootstrap5.min.css') }}">
    <style>
        #select-order {
            margin-top: -65px;
        }

        @media screen and (max-width: 768px) {
            #select-order {
                margin-top: -15px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container px-5">
        <div class="row">
            <div class="col-12">
                @include('components.breadcrumb', [
                    'title' => __('Riwayat Dukungan'),
                    'pages' => __('Dukungan'),
                ])
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                @include('components.flash-message', ['flashName' => 'message'])
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">

                <div class="row d-flex justify-content-end" id="select-order">
                    <div class="col-lg-4">
                        <select name="order" id="order_status" class="form-select mt-lg-2 mt-4 step2">
                            <option value="success">Sukses</option>
                            <option value="failed">Gagal</option>
                            <option value="pending">Pending</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 mt-4">
                <div class="card border-0 shadow rounded-small card-dark">
                    <div class="card-body step1">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">@lang('Tanggal')</th>
                                        <th scope="col" class="text-center">@lang('Kreator')</th>
                                        <th scope="col" class="text-center">@lang('Pesan')</th>
                                        <th scope="col" class="text-center">@lang('Nominal')</th>
                                        <th scope="col" class="text-center">@lang('Metode')</th>
                                        <th scope="col" class="text-center">@lang('Status')</th>
                                        <th scope="col" class="text-center">@lang('Aksi')</th>
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
@endsection

@section('scripts')
    <script src="{{ asset('template/vendor/datatable/DataTables-1.11.4/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/vendor/datatable/DataTables-1.11.4/js/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('template/vendor/datatable/ext/Responsive-2.2.9/js/dataTables.responsive.js') }}"></script>
    <script src="{{ asset('template/vendor/datatable/ext/Responsive-2.2.9/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/js/utils.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/guide/support.js') }}"></script> 
    <script type="text/javascript">
        (function($) {
            "use strict";

            $(() => {
                var table = $('#table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('supporter.transaction.list') }}",
                        data: function(d) {
                            d.type = $('#order_status').val()
                        }
                    },
                    columns: [{
                            data: 'created_at',
                            name: 'created_at',
                            className: 'text-center',
                            orderable: false
                        },
                        {
                            data: 'creator_name',
                            name: 'creator_name',
                            className: 'text-start',
                            orderable: false
                        },
                        {
                            data: 'message',
                            name: 'message',
                            className: 'text-start',
                            orderable: false
                        },
                        {
                            data: 'amount',
                            name: 'amount',
                            className: 'text-center',
                            orderable: false
                        },
                        {
                            data: 'payment_type',
                            name: 'payment_type',
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
                            data: 'actions',
                            name: 'actions',
                            className: 'text-center',
                            orderable: false,
                            searchable: false
                        }
                    ],
                    destroy: true
                });

                $('#order_status').on('change', function() {
                    table.draw();
                });
            });

        })(jQuery);
    </script>
@endsection
