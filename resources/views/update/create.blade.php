@extends('layout')

@section('content')
    @include('error')
    <div class="box box-primary">

        <form method="post" action="/update" role="form">
        {{csrf_field()}}
        <!-- /.box-header -->

            <div class="box-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">کد ورژن</label>
                    <input type="number"  name="version_code"   class="form-control" id="exampleInputEmail1">

                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">نام ورژن</label>
                    <input  name="version_name" type="text" class="form-control" id="" >

                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">توضیحات</label>
                    <input  name="new_features"  class="form-control" id="exampleInputEmail1">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">لینک</label>
                    <input  name="link"  class="form-control" id="exampleInputEmail1">
                </div>


            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-success">ذخیره</button>
                <a class="btn btn-primary" href="/update">بازگشت </a>
            </div>
        </form>
    </div>
@endsection