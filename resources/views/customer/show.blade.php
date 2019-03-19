@extends('layout')

@section('css')
    <style>
        .col-md-3{
            margin-top: 40px;
            font-size: 15px;
        }
        .col-md-4{
            margin-top: 20px;
            font-size: 15px;

        }
        .col-md-2{
            margin-top: 18px;
            font-size: 15px;

        }
        .col-md-12{
            margin-top: 18px;
            font-size: 15px;

        }
        .title
        {
            font-size: 18px;
        }
        th{
           text-align: center;
        }

    </style>
@endsection
@section('js')
    <link href="/css/Mh1PersianDatePicker.css" rel="stylesheet">

    <script src="/js/Mh1PersianDatePicker.js"></script>
    <script>
        function showDateTimepicker(t) {
            Mh1PersianDatePicker.Show(t,'{{\Morilog\Jalali\Jalalian::now()->format('Y/m/d')}}'); //parameter1: input, parameter2: today

        }
    </script>
@endsection
@section('content')
    @include('error')
    <div class="row">
        <div class="box" style="text-align: center">
            <div class="box-header">

                <div class="col-md-4">
                    <label class="title">کد مشتری :</label>
                    {{$customer->id}}
                </div>
                <div class="col-md-4">
                    <label class="title">نام مشتری :</label>
                    {{$customer->fullname}}
                </div>
                <div class="col-md-4">
                    <label class="title">شماره همراه :</label>
                    {{$customer->mobile}}
                </div>


                <div class="col-md-3">
                    <label class="title">امتیاز کلی :</label>
                    {{$customer->score}}
                </div>
                <div class="col-md-3">
                    <label class="title">امتیاز فعلی :</label>
                    {{$customer->score-$customer->used_score}}
                </div>
                <div class="col-md-3">
                    <label class="title">امتیاز مصرف شده :</label>
                    {{$customer->used_score}}
                </div>
                <div class="col-md-3">
                    <label class="title">تاریخ عضویت :</label>
                    {{$customer->getPersianRegistrationDate()}}
                </div>



            </div>
<hr>
            <div class="box-body">

                <div style="text-align: right;padding: 10px">
                    <span style="font-size: 15px">جستجو
                    </span>
                <button onclick="searchForm.submit()" class="btn btn-default"><i class="fa fa-search"></i></button>
                <a href="/customer/show?id={{$customer->id}}" class="btn btn-default"><i class="fa fa-close"></i></a>
                </div>

                <form autocomplete="off" action="/customer/show" method="get" id="searchForm">
                    <input type="hidden" value="{{$customer->id}}" name="id">
                    <div  class="row" style="margin: 10px;text-align: right">

                        <div class="col-md-2">
                            <label>کد :</label><input value="{{$_GET['s_code']??''}}" name="s_code" class="form-control" type="text">
                        </div>
                        <div class="col-md-2">
                            <label>سریال از :</label><input value="{{$_GET['s_serialFrom']??''}}" name="s_serialFrom" class="form-control" type="text">
                            <label> تا </label><input value="{{$_GET['s_serialTo']??''}}" class="form-control" name="s_serialTo" type="text">

                        </div>

                        <div class="col-md-2">
                            <label>امتیاز از :</label><input id="dateFrom" class="form-control" value="{{$_GET['s_scoreFrom']??''}}" name="s_scoreFrom" type="text">
                            <label> تا </label><input value="{{$_GET['s_scoreTo']??''}}" class="form-control" name="s_scoreTo" type="text">
                        </div>

                        <div class="col-md-2">
                            <label>تاریخ استفاده از :</label><input onclick="showDateTimepicker(this)" id="dateFrom" class="form-control" value="{{$_GET['s_dateFrom']??''}}" name="s_dateFrom" type="text">
                            <label> تا </label><input value="{{$_GET['s_dateTo']??''}}" class="form-control" name="s_dateTo" type="text" onclick="showDateTimepicker(this)">
                        </div>

                        <div class="col-md-2">
                            <label>فروشگاه :</label><input value="{{$_GET['shop_name']??''}}" name="shop_name" class="form-control" type="text">
                        </div>
                    </div>
                    <hr>
                </form>
                <h3>کدهای فرعی استفاده شده</h3>

                <table class="table table-hover">
                    <tr style="background-color: #f2f2f2">
                        <th>کد</th>
                        <th>سریال</th>
                        <th>امتیاز</th>
                        <th>تاریخ استفاده</th>
                        <th>فروشگاه</th>
                    </tr>
                    @foreach($subcodes as $s)
                    <tr>
                        <td>{{$s->code}}</td>
                        <td>{{$s->serial}}</td>
                        <td>{{$s->score}}</td>
                        <td>{{$s->getPerisanCustomerDate()}}</td>
                        <td>{{$s->shop->name}}</td>
                    </tr>
                    @endforeach
                </table>
                {{$subcodes->appends($_GET)->links()}}
            </div>
        </div>


        <div class="box" style="text-align: center">
            <div class="box-header">
                <div style="text-align: right;padding: 10px">
                    <span style="font-size: 15px">جستجو
                    </span>
                    <button onclick="searchForm2.submit()" class="btn btn-default"><i class="fa fa-search"></i></button>
                    <a href="/customer/show?id={{$customer->id}}" class="btn btn-default"><i class="fa fa-close"></i></a>
                </div>

                <form autocomplete="off" action="/customer/show" method="get" id="searchForm2">
                    <input type="hidden" value="{{$customer->id}}" name="id">
                    <div  class="row" style="margin: 10px;text-align: right">

                        <div class="col-md-3">
                            <label>کد :</label><input value="{{$_GET['m_code']??''}}" name="m_code" class="form-control" type="text">
                        </div>
                        <div class="col-md-3">
                            <label>سریال از :</label><input value="{{$_GET['m_serialFrom']??''}}" name="m_serialFrom" class="form-control" type="text">
                            <label> تا </label><input value="{{$_GET['m_serialTo']??''}}" class="form-control" name="m_serialTo" type="text">

                        </div>

                        <div class="col-md-3">
                            <label>نوع جایزه :</label><input class="form-control" value="{{$_GET['m_prize']??''}}" name="m_prize" type="text">
                        </div>

                        <div class="col-md-3">
                            <label>تاریخ استفاده از :</label><input onclick="showDateTimepicker(this)" id="m_dateFrom" class="form-control" value="{{$_GET['m_dateFrom']??''}}" name="m_dateFrom" type="text">
                            <label> تا </label><input value="{{$_GET['m_dateTo']??''}}" class="form-control" name="m_dateTo" type="text" onclick="showDateTimepicker(this)">
                        </div>


                    </div>
                    <hr>
                </form>
            </div>
            <div class="box-body">
                <h3>کدهای اصلی استفاده شده</h3>

                <table class="table table-hover">
                    <tr style="background-color: #f2f2f2">
                        <th>کد</th>
                        <th>سریال</th>
                        <th>نوع جایزه</th>
                        <th>تاریخ استفاده</th>
                    </tr>
                    @foreach($maincodes as $s)
                        <tr>
                            <td>{{$s->code}}</td>
                            <td>{{$s->serial}}</td>
                            <td>{{$s->prize->name}}</td>
                            <td>{{$s->getPerisanCustomerDate()}}</td>
                        </tr>
                    @endforeach
                </table>
                {{$maincodes->appends($_GET)->links()}}
            </div>
        </div>
    </div>

@endsection