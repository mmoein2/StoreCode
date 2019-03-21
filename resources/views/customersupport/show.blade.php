@extends('layout')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">

                </div>
                <div class="box-body">


                    <div style="margin-top: 10px" class="form-group">
                        <label for="">تاریخ ارسال</label>
                        <p>{{$customer->getPersianCreatedAt()}}</p>
                    </div>
                    <div style="margin-top: 10px" class="form-group">
                        <label for="">عنوان پیام</label>
                        <p>{{$customer->title}}</p>
                    </div>

                    <div style="margin-top: 10px" class="form-group">
                        <label for="">متن پیام</label>
                        <p>{{$customer->text}}</p>
                    </div>
                    <div style="margin-top: 10px" class="form-group">
                        <label for="">نام و نام خانوادگی</label>
                        <p>{{$customer->customer->fullname}}</p>
                    </div>
                    <div style="margin-top: 10px" class="form-group">
                        <label for="">شماره تماس</label>
                        <p>{{$customer->customer->mobile}}</p>
                    </div>

                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <a href="{{back()->getTargetUrl()}}" class="btn btn-primary">بازگشت</a>
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection
