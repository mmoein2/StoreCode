@extends('layout')

@section('css')
    <style>
        th{
            text-align: center;
        }
        td{
            text-align: center;

        }
        a[href="#"]
        {
            color: #2d31ad;
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
    <script>
        function sortForm(field) {

            document.getElementsByName('sort_field')[0].value=field;
            var d = document.getElementsByName('sort')[0];
            if(d.value=="desc")
            {
                d.value="asc";
            }
            else
            {
                d.value="desc";

            }
            searchForm.submit();
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
                    <h3 class="box-title">مدیریت کدهای اصلی</h3>
                    <div style="margin-top: 20px">
                        <form enctype="multipart/form-data" method="post" action="/maincode">
                            {{csrf_field()}}
                            <label >وارد گردن اطلاعات</label>
                            <a href="/maincode/excel" style="margin-right: 5px"  class="btn btn-success" ><i class="fa fa-file-excel-o"></i></a>
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

                <hr>

                <h3 >
                    لیست کد ها
                    <button onclick="searchForm.submit()" class="btn btn-default"><i class="fa fa-search"></i></button>
                    <a href="/maincode" class="btn btn-default"><i class="fa fa-close"></i></a>
                </h3>
                    <form autocomplete="off" id="searchForm" action="/maincode" method="get">
                        <input type="hidden" name="sort" value="{{$_GET['sort'] ?? 'desc'}}">
                        <input type="hidden" name="sort_field" value="{{$_GET['sort_field'] ?? 'code'}}">
                        <div class="row" style="margin: 10px">
                            <div class="col-md-2">
                                <label>کد :</label><input value="{{$_GET['code']??''}}" name="code" class="form-control" type="text">
                            </div>
                            <div class="col-md-2">
                                <label>سریال از :</label><input value="{{$_GET['serialFrom']??''}}" name="serialFrom" class="form-control" type="text">
                                <label> تا </label><input value="{{$_GET['serialTo']??''}}" class="form-control" name="serialTo" type="text">

                            </div>

                            <div class="col-md-2">
                                <label>نوع جوایز</label>
                                <select name="prize" class="form-control">
                                    <option value="0" @if(isset($_GET['prize'])&&$_GET['prize']==0) selected @endif>
                                        انتخاب کنید
                                    </option>
                                    @foreach($prizes as $p)
                                        <option value="{{$p->name}}" @if(isset($_GET['prize'])&&$_GET['prize']==$p->id) selected @endif>
                                            {{$p->name}}
                                        </option>
                                    @endforeach


                                </select>
                            </div>

                            <div class="col-md-2">
                                <label> وضعیت </label>
                                <select name="status" class="form-control">
                                    <option value="0" @if(isset($_GET['status'])&&$_GET['status']==0) selected @endif>
                                        انتخاب کنید
                                    </option>
                                    <option value="1" @if(isset($_GET['status'])&&$_GET['status']==1) selected @endif>
                                        استفاده نشده
                                    </option>
                                    <option value="2" @if(isset($_GET['status'])&&$_GET['status']==2) selected @endif>
                                        مصرف شده
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label>تاریخ انقضا از :</label><input onclick="showDateTimepicker(this)" id="dateFrom" class="form-control" value="{{$_GET['dateFrom']??''}}" name="dateFrom" type="text">
                                <label> تا </label><input value="{{$_GET['dateTo']??''}}" class="form-control" name="dateTo" type="text" onclick="showDateTimepicker(this)">
                            </div>
                        </div>
                    </form>
                <div class="box-body table-responsive no-padding" >

                    <table class="table table-hover">
                        <thead>
                        <tr style="background-color: rgba(227,227,227,0.28)">
                            <th><a href="#" onclick="sortForm('code')">کد اصلی</a></th>
                            <th><a href="#" onclick="sortForm('serial')">سریال</a></th>
                            <th><a href="#" onclick="sortForm('score')">امتیاز</a></th>
                            <th>نوع جوایز</th>
                            <th>وضعیت</th>
                            <th><a href="#" onclick="sortForm('expiration_day')">اعتبار کد (روز)</a></th>
                            <th><a href="#" onclick="sortForm('expiration_date')">تاریخ انقضا</a></th>
                            <th>عملیات</th>
                        </tr>
                        <thead>
                        <tbody>
                        @foreach($codes as $c)
                            <tr>
                                <td><a href="/maincode/show?id={{$c->id}}"> {{$c->code}} </a></td>
                                <td>{{$c->serial}}</td>
                                <td>{{$c->score}}</td>
                                <td>
                                    @if($c->status==false)
                                        {{$c->prize->name}}
                                        @else
                                    {{$c->prize_name}}
                                        @endif
                                </td>
                                <td class="{{$c->getColorForStatus()}}">{{$c->getStatus()}}</td>
                                <td>{{$c->expiration_day}}</td>
                                <td>{{$c->getPerisanExpireDate()}}</td>
                                <td>
                                    @if($c->status==false)
                                        <a class="btn btn-sm btn-danger" href="/maincode/delete?id={{$c->id}}">حذف</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                {{$codes->links()}}
            </div>
        </div>
        </div>
    </div>


@endsection