@extends('layout')

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
                    <i class="fa fa-users"></i>
                    <h3 class="box-title">مدیریت مشتریان</h3>

                <hr>

                <h3 >
                    لیست مشتریان
                    <button onclick="command.value=0;searchForm.submit()" class="btn btn-default"><i class="fa fa-search"></i></button>
                    <a href="/customer" class="btn btn-default"><i class="fa fa-close"></i></a>
                </h3>

                    <form autocomplete="off" id="searchForm" action="/customer" method="get">
                        <input type="hidden" id="command" name="command" value="0">
                        <input type="hidden" id="message" name="message" value="0">
                        <input type="hidden" name="sort" value="{{$_GET['sort'] ?? 'desc'}}">
                        <input type="hidden" name="sort_field" value="{{$_GET['sort_field'] ?? 'created_at'}}">

                            <div class="col-md-2">
                                <label>کد :</label><input value="{{$_GET['id']??''}}" name="id" class="form-control" type="text">
                            </div>
                            <div class="col-md-2">
                                <label>شماره همراه :</label><input value="{{$_GET['mobile']??''}}" name="mobile" class="form-control" type="text">
                            </div>

                        <div class="col-md-2">
                            <label>امتیاز کلی :</label><input value="{{$_GET['scoreFrom']??''}}" name="scoreFrom" class="form-control" type="text">
                            <label> تا </label><input value="{{$_GET['scoreTo']??''}}" class="form-control" name="scoreTo" type="text">

                        </div>
                            <div class="col-md-2">
                                <label>امتیاز فعلی :</label><input value="{{$_GET['availableScoreFrom']??''}}" name="availableScoreFrom" class="form-control" type="text">
                                <label> تا </label><input value="{{$_GET['availableScoreTo']??''}}" class="form-control" name="availableScoreTo" type="text">

                            </div>
                        <div class="col-md-2">
                            <label>تاریخ عضویت از :</label><input onclick="showDateTimepicker(this)" id="dateFrom" class="form-control" value="{{$_GET['registrationDateFrom']??''}}" name="registrationDateFrom" type="text">
                            <label> تا </label><input value="{{$_GET['registrationDateTo']??''}}" class="form-control" name="registrationDateTo" type="text" onclick="showDateTimepicker(this)">
                        </div>


                    </form>
                </div>

            <div class="box-body table-responsive no-padding" >

            <div class="col-md-12" style="text-align: left">
                <div class="btn-group">
                    <a class="btn btn-warning" onclick="showModal('message')">ارسال پیامک</a>
                <a class="btn btn-info" onclick="showModal('notification')">ارسال نوتیفیکیشن</a>
                </div>

            </div>

            <table class="table table-hover">
                        <thead>

                        <tr style="background-color: rgba(227,227,227,0.28)">
                            <th>کد مشتری</th>
                            <th>شماره همراه</th>
                            <th>استان</th>
                            <th>شهر</th>
                            <th><a href="#" onclick="sortForm('score')">میزان امتیاز کلی</a></th>
                            <th><a href="#" onclick="sortForm('available_score')">امتیاز فعلی</a></th>
                            <th><a href="#" onclick="sortForm('used_score')">امتیاز مصرف شده</a></th>
                            <th><a href="#" onclick="sortForm('registration_date')">تاریخ عضویت</a></th>
                            <th>امکان ارسال نوتیفیکیشن</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                        <thead>
                        <tbody>
                        @foreach($customers as $c)
                            <tr>
                                <td><a href="/customer/show?id={{$c->id}}">{{$c->id}}</a></td>
                                <td> <a href="/customer/show?id={{$c->id}}"> {{$c->mobile}}</a></td>
                                <td>{{$c->province->name ?? ''}}</td>
                                <td>{{$c->city->name ?? '' }}</td>
                                <td>{{$c->score}}</td>
                                <td>{{$c->score-$c->used_score}}</td>
                                <td>{{$c->used_score}}</td>
                                <td>{{$c->getPersianRegistrationDate()}}</td>
                                <td class="@if($c->play_id!=null)success @else danger @endif">@if($c->play_id!=null) <i class="fa fa-check"></i> @else <i class="fa fa-close"></i>@endif</td>
                                <td class="{{$c->getColorForStatus()}}">{{$c->getStatus()}}</td>
                                <td>
                                    <a href="/customer/delete?id={{$c->id}}" class="btn btn-<?php if($c->status==true){ echo 'danger '; }else{ echo 'success ';}?>btn-sm">@if($c->status==true) غیرفعالسازی @else فعالسازی @endif</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
            </div>
                    {{$customers->links()}}
                </div>
            </div>
    </div>

@endsection



<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4  id="modal_title" class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <textarea id="modal_body" style="width: 100%;height: 110px"></textarea>
            </div>
            <div class="modal-footer">
                <button onclick="message.value=modal_body.value;searchForm.submit()" type="button" class="btn btn-success" data-dismiss="modal">ارسال
                <i class="fa fa-send"></i>
                </button>
            </div>
        </div>

    </div>
</div>


@section('css')
    <style>
        a[href="#"]
        {
            color: #2d31ad;
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
            command.value='';
            searchForm.submit();
        }
        function showModal(c) {

            command.value=c;
            message.value='';
            modal_title.innerHTML=c;
            $('#myModal').modal();

        }
    </script>
@endsection