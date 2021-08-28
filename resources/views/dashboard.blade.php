@extends('layouts.app')

@section('plugins_styles')

@endsection

@section('content')

<div class="layout-px-spacing">

    <div class="row sales layout-top-spacing">


        @if(Auth::user()->role==1)
        <div class="col-lg-6 layout-spacing">
            <div class="widget widget-chart-one">
                <div class="widget-heading">

                    <div id="myChart1"></div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6" style="margin-right: 20px;">
                        <label class="font-normal">Filter Tanggal</label>
                        <div class="input-group date">
                            <input class="form-control" onchange="getPieBulan()" id="type-filter" type="date" name="dtgl">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 layout-spacing">
            <div class="widget widget-chart-one">
                <div class="widget-heading">

                    <div id="myChart2"></div>


                </div>
            </div>
        </div>

        @else
        <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
            <div class="widget widget-chart-one">
                <div class="widget-heading">
                    <h5 class="">Selamat Datang di Aplikasi Antri Aja</h5>
                    <ul class="tabs tab-pills">
                        <!-- <li><a href="javascript:void(0);" id="tb_1" class="tabmenu">Tanggal</a></li> -->
                    </ul>
                </div>
                <!-- <div class="widget-heading">
                    <h5 class="">Daftar Jumlah Antrian</h5>
                    <ul class="tabs tab-pills">
                        <li><a href="javascript:void(0);" id="tb_1" class="tabmenu">Tanggal</a></li>
                    </ul>
                </div> -->

                <!-- <div class="widget-content">
                    <div class="tabs tab-content">
                        <div id="content_1" class="tabcontent">
                            <div id="revenueMonthly"></div>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
        @endif

        <!-- <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
            <div class="widget widget-chart-two">
                <div class="widget-heading">
                    <h5 class="">Sales by Category</h5>
                </div>
                <div class="widget-content">
                    <div id="chart-2" class=""></div>
                </div>
            </div>
        </div> -->

    </div>





</div>


<script>
    var dataPie = JSON.parse('{{json_encode($pie)}}'.replace(/&quot;/g, '"'));
    Highcharts.chart('myChart1', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.y:.0f}</b>'
        },
        title: {
            text: 'Grafik Informasi Jumlah Antrian Berdasarkan Hari/Tgl'
        },
        colors: ['#4ecf1f', '#2b0eeb', 'red', 'yellow'],
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.0f} ',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            name: 'Jumlah Antrian',
            colorByPoint: true,
            data: dataPie
        }]
    });
    var dataLine = JSON.parse('{{json_encode($column_chart)}}'.replace(/&quot;/g, '"'));

    Highcharts.chart('myChart2', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Grafik Jumlah Antrian'
        },
        subtitle: {
            text: 'Berdasarkan Status Antrian'
        },
        colors: ['blue', 'green', ],
        xAxis: {
            categories: dataLine[0],
            crosshair: true
        },
        yAxis: {
            allowDecimals: false,
            min: 0,
            title: {
                text: 'Jumlah Antrian'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.0f} </b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            },
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        exporting: {
            enabled: true
        },
        series: [{
            name: 'Menunggu',
            data: dataLine[1]

        }, {
            name: 'Ditangani',
            data: dataLine[2]

        }]
    });


    function getPieBulan() {
        var id = document.getElementById('type-filter').value;
        console.log(id);
        $.get("/chart/getpiedate/" + id, function(data) {
            console.log(data);
            // var dataPie = JSON.parse(data.replace(/&quot;/g, '"'));
            Highcharts.chart('myChart1', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                tooltip: {
                    pointFormat: '<b>{point.y:.0f}</b>'
                },
                title: {
                    text: 'Grafik Informasi Jumlah Antrian Berdasarkan Hari/Tgl'
                },
                colors: ['#4ecf1f', '#2b0eeb', 'red', 'yellow'],
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '{point.y:.0f} ',
                            style: {
                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                            }
                        }
                    }
                },
                series: [{
                    name: 'Jumlah Antrian',
                    colorByPoint: true,
                    data: data
                }]
            });
        });


    }
</script>
@endsection