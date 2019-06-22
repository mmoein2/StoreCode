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
                    <h3 class="box-title">تایید ارسال پیامک یا نوتیفیکیشن</h3>


                </div>
                <hr>


                <h3 >
                    لیست

                </h3>
                <div class="box-body table-responsive no-padding" >


                    <table class="table table-hover">
                        <thead>
                        <tr style="background-color: rgba(227,227,227,0.28)">
                            <th>نوع</th>
                            <th>تعداد</th>
                            <th>عملیات</th>
                        </tr>
                        <thead>
                        <tbody>
                        @foreach($data as $c)
                            <tr>
                                <td>@if($c->type==1) <span>نوتیفیکشن</span> @else <span>پیامک</span> @endif</td>
                                <td>{{\App\NotiOrMessageMember::where('noti_or_message_id',$c->id)->count()}}</td>
                                <td>@if($c->type==1) <span>نوتیفیکشن</span> @else <span>پیامک</span> @endif</td>

                                <td>
                                    @if($c->status==1)<a href="notiORmessage/verify/{{$c->id}}" class="btn btn-sm btn-success">تایید</a>
                                        @elseif ($c->status==0)
                                    <label>پرداخت نشده</label>

                                    @elseif ($c->status==2)
                                        <label style="color: green">تایید شده</label>

                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$data->links()}}
                </div>
            </div>
        </div>
    </div>

@endsection