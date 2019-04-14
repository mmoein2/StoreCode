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
            <form action="/maincode/update/all" method="post">

                {{csrf_field()}}
                @foreach($array as $a)
                    <input class="form-control" type="hidden" name="data[]" value="{{$a}}">
                @endforeach
                <div class="box box-info">
                    <div class="box-body">
                        <div class="form-group">
                            <label>اعتبار کد (روز)</label>
                            <input class="form-control" type="text" name="day" value="">
                        </div>
                        <div class="form-group">
                            <label>امتیاز</label>
                            <input class="form-control" type="text" name="score" value="">
                        </div>
                    </div>
                    <div class="form-group">

                        <button class="btn btn-success" type="submit">ثبت</button>
                        <a href="{{back()->getTargetUrl()}}" class="btn btn-danger" type="submit">انصرف</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection