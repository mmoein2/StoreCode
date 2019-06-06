@extends('layout')
@section('js')
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
@section('css')
    <style>
        a[href="#"]
        {
            color: #2d31ad;
        }
    </style>
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
                    <i class="fa fa-shopping-cart"></i>
                    <h3 class="box-title">مدیریت فروشگاه ها</h3>

                    <a href="/shop/create" class="btn btn-primary" style="margin-right: 10px">ایجاد فروشگاه</a>
                <hr>

                <h3 >
                    لیست فروشگاه  ها
                    <button onclick="command.value=0;searchForm.submit()" class="btn btn-default"><i class="fa fa-search"></i></button>
                    <a href="/shop" class="btn btn-default"><i class="fa fa-close"></i></a>
                </h3>

                    <form autocomplete="off" id="searchForm" action="/shop" method="get">
                        <input type="hidden" id="command" name="command" value="0">
                        <input type="hidden" id="message" name="message" value="0">
                        <input type="hidden" name="sort" value="{{$_GET['sort'] ?? ''}}">
                        <input type="hidden" name="sort_field" value="{{$_GET['sort_field'] ?? ''}}">
                        <div class="row" style="margin: 10px">
                            <div class="col-md-2">
                                <label> رده : </label>
                                <select name="category_id" class="form-control" style="height: 35px">
                                    <option value="0">
                                        انتخاب کنید
                                    </option>
                                    @foreach($shop_categories as $c)
                                        <option value="{{$c->id}}" @if(isset($_GET['category_id'])&& $c->id==$_GET['category_id']) selected @endif>
                                            {{$c->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label>کد :</label><input value="{{$_GET['id']??''}}" name="id" class="form-control" type="text">
                            </div>
                            <div class="col-md-2">
                                <label>نام فروشگاه :</label><input value="{{$_GET['name']??''}}" name="name" class="form-control" type="text">
                            </div>
                                <div class="col-md-2">
                                    <label>تلفن همراه :</label><input value="{{$_GET['mobile']??''}}" name="mobile" class="form-control" type="text">
                                </div>
                            <div class="col-md-2">
                                <label>مجموع امتیازات از :</label><input value="{{$_GET['scoreFrom']??''}}" name="scoreFrom" class="form-control" type="text">
                                <label> تا </label><input value="{{$_GET['scoreTo']??''}}" class="form-control" name="scoreTo" type="text">

                            </div>

                            <div class="col-md-2">
                                <label>امتیازات مصرف شده از :</label><input  class="form-control" value="{{$_GET['usedscoreFrom']??''}}" name="usedscoreFrom" type="text">
                                <label> تا </label><input value="{{$_GET['usedscoreTo']??''}}" class="form-control" name="usedscoreTo" type="text" >
                            </div>
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
                            <th>ردیف</th>
                            <th>نام فروشگاه</th>
                            <th>استان</th>
                            <th>شهر</th>
                            <th>تلفن همراه</th>
                            <th>رده</th>
                            <th><a href="#" onclick="sortForm('score')">مجموع امتیازات</a></th>
                            <th><a href="#" onclick="sortForm('used_score')">امتیازات مصرف شده</a></th>
                            <th>پیامک رمز عبور</th>
                            <th>تخصیص کد</th>
                            <th>امکان ارسال نوتیفیکیشن</th>
                            <th>عملیات</th>
                        </tr>
                        <thead>
                        <tbody>
                        @foreach($shops as $c)
                            <tr>
                                <td>{{$c->id}}</td>
                                <td><a href="/shop/show?id={{$c->id}}">{{$c->name}}</a></td>
                                <td>{{$c->province->name ?? ''}}</td>
                                <td>{{$c->city->name ?? ''}}</td>
                                <td>{{$c->mobile}}</td>
                                <td>{{$c->category->name}}</td>
                                <td>{{$c->score}}</td>
                                <td>{{$c->used_score}}</td>
                                <td><a href="/shop/password/sms?id={{$c->id}}" class="btn btn-sm btn-success"><i class="fa fa-send"></i></a></td>
                                <td><a href="/assign?shop_id={{$c->id}}&shop_name={{$c->name}}">تخصیص کد</a></td>
                                <td class="@if($c->play_id!=null)success @else danger @endif">@if($c->play_id!=null) <i class="fa fa-check"></i> @else <i class="fa fa-close"></i>@endif</td>
                                <td>
                                    <div class="btn-group">
                                    <a href="/shop/detail?id={{$c->id}}" class="btn btn-primary btn-sm">جزپیات</a>
                                        @can('edit-shop')
                                    <a href="/shop/edit?id={{$c->id}}" class="btn btn-success btn-sm">ویرایش</a>
                                        @endcan
                                    <a href="/shop/delete?id={{$c->id}}" class="btn btn-danger btn-sm">حذف</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$shops->links()}}
                </div>
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
