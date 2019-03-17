@extends('layout')

@section('css')
    <style>
        th{
            text-align: center;
        }
        td{
            text-align: center;

        }
    </style>
@endsection
@section('css')
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
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header">
                <i class="fa fa-code"></i>
                <h3 class="box-title">مدیریت کدهای فرعی</h3>
                <div style="margin-top: 20px">
                    <form enctype="multipart/form-data" method="post" action="/subcode">
                        {{csrf_field()}}
                    <label >وارد گردن اطلاعات</label>
                        <a href="/subcode/excel" style="margin-right: 5px"  class="btn btn-success" ><i class="fa fa-file-excel-o"></i></a>
                        <button type="button" style="margin-right: 5px" id="btnUpload" class="btn btn-danger" onclick="fileUpload.click()"><i class="fa fa-upload"></i></button>
                    <input name="file" id="fileUpload" type="file" onchange="btnUpload.classList.remove('btn-danger')" style="display: none">
                        <input type="text" placeholder="تعداد روزهای معتبر" name="day" class="from-control">
                    <button type="submit" style="margin-right: 2px" class="btn btn-primary">ارسال اطلاعات</button>
                    </form>
                </div>
                <!-- tools box -->
                <!-- <div class="pull-left box-tools">
                    <button type="button" class="btn bg-info btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
                -->

            </div>
            <hr>

            <h3 >
                لیست کد ها
                <button onclick="searchForm.submit()" class="btn btn-default"><i class="fa fa-search"></i></button>
                <a href="/subcode" class="btn btn-default"><i class="fa fa-close"></i></a>
            </h3>
            <div class="box-body" >
                <form autocomplete="off" id="searchForm" action="/subcode" method="get">

                <div class="row" style="margin: 10px">
                    <div class="col-md-3">
                        <label>کد :</label><input value="{{$_GET['code']??''}}" name="code" class="form-control" type="text">
                    </div>
                    <div class="col-md-3">
                        <label>سریال از :</label><input value="{{$_GET['serialFrom']??''}}" name="serialFrom" class="form-control" type="text">
                        <label> تا </label><input value="{{$_GET['serialTo']??''}}" class="form-control" name="serialTo" type="text">

                    </div>
                    <div class="col-md-3">
                        <label> وضعیت </label>
                        <select name="status" class="form-control">
                            <option value="0" @if(isset($_GET['status'])&&$_GET['status']==0) selected @endif>
انتخاب کنید
                            </option>
                            <option value="-1" @if(isset($_GET['status'])&&$_GET['status']==-1) selected @endif>
                                استفاده نشده
                            </option>
                            <option value="1" @if(isset($_GET['status'])&&$_GET['status']==1) selected @endif>
در اختیار فروشگاه
                            </option>
                            <option value="2" @if(isset($_GET['status'])&&$_GET['status']==2) selected @endif>
استفاده شده توسط مشتری
                            </option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>تاریخ انقضا از :</label><input onclick="showDateTimepicker(this)" id="dateFrom" class="form-control" value="{{$_GET['dateFrom']??''}}" name="dateFrom" type="text">
                        <label> تا </label><input value="{{$_GET['dateTo']??''}}" class="form-control" name="dateTo" type="text" onclick="showDateTimepicker(this)">
                    </div>
                </div>
            </form>

            <table class="table table-hover">
                    <thead>
                    <tr style="background-color: rgba(227,227,227,0.28)">
                        <th>کد فرعی</th>
                        <th>سریال</th>
                        <th>امتیاز</th>
                        <th>وضعیت</th>
                        <th>تاریخ انقضا</th>
                    </tr>
                    <thead>
<tbody>
                    @foreach($codes as $c)
                    <tr>
                        <td>{{$c->code}}</td>
                        <td>{{$c->serial}}</td>
                        <td>{{$c->score}}</td>
                        <td class="{{$c->getColorForStatus()}}">{{$c->getStatus()}}</td>
                        <td>{{$c->getPerisanExpireDate()}}</td>
                    </tr>
                   @endforeach
                    </tbody>
                </table>
                {{$codes->links()}}
            </div>
        </div>
    </div>
</div>

@endsection