@extends('layout')

@section('content')
    @include('error')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header">
                    <i class="fa fa-code"></i>
                    <h3 class="box-title">مدیریت پیام ها</h3>

                    <!-- tools box -->
                    <!-- <div class="pull-left box-tools">
                        <button type="button" class="btn bg-info btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                    -->

                    <hr>

                    <h3 >
                        لیست پیام ها
                        <button onclick="searchForm.submit()" class="btn btn-default"><i class="fa fa-search"></i></button>
                        <a href="/message" class="btn btn-default"><i class="fa fa-close"></i></a>
                    </h3>
                    <form autocomplete="off" id="searchForm" action="/message" method="get">

                        <div class="row" style="margin: 10px">
                            <div class="col-md-4">
                                <label>عنوان :</label><input value="{{$_GET['title']??''}}" name="title" class="form-control" type="text">
                            </div>


                            <div class="col-md-4">
                                <label>فروشگاه:</label><input  class="form-control" value="{{$_GET['shop_name']??''}}" name="shop_name" type="text">
                            </div>
                            <div class="col-md-4">
                                <label>وضعیت:</label>
                                <select class="form-control" name="status">
                                    <option value="0"  @if(isset($_GET['status'])&&$_GET['status']==0) selected @endif> همه موارد</option>
                                    <option value="1"  @if(isset($_GET['status'])&&$_GET['status']==1) selected @endif> مشاهده شده</option>
                                    <option value="-1" @if(isset($_GET['status'])&&$_GET['status']==-1) selected @endif>مشاهده نشده </option>
                                </select>
                            </div>
                        </div>
                    </form>
                    <div class="box-body table-responsive no-padding" >

                        <table class="table table-hover">
                            <thead>
                            <tr style="background-color: rgba(227,227,227,0.28)">
                                <th>عنوان</th>
                                <th>نام فروشگاه</th>
                                <th>تاریخ ارسال</th>
                                <th>وضعیت</th>
                                <th>عملیات</th>
                            </tr>
                            <thead>
                            <tbody>
                            @foreach($messages as $c)
                                <tr>
                                    <td>{{$c->title}}</td>
                                    <td>{{$c->shop->name}}</td>
                                    <td>{{$c->getPersianCreatedAt()}}</td>
                                    <td class="{{$c->getColorForStatus()}}">{{$c->getStatus()}}</td>
                                    <td><a class="btn btn-sm btn-success" href="/message/show?id={{$c->id}}">مشاهده</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{$messages->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection