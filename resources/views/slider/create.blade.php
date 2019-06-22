@extends('layout')

@section('content')
    @include('error')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">ایجاد اسلایدر</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form enctype="multipart/form-data" role="form" method="post" action="/slider">
                    <div class="box-body">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleInputEmail6">تصویر </label>
                            <input name="image" type="file" id="exampleInputEmail6">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail6">لینک </label>
                            <input class="form-control" name="link" type="text" id="exampleInputEmail6">
                        </div>

                    </div>

                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">ارسال</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection