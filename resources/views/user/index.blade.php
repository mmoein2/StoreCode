@extends('layout')
@section('content')
    <style>
        th{
            text-align: center;
        }
        td{

            text-align: center;
        }
    </style>
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
                    <div class="box-header">
                        <a href="/user/create" class="btn btn-success">
                            ایجاد کاربر
                        </a>
                    </div>
                    <div class="box-body">

                        <table class="table table-hover">
                            <thead>
                            <tr style="background-color: rgba(227,227,227,0.28)">
                            <th>نام کاربری</th>
                                <th>نام</th>
                            <th>سطح دسترسی</th>
                                <th>عملیات</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->role->name_fa}}</td>
                                    <td>
                                        <a class="btn btn-sm btn-danger" href="/user/delete?id={{$user->id}}">
                                            حذف
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>


                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection