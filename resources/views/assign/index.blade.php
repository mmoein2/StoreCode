@extends('layout')

@section('content')
        @include('error')
<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">تحویل کد به فروشگاه {{$_GET['shop_name']}}</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="/assign" method="post">
                {{csrf_field()}}
                <input type="hidden" value="{{$_GET['shop_id']}}" name="shop_id">
                <div class="box-body">
                    <div class="form-group">
                        <label for="">از سریال</label>
                        <input name="serialFrom" type="number" class="form-control" id="exampleInputEmail1">
                    </div>
                    <div class="form-group">
                        <label for="">تا</label>
                        <input name="serialTo" type="number" class="form-control" id="exampleInputPassword1" >
                    </div>

                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit"  class="btn btn-success">تخصیص کد</button>
                </div>
            </form>
        </div>
        <!-- /.box -->
    </div>
</div>
       @endsection