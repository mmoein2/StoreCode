@extends('layout')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    @include('error')
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="/post/amount" method="post">
                    {{csrf_field()}}

                    <div class="box-body">


                        <div style="margin-top: 10px" class="form-group">
                            <label for="">مبلغ پست ویژه</label>
                            <br>
                            <input style="width: 90%;float: right;margin-left: 10px" name="amount" value="{{$setting->special_post_amount ??''}}"  class="form-control"  id="exampleInputEmail1">
                            <label>تومان</label>
                        </div>



                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit"  class="btn btn-success">ثبت</button>
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection