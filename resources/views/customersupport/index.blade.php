@extends('layout')

@section('content')
    @include('error')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header">
                    <i class="fa fa-code"></i>
                    <h3 class="box-title">پشتیبانی پیام های کاربران</h3>

                    <!-- tools box -->
                    <!-- <div class="pull-left box-tools">
                        <button type="button" class="btn bg-info btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                    -->

                    <hr>

                    <h3 >
                        لیست پیام های کاربران
                        <button onclick="searchForm.submit()" class="btn btn-default"><i class="fa fa-search"></i></button>
                        <a href="/customersupport" class="btn btn-default"><i class="fa fa-close"></i></a>
                    </h3>
                    <form autocomplete="off" id="searchForm" action="/customersupport" method="get">

                        <div class="row" style="margin: 10px">
                            <div class="col-md-4">
                                <label>عنوان :</label><input value="{{$_GET['title']??''}}" name="title" class="form-control" type="text">
                            </div>


                            <div class="col-md-4">
                                <label>مشتری:</label><input  class="form-control" value="{{$_GET['customer_name']??''}}" name="customer_name" type="text">
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
                                <th>نام مشتری</th>
                                <th>تاریخ ارسال</th>
                                <th>وضعیت</th>
                                <th>عملیات</th>
                            </tr>
                            <thead>
                            <tbody>
                            @foreach($customer as $c)
                                <tr>
                                    <td>{{$c->title}}</td>
                                    <td>
                                       <a href="/customer/show?id={{$c->customer->id}}"> {{$c->customer->fullname}}</a>
                                    </td>
                                    <td>{{$c->getPersianCreatedAt()}}</td>
                                    <td class="{{$c->getColorForStatus()}}">{{$c->getStatus()}}</td>
                                    <td><a class="btn btn-sm btn-success" href="/customersupport/show?id={{$c->id}}">مشاهده</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{$customer->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection