@extends('layout')
@section('content')
    @include('error')
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <form action="/user" method="post">
                {{csrf_field()}}

                <div class="box box-info">
                    <div class="box-body">
                        <div class="form-group">
                            <label>سطح دسترسی</label>
                            <select class="form-control" name="role_id">
                                @foreach($roles as $role)
                                    <option value="{{$role->id}}">{{$role->name_fa}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>نام  کاربر</label>
                            <input class="form-control" type="text" name="email">
                        </div>
                        <div class="form-group">
                            <label>رمز عبور</label>
                            <input class="form-control" type="text" name="password">
                        </div>
                        <div class="form-group">
                            <label>نام  و نام خانوادگی</label>
                            <input class="form-control" type="text" name="name">
                        </div>



                    </div>
                    <div class="form-group">

                        <button class="btn btn-success" type="submit">ثبت</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection