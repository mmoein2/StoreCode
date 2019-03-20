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
                            <p>{{$message->getPersianCreatedAt()}}</p>
                        </div>
                        <div style="margin-top: 10px" class="form-group">
                            <label for="">عنوان پیام</label>
                            <p>{{$message->title}}</p>
                        </div>

                        <div style="margin-top: 10px" class="form-group">
                            <label for="">متن پیام</label>
                            <p>{{$message->text}}</p>
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
