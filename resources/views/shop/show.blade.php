@extends('layout')

@section('css')
    <style>
        .col-md-3{
            margin-top: 18px;
            font-size: 15px;
        }
        .col-md-10{
            margin-top: 18px;
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
        a[href="#"]
        {
            color: #2d31ad;
        }
        body
        {
            direction: rtl;
        }
    </style>
    @endsection

@section('content')
    @include('error')
    <div class="row">
        <div class="box">
            <div class="box-header">

                <div class="col-md-3">
                    <label>کد فروشگاه :</label>
                   <label>{{$shop->id}}</label>
                </div>

                <div class="col-md-3">
                    <label>نام فروشگاه :</label>
                    <label> {{$shop->name}}</label>

                </div>
                <div class="col-md-3">
                    <label>صنف فروشگاه :</label>
                    <label>{{$shop->category->name}}</label>

                </div>

                <div class="col-md-3">
                    <label>متصدی فروشگاه :</label>
                    <label> {{$shop->person}}</label>

                </div>

                        <div class="col-md-12">
                            <label>آدرس :</label>
                            <p> {{$shop->address}}</p>

                        </div>
                        <div class="col-md-12">
                            <label>شماره همراه :</label>
                            <label>  {{$shop->mobile}}</label>

                        </div>
                        <div class="col-md-12">
                            <label>شماره تلفن ثابت :</label>
                            <label> {{$shop->phone}}</label>

                        </div>

                        <div class="col-md-12">
                            <label>امتیازات گرفته شده (کل):</label>
                            <label> {{$shop->score}} </label>

                        </div>
                        <div class="col-md-12">
                            <label>امتیازات مصرف شده :</label>
                            <label> {{$shop->used_score}}</label>

                        </div>
                <div class="col-md-12">
                    <label>امتیازات مصرف نشده :</label>
                    <label> {{$shop->score - $shop->used_score}}</label>

                </div>

    <div style="margin-top: 10px">

        <form autocomplete="off" id="searchForm" action="/shop/show" method="get">
            <input type="hidden" name="sort" value="{{$_GET['sort'] ?? 'desc'}}">
            <input type="hidden" name="sort_field" value="{{$_GET['sort_field'] ?? 'code'}}">
            <input type="hidden" name="id" value="{{$shop->id}}">

            <div class="row" style="margin: 10px">
                <div class="col-md-2">
                    <label>کد :</label><input value="{{$_GET['code']??''}}" name="code" class="form-control" type="text">
                </div>
                <div class="col-md-2">
                    <label>سریال از :</label><input value="{{$_GET['serialFrom']??''}}" name="serialFrom" class="form-control" type="text">
                    <label> تا </label><input value="{{$_GET['serialTo']??''}}" class="form-control" name="serialTo" type="text">
                </div>
                <div class="col-md-2">
                    <label>امتیاز از :</label><input value="{{$_GET['scoreFrom']??''}}" name="scoreFrom" class="form-control" type="text">
                    <label> تا </label><input value="{{$_GET['scoreTo']??''}}" class="form-control" name="scoreTo" type="text">
                </div>
                <div class="col-md-2">
                    <label>تاریخ تخصیص از :</label><input onclick="showDateTimepicker(this)" id="dateFrom" class="form-control" value="{{$_GET['shopDateFrom']??''}}" name="shopDateFrom" type="text">
                    <label> تا </label><input value="{{$_GET['shopDateTo']??''}}" class="form-control" name="shopDateTo" type="text" onclick="showDateTimepicker(this)">
                </div>
                <div class="col-md-2">
                    <label> وضعیت </label>
                    <select name="status" class="form-control">
                        <option value="0" @if(isset($_GET['status'])&&$_GET['status']==0) selected @endif>
                            انتخاب کنید
                        </option>

                        <option value="1" @if(isset($_GET['status'])&&$_GET['status']==1) selected @endif>
                            در اختیار فروشگاه
                        </option>
                        <option value="2" @if(isset($_GET['status'])&&$_GET['status']==2) selected @endif>
                            استفاده شده توسط مشتری
                        </option>
                    </select>
                </div>

                <div class="col-md-2" style="padding-top: 25px">
                    <button onclick="searchForm.submit()" class="btn btn-default"><i class="fa fa-search"></i></button>
                    <a href="/shop/show?id={{$shop->id}}" class="btn btn-default"><i class="fa fa-close"></i></a>

                </div>
            </div>
        </form>
    </div>
            </div>

            <div class="box-body table-responsive no-padding">

            <table style="margin-top: 20px" class="table table-hover">
                    <thead>
                    <tr style="background-color: rgba(227,227,227,0.28)">
                        <th> <a href="#" onclick="sortForm('code')">کد فرعی</a></th>
                        <th><a href="#" onclick="sortForm('serial')">سریال</a></th>
                        <th><a href="#" onclick="sortForm('score')">امتیاز</a></th>
                        <th><a href="#" onclick="sortForm('shop_date')">تاریخ تخصیص</a></th>
                        <th>وضعیت</th>
                    </tr>
                    <thead>
                    <tbody>
                    @foreach($codes as $c)
                        <tr>
                            <td>{{$c->code}}</td>
                            <td>{{$c->serial}}</td>
                            <td>{{$c->score}}</td>
                            <td>{{$c->getPerisanShopDate()}}</td>
                            <td class="{{$c->getColorForStatus()}}">{{$c->getStatus()}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
                {{$codes->appends($_GET)->links()}}
</div>
    </div>

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