@extends('layouts.template-body')

@section('title')
    <title>@lang('page.menu_dashboard')</title>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('template/css/jquery.fontselect.min.css') }}">

    <style>
        div#summary, div#totalsupporter {
            position: relative;
            padding: 30px 0;
        }

        path.highcharts-button-symbol {
            display: none;
        }

        .supporter {
            position: absolute;
            right: 0;
            top: 4px;
        }

        .supporter .d-flex div {
            height: 15px;
            width: 15px;
            background: #6103D0;
            margin-right: 4px;
            border-radius: 100%;
            margin-top: 4px;
        }

        text.highcharts-credits {
            display: none;
        }

        /* .highcharts-axis-title {
                    color : black !important;
                    fill : none !important;
                } */

        /* .shepherd-arrow:before {
            background-color : #6103D0 !important;
        } */

        
        /* .shepherd-cancel-icon {
            color : white !important;
        } */
        
    </style>
@endsection

@section('content')
    <div class="container px-5">
        <div class="row">
            <div class="col-12">
                @include('components.breadcrumb', [
                    'title' => __('page.menu_dashboard'), 
                    'pages' => [
                        '#' => __('page.menu_dashboard'),
                    ]
                ])
            </div>

        </div>
        <div class="row my-3">
            <div class="col-md-12 px-0 mx-0">
                <div class="card mb- border-0 4 bg-transparent shadow-none">
                    <div class="card-body px-0 mx-0">
                        <div class="row">
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-3 py-0 bg-transparent step11">
                                <div class="card img-dashboard rounded-lg shadow border-0 p-0 position-relative">
                                    <img src="{{ asset('template/images/dashboard-purple.png') }}" alt=""
                                        class="img-fluid img-dashboard" />
                                    <div class="card-body   position-absolute">
                                        <div>
                                            <h6>
                                                @lang('page.total_balance')
                                            </h6>
                                        </div>
                                        <div class="mt-5">
                                            <h3>{{ $total_amount }}</h3>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-3 py-0 bg-transparent step12">
                                <div class="card img-dashboard shadow bg-transparent bg-1 rounded-lg border-0 p-0 position-relative">
                                    <img src="{{ asset('template/images/dashboard-green.png') }}" alt=""
                                        class="img-fluid img-dashboard" />
                                    <div class="card-body  bg-transparent  position-absolute">
                                        <h6>@lang('page.total_support_this_month')</h6>
                                        <div class="mt-5">
                                            <h3>{{ $amount_this_month }}</h3>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-3 py-0 bg-transparent step13">
                                <div class="card img-dashboard shadow rounded-lg bg-1 border-0 p-0 position-relative">
                                    <img src="{{ asset('template/images/dashboard-red.png') }}" alt=""
                                        class="img-fluid img-dashboard" />
                                    <div class="card-body  bg-transparent  position-absolute">
                                        <h6>@lang($total_support > 1 ? 'page.more_time_support' : 'page.a_time_support')</h6>
                                        <div class="mt-5">
                                            <h3>{{ $total_support }}</h3>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-3 py-0 bg-transparent step14">
                                <div class="card img-dashboard rounded-lg bg-3 shadow border-0 p-0 position-relative">
                                    <img src="{{ asset('template/images/dashboard-grey.png') }}" alt=""
                                        class="img-fluid img-dashboard" />
                                    <div class="card-body bg-transparent  position-absolute">
                                        <h6>@lang('page.disbursed_total')</h6>
                                        <div class="mt-5">
                                            <h3>{{ $total_payout }}</h3>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-3 py-0 bg-transparent step15">
                                <div class="card img-dashboard rounded-lg bg-4 shadow border-0 p-0 position-relative">
                                    <img src="{{ asset('template/images/dashboard-purple.png') }}" alt=""
                                        class="img-fluid img-dashboard" />
                                    <div class="card-body bg-transparent position-absolute">
                                        <h6>@lang('page.total_products_sold')</h6>
                                        <div class="mt-5">
                                            <h3>{{ $total_sold_products }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-3 py-0 bg-transparent step16">
                                <div class="card img-dashboard rounded-lg bg-5 shadow border-0 p-0 position-relative">
                                    <img src="{{ asset('template/images/dashboard-green.png') }}" alt=""
                                        class="img-fluid img-dashboard" />
                                    <div class="card-body bg-transparent position-absolute">
                                        <h6>@lang('page.products_sold_today')</h6>
                                        <div class="mt-5">
                                            <h3>{{ $total_sold_products_today }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 d-flex justify-content-end mb-4">
            <div class="filter-dashboard">
                <select name="filter" id="filter" class="form-select ">
                    <option value="30" selected>@lang('page.last_30_day')</option>
                    <option value="15">@lang('page.last_15_day')</option>
                    <option value="7">@lang('page.last_7_day')</option>
                </select>
            </div>
        </div>

        <div class="col-12">
            <div class="card border-0 bg-white rounded-small shadow mb-5">
                <div class="card-body p-0 mb-3 step17">
                    {{-- <div class="supporter"><div class="d-flex flex-row"><div></div><p>Supporter</p></div></div> --}}
                    <figure class="highcharts-figure">
                        <div id="summary"></div>
                    </figure>
                </div>
            </div>
            <div class="card border-0 bg-white rounded-small shadow mb-5">
                <div class="card-body p-0 mb-3 step18">
                    <figure class="highcharts-figure">
                        <div id="totalsupporter"></div>
                    </figure>
                </div>
            </div>
            <div class="card border-0 bg-white rounded-small shadow mb-5">
                <div class="card-body p-0 mb-3 step19">
                    <figure class="highcharts-figure">
                        <div id="totalproductsold"></div>
                    </figure>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('template/js/jquery.fontselect.min.js') }}"></script>
    <script src="{{ asset('assets/js/clipboard.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script type="text/javascript" src="{{ asset('assets/js/guide/dashboard.js') }}"></script>

    <!-- <script src="{{ asset('assets/plugins/chartjs/chart.min.js') }}"></script> -->

    <script type="text/javascript">
        (function($) {
            "use strict";


            $(() => {
                $("#filter").on("change", function() {
                    Filter();
                });
            });
            var isdark = localStorage.getItem('darkSwitch');
            const charts = (categori, serie, filter) => {
                let judul = '@lang('page.graffic_support')';
                Highcharts.chart('summary', {
                    title: {
                        text: `<span class=" fw-semibold graphic-title my-2 mb-4">${judul.replace(':filter', filter)}</span>`,
                        style: {
                            color: isdark == 'dark' ? '#ffffff' : '#000',
                        }
                    },
                    subtitle: {
                        text: ''
                    },
                    chart: {
                        type: 'spline',
                        backgroundColor: "rgba(0,0,0,0)",
                        color: '#000000',
                    },
                    yAxis: {
                        title: {
                            text: `@lang('page.idr_format')`,
                            style: {
                                color: '#000000',
                            }
                        }
                    },
                    xAxis: {
                        accessibility: {
                            rangeDescription: 'Jumlah Pendapatan',
                            style: {
                                text: 'Primary axis'
                            }
                        },
                        categories: categori,
                    },

                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'middle'
                    },
                    plotOptions: {
                        series: {
                            color: '#D0EE26'
                        }
                    },
                    series: [{
                        showInLegend: false,
                        name: '',
                        data: serie,
                        lineWidth: 5,
                        //color : '#333'
                    }],
                    tooltip: {
                        shared: false,
                        formatter: function() {
                            var serie = this.series;
                            var index = this.series.data.indexOf(this.point);
                            var bilangan = this.y;
                            var rupiah = bilangan.toLocaleString('id-ID', {
                                currency: 'IDR',
                                style: 'currency',
                                minimumFractionDigits: 0
                                });

                            var s = '<b>' + this.x + '</b><br>';
                            s += `@lang('page.transaction_support_total'): <b>` + rupiah + '</b><br/>';
                            return s;
                        }
                    },
                    responsive: {
                        rules: [{
                            condition: {
                                maxWidth: 500
                            },
                            chartOptions: {
                                legend: {
                                    layout: 'horizontal',
                                    align: 'center',
                                    verticalAlign: 'bottom'
                                }
                            }
                        }]
                    }

                });
            }

            //charts();
            const totalsupporter = (categori, serie, filter) => {
                let judul = '@lang('page.graffic_supporter')';
                Highcharts.chart('totalsupporter', {
                    title: {
                        text: `<span class="fw-semibold graphic-title my-2 mb-4">${judul.replace(':filter', filter)}</span>`,
                        style: {
                            color: isdark == 'dark' ? '#ffffff' : '#000',
                        }
                    },
                    subtitle: {
                        text: ''
                    },
                    chart: {
                        type: 'spline',
                        backgroundColor: "rgba(0,0,0,0)"
                        //color: "#fff"
                    },
                    yAxis: {
                        title: {
                            text: 'Jumlah',
                            style: {
                                color: '#141414',
                            }
                        }
                    },
                    xAxis: {
                        accessibility: {
                            rangeDescription: 'Bulan',
                            style: {
                                color: '#fff',
                            }
                        },
                        categories: categori,
                    },

                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'middle'
                    },
                    plotOptions: {
                        series: {
                            color: '#D0EE26'
                        }
                    },
                    series: [{
                        showInLegend: false,
                        name: '',
                        data: serie,
                        lineWidth: 5,
                        //color : '#333'
                    }],
                    responsive: {
                        rules: [{
                            condition: {
                                maxWidth: 500
                            },
                            chartOptions: {
                                legend: {
                                    layout: 'horizontal',
                                    align: 'center',
                                    verticalAlign: 'bottom'
                                }
                            }
                        }]
                    }

                });
            }

            const totalproductsold = (categori, serie, filter) => {
                let judul = '@lang('page.graffic_products_sold')';
                Highcharts.chart('totalproductsold', {
                    title: {
                        text: `<span class="fw-semibold graphic-title my-2 mb-4">${judul.replace(':filter', filter)}</span>`,
                        style: {
                            color: isdark == 'dark' ? '#ffffff' : '#000',
                        }
                    },
                    subtitle: {
                        text: ''
                    },
                    chart: {
                        type: 'spline',
                        backgroundColor: "rgba(0,0,0,0)"
                        //color: "#fff"
                    },
                    yAxis: {
                        title: {
                            text: 'Jumlah Produk',
                            style: {
                                color: '#141414',
                            }
                        }
                    },
                    xAxis: {
                        accessibility: {
                            rangeDescription: 'Bulan',
                            style: {
                                color: '#fff',
                            }
                        },
                        categories: categori,
                    },

                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'middle'
                    },
                    plotOptions: {
                        series: {
                            color: '#FF6B35'
                        }
                    },
                    series: [{
                        showInLegend: false,
                        name: '',
                        data: serie,
                        lineWidth: 5,
                        //color : '#333'
                    }],
                    tooltip: {
                        shared: false,
                        formatter: function() {
                            var s = '<b>' + this.x + '</b><br>';
                            s += 'Jumlah Produk: <b>' + this.y + '</b><br/>';
                            return s;
                        }
                    },
                    responsive: {
                        rules: [{
                            condition: {
                                maxWidth: 500
                            },
                            chartOptions: {
                                legend: {
                                    layout: 'horizontal',
                                    align: 'center',
                                    verticalAlign: 'bottom'
                                }
                            }
                        }]
                    }

                });
            }


            const loadChart = (filter) => {
                if (filter == null) {
                    filter = 30;
                }
                $.ajax({
                    type: 'GET',
                    url: api_url + "user/support/totalamountperdays?filter=" + filter,
                    data: $('#formnotification').serialize(),
                    dataType: 'json',
                    headers: headers,
                    success: function(data) {
                        //console.log(data);
                        let category = [];
                        let serialize = [];
                        let i = 0;
                        $.each(data, function(index, value) {
                            var colection = Object.keys(value).map((key) => [key, value[key]]);
                            category[i] = colection[0][0];
                            serialize[i] = colection[0][1];
                            i++;
                        });

                        /*  console.log(category,'category');
                            console.log(serialize,'serialize'); */
                        charts(category, serialize, filter);

                    }
                });
                return false;
            }


            const loadChartcount = (filter) => {
                if (filter == null) {
                    filter = 30;
                }
                $.ajax({
                    type: 'GET',
                    url: api_url + "user/support/totalcountperdays?filter=" + filter,
                    data: $('#formnotification').serialize(),
                    dataType: 'json',
                    headers: headers,
                    success: function(data) {
                        //console.log(data);
                        let category = [];
                        let serialize = [];
                        let i = 0;
                        $.each(data, function(index, value) {
                            var colection = Object.keys(value).map((key) => [key, value[key]]);
                            category[i] = colection[0][0];
                            serialize[i] = colection[0][1];
                            i++;
                        });

                        //console.log(category, 'category');
                        //console.log(serialize, 'serialize');
                        totalsupporter(category, serialize, filter);
                    }
                });
                return false;
            }

            const loadChartProducts = (filter) => {
                if (filter == null) {
                    filter = 30;
                }
                $.ajax({
                    type: 'GET',
                    url: api_url + "user/support/totalsoldproductsperdays?filter=" + filter,
                    data: $('#formnotification').serialize(),
                    dataType: 'json',
                    headers: headers,
                    success: function(data) {
                        //console.log(data);
                        let category = [];
                        let serialize = [];
                        let i = 0;
                        $.each(data, function(index, value) {
                            var colection = Object.keys(value).map((key) => [key, value[key]]);
                            category[i] = colection[0][0];
                            serialize[i] = colection[0][1];
                            i++;
                        });

                        //console.log(category, 'category');
                        //console.log(serialize, 'serialize');
                        totalproductsold(category, serialize, filter);
                    }
                });
                return false;
            }
            totalsupporter();
            loadChart();
            loadChartcount();
            loadChartProducts();

            const Filter = () => {
                var filter = $('#filter').val();
                console.log(filter);
                loadChart(filter);
                loadChartcount(filter);
                loadChartProducts(filter);
            }
        })(jQuery);
    </script>
@endsection
@if (Auth::user()->role === 'ls_creator')
    <h2>Kelola Produk</h2>
    <a href="{{ route('products.index') }}">Produk Saya</a>
@endif
