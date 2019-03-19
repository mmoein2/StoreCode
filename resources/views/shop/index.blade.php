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
                    <i class="fa fa-shopping-cart"></i>
                    <h3 class="box-title">مدیریت فروشگاه ها</h3>

                    <a href="/shop/create" class="btn btn-primary" style="margin-right: 10px">ایجاد فروشگاه</a>
                </div>
                <hr>

                <h3 >
                    لیست فروشگاه  ها
                    <button onclick="searchForm.submit()" class="btn btn-default"><i class="fa fa-search"></i></button>
                    <a href="/shop" class="btn btn-default"><i class="fa fa-close"></i></a>
                </h3>

                <div class="box-body" >
                    <form autocomplete="off" id="searchForm" action="/shop" method="get">

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

                    <table class="table table-hover">
                        <thead>
                        <tr style="background-color: rgba(227,227,227,0.28)">
                            <th>کد فروشگاه</th>
                            <th>نام فروشگاه</th>
                            <th>تلفن همراه</th>
                            <th>رده</th>
                            <th>مجموع امتیازات</th>
                            <th>امتیازات مصرف شده</th>
                            <th>تخصیص کد</th>
                            <th>عملیات</th>
                        </tr>
                        <thead>
                        <tbody>
                        @foreach($shops as $c)
                            <tr>
                                <td>{{$c->id}}</td>
                                <td><a href="/shop/show?id={{$c->id}}">{{$c->name}}</a></td>
                                <td>{{$c->mobile}}</td>
                                <td>{{$c->category->name}}</td>
                                <td>{{$c->score}}</td>
                                <td>{{$c->used_score}}</td>
                                <td><a href="/assign?shop_id={{$c->id}}&shop_name={{$c->name}}">تخصیص کد</a></td>
                                <td>
                                    <a href="/shop/edit?id={{$c->id}}" class="btn btn-success btn-sm">ویرایش</a>
                                    <a href="/shop/delete?id={{$c->id}}" class="btn btn-danger btn-sm">حذف</a>
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