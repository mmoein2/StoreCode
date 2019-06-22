@extends('layout')

@section('content')
    <style>
        td,tr{
            text-align: center;
            border: 1px solid gray;
        }
    </style>
    @include('error')
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header">
                </div>
                <div class="box-body">

                    <div class="col-md-6">
                        <canvas id="pieChart"  style="width: 100%;height: 400px"></canvas>
                    </div>


                    <div class="col-md-6" style="vertical-align: middle">
                        <div class="box-body table-responsive no-padding">
                        <table class="table" style="margin-top: 40px">
                            <h4 style="text-align: center;color:#6b6b6b ">وضعیت کدهای اصلی مصرف نشده</h4>
                            <thead>
                                <tr>
                                    <td>نوع</td>
                                    <td>تعداد باقیمانده</td>
                                </tr>
                            </thead>

                            <tbody>
                            @for($g=0;$g<count($pie_lable);$g++)
                                <tr>
                                    <td>
                                       {{$pie_lable[$g]}}
                                    </td>
                                    <td>
                                        {{$table_data[$g]}}
                                    </td>
                                </tr>
                                @endfor
                            </tbody>
                        </table>
                        </div>
                    </div>


                    <div class="col-md-12" style="margin-top: 100px">
                    <canvas id="myChart"  style="width: 100%;height: 700px"></canvas>
                    </div>

                    <div class="col-md-12" style="margin-top: 100px">
                        <canvas id="lineChart1"  style="width: 100%;height: 700px"></canvas>
                    </div>

                    <div class="col-md-12" style="margin-top: 100px">
                        <canvas id="lineChart2"  style="width: 100%;height: 700px"></canvas>
                    </div>

                    <div class="col-md-12" style="margin-top: 100px">
                        <canvas id="lineChart3"  style="width: 100%;height: 700px"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection

@section('css')
<style href="/css/chart.js"></style>
@endsection
@section('js')
    <script src="/js/chart.js">

    </script>
    <script>
        //bar chart
        var ctx = document.getElementById('myChart');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($bar_chartlable)  !!},
                datasets: [

                    {
                    label: 'مصرف شده',
                        data: {!! json_encode($used_score) !!},
                    backgroundColor: [
                        <?php foreach($used_score as $s){
                          echo "'#3498DB',";
                            }
                        ?>
                    ],

                    borderWidth: 2,

                },
                    {
                        label: 'مصرف نشده',
                        data: {!! json_encode($unused_score) !!},
                        backgroundColor: [
                            <?php foreach($used_score as $s){
                            echo "'orange',";
                        }
                            ?>
                        ],

                        borderWidth: 2,

                    },
                    {
                        label: 'در اختیار فروشگاه',
                        data: {!! json_encode($shop_score) !!},
                        backgroundColor: [
                            <?php foreach($used_score as $s){
                            echo "'#A6ACAF',";
                        }
                            ?>
                        ],

                        borderWidth: 2,


                    }],


            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            fontFamily: 'Vazir',

                        }
                    }],
                    xAxes: [{
                        ticks: {

                            fontFamily: 'Vazir',

                        }
                    }]
                },
                legend: {
                    labels: {
                        // This more specific font property overrides the global property
                        fontFamily: 'Vazir',

                    }
                },
                title: {
                    display: true,
                    text: 'وضعیت کدهای فرعی',
                    fontFamily: 'Vazir',
                    fontSize: 18,

                },

            }
        });
    </script>

    <script>
        var pie_ctx = document.getElementById("pieChart");
        var myPieChart = new Chart(pie_ctx, {
            type: 'pie',
            data : {
                datasets: [{
                    data: {!! json_encode($pie_data) !!},
                    backgroundColor:[
                        '#3498DB',
                        '#ff7231',
                        '#A6ACAF',
                        '#ccc522',
                        '#666633',
                        '#99FF00',
                        '#333366',
                        '#6666FF',
                        '#CC33CC',
                        '#6600CC',

                    ],

                }],
                labels: {!! json_encode($pie_lable) !!}

            },
            options: {

                legend: {
                    labels: {
                        // This more specific font property overrides the global property
                        fontFamily: 'Vazir',

                    }
                },
                title: {
                    display: true,
                    text: 'وضعیت کدهای اصلی مصرف شده',
                    fontFamily: 'Vazir',
                    fontSize: 18,

                },

            }


        });
    </script>

    <script>
        var ctx1 = $("#lineChart1");
        Chart.defaults.global.defaultFontFamily = "Vazir";


        var myChart = new Chart(ctx1, {
            type: 'line',
            data: {

                datasets: [{
                    label: 'نمودار ثبت کدهای فرعی',
                    data:  {{json_encode($subcode_series)}},


                    borderWidth: 1,
                    borderColor:'orange',
                    lineTension: 0


                }],

                labels: ["فروردین","اردیبهشت","خرداد","تیر","مرداد","شهریور","مهر","آبان","آذر","دی","بهمن","اسفند"]
            }

        });

        var ctx2 = $("#lineChart2");
        Chart.defaults.global.defaultFontFamily = "Vazir";


        var myChart = new Chart(ctx2, {
            type: 'line',
            data: {

                datasets: [{
                    label: 'نمودار مشتریان',
                    data:  {{json_encode($customer_series)}},


                    borderWidth: 1,
                    borderColor:'orange',
                    lineTension: 0

                }],

                labels: ["فروردین","اردیبهشت","خرداد","تیر","مرداد","شهریور","مهر","آبان","آذر","دی","بهمن","اسفند"]
            },
            lineTension: 0,
            cubicInterpolationMode: 'monotone'

        });

        var ctx3 = $("#lineChart3");
        Chart.defaults.global.defaultFontFamily = "Vazir";


        var myChart = new Chart(ctx3, {
            type: 'line',
            data: {

                datasets: [{
                    label: 'نمودار فروشگاه ها',
                    data:  {{json_encode($shop_series)}},


                    borderWidth: 1,
                    borderColor:'orange',
                    lineTension: 0


                }],

                labels: ["فروردین","اردیبهشت","خرداد","تیر","مرداد","شهریور","مهر","آبان","آذر","دی","بهمن","اسفند"]
            }

        });
    </script>
    @endsection