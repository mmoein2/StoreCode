@extends('layout')

@section('css')
    <style>
        th{
            text-align: center;
        }
        td{
            text-align: center;

        }
    </style>
@endsection
@section('css')
@endsection

@section('js')
    <link href="/css/Mh1PersianDatePicker.css" rel="stylesheet">

    <script src="/js/Mh1PersianDatePicker.js"></script>
    <script>
        function showDateTimepicker(t) {
            Mh1PersianDatePicker.Show(t,'{{\Morilog\Jalali\Jalalian::now()->format('Y/m/d')}}'); //parameter1: input, parameter2: today

        }
    </script>
@endsection
@section('content')
    @include('error')
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header">
                    <i class="fa fa-code"></i>
                    <h3 class="box-title">مدیریت جوایز</h3>

                    <!-- tools box -->
                    <!-- <div class="pull-left box-tools">
                        <button type="button" class="btn bg-info btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                    -->

                </div>
                <hr>

                <a href="/prize/create" class="btn btn-primary">ایجاد جایزه</a>
                <h3 >
                    لیست جوایز

                </h3>
                <div class="box-body table-responsive no-padding" >


                    <table class="table table-hover">
                        <thead>
                        <tr style="background-color: rgba(227,227,227,0.28)">
                            <th>نوع</th>
                            <th>امتیاز</th>
                            <th>عملیات</th>
                        </tr>
                        <thead>
                        <tbody>
                        @foreach($prizes as $c)
                            <tr>
                                <td>{{$c->name}}</td>
                                <td>{{$c->score}}</td>
                                <td>
                                    <a href="/prize/edit?id={{$c->id}}" class="btn btn-sm btn-success">ویرایش</a>
                                    <a href="/prize/delete?id={{$c->id}}" class="btn btn-sm btn-danger">حذف</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$prizes->links()}}
                </div>
            </div>
        </div>
    </div>

@endsection