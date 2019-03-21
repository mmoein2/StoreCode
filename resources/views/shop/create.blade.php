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


                        <div style="margin-top: 10px" class="form-group">
                            <label for="">نام فروشگاه</label>
                            <input name="name"  class="form-control" id="exampleInputEmail1">
                        </div>
                        <div class="form-group">
                            <label for="">موبایل</label>
                            <input name="mobile" class="form-control" id="exampleInputPassword1" >
                        </div>
                        <div class="form-group">
                            <label for="">تلفن</label>
                            <input name="phone" class="form-control" id="exampleInputPassword1" >
                        </div>
                        <div class="form-group">
                            <label for="">متصدی</label>
                            <input name="person"  class="form-control" id="exampleInputPassword1" >
                        </div>
                        <div class="form-group">
                            <label for="">شهر</label>
                            <input name="city"  class="form-control" id="exampleInputPassword1" >
                        </div>
                        <div class="form-group">
                            <label for="">آدرس</label>
                            <textarea class="form-control" style="height: 200px" name="address"></textarea>
                        </div>

                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit"  class="btn btn-success">ثبت فروشگاه</button>
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">افزودن / حذف دسته بندی</h4>
            </div>
            <div class="modal-body">
                <form autocomplete="off" action="/shop/category/modify" method="post" id="modalForm">
                    {{csrf_field()}}
                <div class="form-group">
                    <label>نام دسته بندی</label>
                    <input type="hidden" id="command" name="command">
                    <input list="category_list" name="name" type="text" class="form-control">
                    <datalist id="category_list">

                        @foreach($shop_categories as $c)
                            <option value="{{$c->name}}">

                            </option>


                        @endforeach

                    </datalist>
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="command.value='register';modalForm.submit();" class="btn btn-success">ثبت</button>
                <button type="button" onclick="command.value='delete';modalForm.submit();" class="btn btn-danger">حذف</button>
            </div>
        </div>

    </div>
</div>