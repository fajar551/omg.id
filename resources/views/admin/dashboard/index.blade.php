@extends('layouts.admin.omg')

@section('title',  __('Dashboard'))

@section('styles')

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
                       <li class="breadcrumb-item active" aria-current="page">@lang('page.dashboard')</li>
                    </ol>
                 </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                           <h5 class="card-title">@lang('page.dashboard')</h5>
                        </div>
                        <div class="card-header-toolbar d-flex align-items-center">
                            <p>&nbsp;</p>
                        </div>
                    </div>
                    <div class="card-body">
                        
                        @include('components.flash-message', ['flashName' => 'message'])
                        <div class="row">
                            <div class="col-sm-6 col-lg-4">
                                <div class="card card-dark-80">
                                    <div class="card-body">
                                        <div>
                                            <h3>{{ $total_creator }}</h3>
                                        </div>
                                        <div>@lang('Total Creator')</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <div class="card card-dark-80">
                                    <div class="card-body">
                                        <div>
                                            <h3>{{ $total_creator_today }}</h3>
                                        </div>
                                        <div>@lang('New Creator Today')</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <div class="card card-dark-80">
                                    <div class="card-body">
                                        <div>
                                            <h3>{{ $total_support }}</h3>
                                        </div>
                                        <div>@lang('Total Support')</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <div class="card card-dark-80">
                                    <div class="card-body">
                                        <div>
                                            <h3>{{ $total_support_today }}</h3>
                                        </div>
                                        <div>@lang('Total Support Today')</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <div class="card card-dark-80">
                                    <div class="card-body">
                                        <div>
                                            <h3>{{ $platform_amount }}</h3>
                                        </div>
                                        <div>@lang('Platform Amount')</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <div class="card card-dark-80">
                                    <div class="card-body">
                                        <div>
                                            <h3>{{ $iris_balance }}</h3>
                                        </div>
                                        <div>@lang('Iris Midtrans Balance')</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <div class="card card-dark-80">
                                    <div class="card-body">
                                        <div>
                                            <h3>{{ $xendit_balance }}</h3>
                                        </div>
                                        <div>@lang('Xendit Balance')</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card shadow-none mt-3">
                            <div class="card-body p-0 mb-3">
                                <div class="col-md-4 mb-3" style="display: flex; justify-content: flex-end;">
                                    <select name="filter" id="filter" onchange="Filter()" class="form-select">
                                        <option value="30">30 Days</option>
                                        <option value="15">15 Days</option>
                                        <option value="7">7 Days</option>
                                    </select>
                                </div>
                                <figure class="highcharts-figure">
                                    <div id="summary"></div>
                                </figure>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script type="text/javascript">
        $(()=>{

        });
        const charts =(categori,serie, filter) =>{
            Highcharts.chart('summary', {
                title: {
                    text: 'Jumlah Pendapatan Platform Dalam '+filter+' Hari terakir',
                    style: {
                        color: '#6c6c6d',
                    }
                },
                subtitle: {
                    text: ''
                },
                chart : {
                    backgroundColor: "rgba(0,0,0,0)"
                    //color: "#fff"
                },
                yAxis: {
                    title: {
                        text: 'Nominal Rupiah',
                        style: {
                            color: '#6c6c6d',
                        }
                    }
                },
                xAxis: {
                    accessibility: {
                        rangeDescription: 'Jumlah Pendapatan',
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


                series: [{
                    showInLegend : false,
                    name : '',
                    data: serie,
                    lineWidth: 5,
                    //color : '#333'
                }],
                tooltip: {
                    shared: false,
                    formatter: function() {
                        var serie = this.series;
                        //NOTE: may cause efficiency issue when we got lots of points, data in series
                        //should be change from [x, y] to {"x": x, "y": y, "index": index}
                        var index = this.series.data.indexOf(this.point);
                        var bilangan = this.y;
                        var	number_string = bilangan.toString(),
                            sisa 	= number_string.length % 3,
                            rupiah 	= number_string.substr(0, sisa),
                            ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
                                
                        if (ribuan) {
                            separator = sisa ? '.' : '';
                            rupiah += separator + ribuan.join('.');
                        }

                        var s = '<b>' + this.x + '</b><br>';
                        s += 'Jumlah Support: <b>Rp' + rupiah + '</b><br/>';
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
            if (filter==null) {
                filter = 30;
            }
            $.ajax({
                type: 'GET',
                url: "{{url('api/user/support/platformamountperdays')}}?filter="+filter,
                data: $('#formnotification').serialize(),
                dataType: 'json',
                headers : headers,
                success: function(data){
                    //console.log(data);
                    let category = [];
                    let serialize =[];
                    let i=0;
                    $.each(data, function( index, value ) {
                        var colection =Object.keys(value).map((key) => [key, value[key]]);
                        category[i]=colection[0][0];
                        serialize[i]=colection[0][1];
                        i++;
                    });

                    //console.log(category,'category');
                    // console.log(serialize,'serialize');
                    charts(category,serialize,filter);
                }
            });
            return false;
        }
        loadChart();

        const Filter = () => {
            var filter = $('#filter').val();
            console.log(filter);
            loadChart(filter);
        }
    </script>
@endsection