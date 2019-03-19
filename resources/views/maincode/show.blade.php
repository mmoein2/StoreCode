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
                        {{$maincode->prize->name}}
                    @else
                        {{$maincode->prize_name}}
                    @endif
                </div>


                <div class="col-md-4">
                    <label class="title">سریال :</label>
                    {{$maincode->serial}}
                </div>
                <div class="col-md-4">
                    <label class="title">مدت اعتبار (روز):</label>
                    {{$maincode->expiration_day}}
                    <label> روز پس از فعالسازی </label>
                </div>
                <div class="col-md-4">
                    <label class="title">تاریخ انقضا :</label>
                    {{$maincode->getPerisanExpireDate()}}
                </div>


                <div class="col-md-12">
                    <label class="title">وضعیت :</label>
                    {{$maincode->getStatus()}}
                </div>

                    <hr>


                <div class="col-md-6">
                    <label class="title">مشخصات مشتری :</label>
                    {{$maincode->customer->fullname}}

                </div>

                <div class="col-md-6">
                    <label class="title">کد مشتری: </label>
                    {{$maincode->customer->id ?? ''}}

                </div>
                <hr>
                <div class="col-md-6">
                    <label class="title">تاریخ فعالسازی:</label>
                    {{$maincode->getPerisanCustomerDate()}}

                </div>
                <div class="col-md-6">
                    <label class="title">ساعت فعالسازی :</label>
                    {{$maincode->getCustomerTime() ?? ''}}
                </div>
            </div>
        </div>
    </div>

@endsection