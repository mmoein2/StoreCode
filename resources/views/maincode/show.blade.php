@extends('layout')

@section('css')
    <style>
        .col-md-6{
            margin-top: 18px;
            font-size: 15px;
        }
        .col-md-4{
            margin-top: 18px;
            font-size: 15px;

        }
        .col-md-2{
            margin-top: 18px;
            font-size: 15px;

        }
        .col-md-12{
            margin-top: 18px;
            font-size: 15px;

        }
        .title
        {
            font-size: 18px;
        }
body
{
    direction: rtl;
}
    </style>
@endsection

@section('content')
    @include('error')
    <div class="row">
        <div class="box">
            <div class="box-header">

                <div class="col-md-6">
                    <label class="title">کد اصلی :</label>
                    {{$maincode->code}}
                </div>
                <div class="col-md-6">
                    <label class="title">نوع :</label>
                    @if($maincode->status==false)
                       <label> {{$maincode->prize->name}}</label>
                    @else
                    </label>{{$maincode->prize_name}}</div>
                    @endif
                </div>


                <div class="col-md-4">
                    <label class="title">سریال :</label>
                    <label>{{$maincode->serial}}</label>
                </div>
                <div class="col-md-4">
                    <label class="title">مدت اعتبار (روز):</label>
                    <label>{{$maincode->expiration_day}}</label>
                    <label> روز پس از فعالسازی </label>
                </div>
                <div class="col-md-4">
                    <label class="title">تاریخ انقضا :</label>
                    <label>{{$maincode->getPerisanExpireDate()}}</label>
                </div>


                <div class="col-md-12">
                    <label class="title">وضعیت :</label>
                    <label>{{$maincode->getStatus()}}</label>
                </div>

                    <hr>


                <div class="col-md-6">
                    <label class="title">مشخصات مشتری :</label>
                    <label>{{$maincode->customer->fullname ??''}}</label>

                </div>

                <div class="col-md-6">
                    <label class="title">کد مشتری: </label>
                    <label>{{$maincode->customer->id ?? ''}}</label>

                </div>
                <hr>
                <div class="col-md-6">
                    <label class="title">تاریخ فعالسازی:</label>
                    <label>{{$maincode->getPerisanCustomerDate() ??''}}</label>

                </div>
                <div class="col-md-6">
                    <label class="title">ساعت فعالسازی :</label>
                    <label>{{$maincode->getCustomerTime() ?? ''}}</label>
                </div>
            </div>
        </div>
    </div>

@endsection