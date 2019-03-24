@extends('layout')

@section('content')
    @include('error')
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">

                </div>
                    <div class="box-body">

                        <div style="margin-top: 10px" class="form-group">
                            <label for="">نام فروشگاه</label>
                            <input value="{{$shop->category->name}}"  class="form-control" id="exampleInputEmail1" readonly>
                        </div>
                        <div style="margin-top: 10px" class="form-group">
                            <label for="">نام فروشگاه</label>
                            <input value="{{$shop->name}}"  class="form-control" id="exampleInputEmail1" readonly>
                        </div>
                        <div class="form-group">
                            <label for="">موبایل</label>
                            <input value="{{$shop->mobile}}" class="form-control" id="exampleInputPassword1" readonly>
                        </div>
                        <div class="form-group">
                            <label for="">تلفن</label>
                            <input value="{{$shop->phone}}" class="form-control" id="exampleInputPassword1" readonly>
                        </div>
                        <div class="form-group">
                            <label for="">متصدی</label>
                            <input value="{{$shop->person}}"  class="form-control" id="exampleInputPassword1" readonly>
                        </div>
                        <div class="form-group">
                            <label for="">شهر</label>
                            <input value="{{$shop->city}}"  class="form-control" id="exampleInputPassword1" readonly>
                        </div>
                        <div class="form-group">
                            <label for="">آدرس</label>
                            <textarea class="form-control" style="height: 200px" name="address" readonly>{{$shop->address}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="">توضیحات</label>
                            <textarea class="form-control" style="height: 200px" name="address" readonly>{{$shop->desc}}</textarea>
                        </div>
                        <div class="row">
                        @foreach($shop->images as $key=>$img)
                                <div class="col-md-3">
                                    <label for="">عکس  {{$key}}</label>
                                    <a href="{{$img}}" target="_blank"><img src="{{$img}}" style="width: 100%;height: 300px"></a>
                                </div>
                        @endforeach
                        </div>

                    </div>
                  
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection
