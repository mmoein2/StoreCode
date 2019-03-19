@extends('layout')

@section('content')
    @include('error')
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">

                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="/prize" method="post">
                    {{csrf_field()}}

                    <div class="box-body">


                        <div style="margin-top: 10px" class="form-group">
                            <label for="">نام جایزه</label>
                            <input name="name"  class="form-control" id="exampleInputEmail1">
                        </div>

                        <div style="margin-top: 10px" class="form-group">
                            <label for="">امتیاز</label>
                            <input name="score"  class="form-control" id="exampleInputEmail1">
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
