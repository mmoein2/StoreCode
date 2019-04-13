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
                <form role="form" action="/shop" method="post">
                    {{csrf_field()}}
{{method_field('PATCH')}}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="">انتخاب رده</label>
                            <select name="shop_category_id" class="form-control" style="height: 35px">
                                @foreach($shop_categories as $c)
                                    <option value="{{$c->id}}" @if(isset($_GET['category_id'])&& $c->id==$_GET['category_id']) selected @endif>
                                        {{$c->name}}
                                    </option>
                                @endforeach
                            </select>
                            <button data-toggle="modal" data-target="#myModal"  type="button" style=";float: left;margin-top: 5px" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></button>
                        </div>
                        <input type="hidden" value="{{$shop->id}}" name="id">

                        <div style="margin-top: 10px" class="form-group">
                            <label for="">نام فروشگاه</label>
                            <input value="{{$shop->name}}" name="name"  class="form-control" id="exampleInputEmail1">
                        </div>
                        <div class="form-group">
                            <label for="">موبایل</label>
                            <input value="{{$shop->mobile}}" name="mobile" class="form-control" id="exampleInputPassword1" >
                        </div>
                        <div class="form-group">
                            <label for="">تلفن</label>
                            <input value="{{$shop->phone}}" name="phone" class="form-control" id="exampleInputPassword1" >
                        </div>
                        <div class="form-group">
                            <label for="">متصدی</label>
                            <input value="{{$shop->person}}" name="person"  class="form-control" id="exampleInputPassword1" >
                        </div>
                        <div class="form-group">
                            <label for="">استان</label>
                            <select id="province" class="form-control" style="height: 50px" onchange="province_id.value=(this.value);provice_form.submit();">
                                <option>انتخاب کنید</option>

                                @foreach($provinces as $p)
                                    <option value="{{$p->id}}"  @if(isset($_GET['province_id'])) @if($_GET['province_id']==$p->id) selected  @endif @elseif($shop->province_id==$p->id) selected @endif>
                                        {{$p->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">شهر</label>
                            <select name="city_id" class="form-control" style="height: 50px;">
                                <option selected>انتخاب کنید</option>
                                @foreach($cities as $c)
                                    <option value="{{$c->id}}" @if($c->id==$shop->city_id) selected @endif>
                                        {{$c->name}}
                                    </option>
                                @endforeach

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">آدرس</label>
                            <textarea  class="form-control" style="height: 200px" name="address">{{$shop->address}}</textarea>
                        </div>

                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit"  class="btn btn-success">تخصیص کد</button>
                    </div>
                </form>
                <form name="provice_form" action="/shop/edit" method="get">
                    <input type="hidden" name="id" value="{{$shop->id}}">
                    <input id="province_id" type="hidden" name="province_id" value="">
                </form>
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection
