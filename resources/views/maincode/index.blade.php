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
        .pure-material-checkbox {
            z-index: 0;
            position: relative;
            display: inline-block;
            color: rgba(var(--pure-material-onsurface-rgb, 0, 0, 0), 0.87);
            font-size: 16px;
            line-height: 1.5;
        }

        /* Input */
        .pure-material-checkbox > input {
            appearance: none;
            -moz-appearance: none;
            -webkit-appearance: none;
            z-index: -1;
            position: absolute;
            left: -10px;
            top: -8px;
            display: block;
            margin: 0;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            background-color: rgba(var(--pure-material-onsurface-rgb, 0, 0, 0), 0.6);
            box-shadow: none;
            outline: none;
            opacity: 0;
            transform: scale(1);
            pointer-events: none;
            transition: opacity 0.3s, transform 0.2s;
        }

        /* Span */
        .pure-material-checkbox > span {
            display: inline-block;
            width: 100%;
            cursor: pointer;
        }

        /* Box */
        .pure-material-checkbox > span::before {
            content: "";
            display: inline-block;
            box-sizing: border-box;
            margin: 3px 11px 3px 1px;
            border: solid 2px; /* Safari */
            border-color: rgba(var(--pure-material-onsurface-rgb, 0, 0, 0), 0.6);
            border-radius: 2px;
            width: 18px;
            height: 18px;
            vertical-align: top;
            transition: border-color 0.2s, background-color 0.2s;
        }

        /* Checkmark */
        .pure-material-checkbox > span::after {
            content: "";
            display: block;
            position: absolute;
            top: 3px;
            left: 1px;
            width: 10px;
            height: 5px;
            border: solid 2px transparent;
            border-right: none;
            border-top: none;
            transform: translate(3px, 4px) rotate(-45deg);
        }

        /* Checked, Indeterminate */
        .pure-material-checkbox > input:checked,
        .pure-material-checkbox > input:indeterminate {
            background-color: rgb(var(--pure-material-primary-rgb, 33, 150, 243));
        }

        .pure-material-checkbox > input:checked + span::before,
        .pure-material-checkbox > input:indeterminate + span::before {
            border-color: rgb(var(--pure-material-primary-rgb, 33, 150, 243));
            background-color: rgb(var(--pure-material-primary-rgb, 33, 150, 243));
        }

        .pure-material-checkbox > input:checked + span::after,
        .pure-material-checkbox > input:indeterminate + span::after {
            border-color: rgb(var(--pure-material-onprimary-rgb, 255, 255, 255));
        }

        .pure-material-checkbox > input:indeterminate + span::after {
            border-left: none;
            transform: translate(4px, 3px);
        }

        /* Hover, Focus */
        .pure-material-checkbox:hover > input {
            opacity: 0.04;
        }

        .pure-material-checkbox > input:focus {
            opacity: 0.12;
        }

        .pure-material-checkbox:hover > input:focus {
            opacity: 0.16;
        }

        /* Active */
        .pure-material-checkbox > input:active {
            opacity: 1;
            transform: scale(0);
            transition: transform 0s, opacity 0s;
        }

        .pure-material-checkbox > input:active + span::before {
            border-color: rgb(var(--pure-material-primary-rgb, 33, 150, 243));
        }

        .pure-material-checkbox > input:checked:active + span::before {
            border-color: transparent;
            background-color: rgba(var(--pure-material-onsurface-rgb, 0, 0, 0), 0.6);
        }

        /* Disabled */
        .pure-material-checkbox > input:disabled {
            opacity: 0;
        }

        .pure-material-checkbox > input:disabled + span {
            color: rgba(var(--pure-material-onsurface-rgb, 0, 0, 0), 0.38);
            cursor: initial;
        }

        .pure-material-checkbox > input:disabled + span::before {
            border-color: currentColor;
        }

        .pure-material-checkbox > input:checked:disabled + span::before,
        .pure-material-checkbox > input:indeterminate:disabled + span::before {
            border-color: transparent;
            background-color: currentColor;
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
                                <label>امتیاز از :</label><input value="{{$_GET['scoreFrom']??''}}" name="scoreFrom" class="form-control" type="text">
                                <label> تا </label><input value="{{$_GET['scoreTo']??''}}" class="form-control" name="scoreTo" type="text">

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
                            <th>
                                @can('edit-maincode')
                                <button onclick="edit_data()" id="edit_button" class="btn btn-sm btn-success" disabled><i class="fa fa-pencil"></i></button>
                                @endcan
                                    @can('delete-maincode')

                                    <button id="delete_button" onclick="delete_data()" class="btn btn-sm btn-danger" disabled><i class="fa fa-close"></i></button>
                                        @endcan
                            </th>
                            <th>ردیف</th>
                            <th><a href="#" onclick="sortForm('code')">کد اصلی</a></th>
                            <th>نام</th>
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
                                <td>
                                    <label class="pure-material-checkbox" style="direction: ltr">
                                        <input type="checkbox" onclick="selectRdf({{$c->id}},this)" @if($c->status==true) disabled @endif >
                                        <span>&nbsp;</span>
                                    </label>
                                </td>
                                <td>{{$c->id}}</td>
                                <td><a href="/maincode/show?id={{$c->id}}"> {{$c->code}} </a></td>
                                <td>{{$c->name??''}}</td>
                                <td>{{$c->serial}}</td>

                                <td>
                                    @if($c->status==false)
                                        {{$c->prize->score}}
                                    @else
                                        {{$c->score}}
                                    @endif



                                </td>
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
                                    @can('delete-maincode')

                                    @if($c->status==false)
                                        <a class="btn btn-sm btn-danger" href="/maincode/delete?id={{$c->id}}">حذف</a>
                                    @endif
                                        @endcan
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
<form action="/maincode/delete/all" method="post" id="delete_form_all">
    <input type="hidden" name="data" id="input_delete_data">
    @csrf
</form>

<form action="/maincode/edit/all" method="post" id="edit_form_all">
    <input type="hidden" name="data" id="input_edit_data">
    @csrf
</form>

<script>
    var data=[];
    function selectRdf(id,item) {

        if(item.checked)
        {
            data.push(id);

        }
        else
        {
            var j=0;
            for(j=0;j<data.length;j++)
            {
                if(data[j]==id)
                {
                    data.splice(j,1);
                    break;
                }
            }
        }
        if(data.length>0)
        {
            document.getElementById("delete_button").disabled=false;
            document.getElementById("edit_button").disabled=false;
        }
        else {
            document.getElementById("delete_button").disabled=true;
            document.getElementById("edit_button").disabled=true;
        }



    }
    function delete_data() {
        input_delete_data.value=data;
        delete_form_all.submit();
    }
    function edit_data() {
        input_edit_data.value=data;
        edit_form_all.submit();
    }


</script>
