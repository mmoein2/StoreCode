@extends('layout')
@section('content')


    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <br>
                    <a href="/update/create" class="btn btn-success">
                        ایجاد بروزرسانی
                    </a>
                <div class="box-body table-responsive no-padding">
                    <br>


                    <table class="table table-hover text-center">
                        <tr>
                            <th>کد ورژن</th>
                            <th>نام ورژن</th>
                            <th>تغییرات</th>
                            <th>عملیات</th>
                        </tr>
                        @foreach($updates as $update)
                            <tr>

                                <td>{{$update->version_code}}</td>
                                <td>{{$update->version_name}}</td>
                                <td>{{$update->new_features}}</td>

                                <td>

                                    <div class="btn-group">

                                        <a class="btn btn-danger" href="/update/delete?id={{$update->id}}">حذف</a>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>

                <!-- /.box-body -->
            </div>
            <!-- /.box -->
            </div>
        </div>
        {{$updates->appends($_GET)->links()}}
    </div>


@endsection

