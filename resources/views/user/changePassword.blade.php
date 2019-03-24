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
            <form action="/user/change/password" method="post">
                {{csrf_field()}}

                <div class="box box-info">
                    <div class="box-body">
                        <div class="form-group">
                            <label>رمز عبور جدید</label>
                            <input class="form-control" type="text" name="password">
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