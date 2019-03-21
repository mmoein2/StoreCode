@extends('layout')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">اسلایدر</h3>
                    <div style="margin-top:10px ">
                        <a href="slider/create" class="btn btn-sm btn-success">
                            ایجاد اسلایدر
                        </a>
                    </div>

                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    @foreach($sliders as $s)
                        <div class="col-md-3">
                            <img src="{{$s->image_address}}" style="width: 100%;height: 250px">
                            <a href="/slider/delete/{{$s->id}}" style="width: 100%" class="btn btn-danger">حذف</a>
                        </div>
                    @endforeach

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection