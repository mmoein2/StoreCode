@extends('layout')

@section('css')
    <style>
        .col-md-6{
            margin-top: 18px;
            font-size: 15px;
        }
        .col-md-10{
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
                    <label class="title">کد فروشگاه :</label>
                    {{$subcode->code}}
                </div>
                <div class="col-md-6">
                    <label class="title">امتیاز :</label>
                    {{$subcode->score}}
                </div>


                <div class="col-md-6">
                    <label class="title">سریال :</label>
                    {{$subcode->serial}}
                </div>
                <div class="col-md-6">
                    <label class="title">تاریخ انقضا :</label>
                    {{$subcode->getPerisanExpireDate()}}
                </div>

                <div class="col-md-12">
                    <label class="title">وضعیت :</label>
                    {{$subcode->getStatus()}}
                </div>
                <div class="col-md-12">
                    <label class="title">مشخصات فروشگاه :</label>
                    {{$subcode->shop->name ?? ''}}
                    <label>کد </label>
                    {{$subcode->shop->id ?? ''}}

                </div>
                <div class="col-md-12">
                    <label class="title">مشخصات مشتری :</label>
                    {{$subcode->customer->name ?? ''}}
                    <label>کد </label>
                    {{$subcode->customer->id ?? ''}}
                    <label> - امتیاز کل </label>
                    {{$subcode->customer->score ?? ''}}

                </div>
                <hr>
                <div class="col-md-6">
                    <label class="title">تاریخ تحویل به فروشگاه:</label>
                    {{$subcode->getPerisanCustomerDate()}}

                </div>
                <div class="col-md-6">
                    <label class="title">تاریخ فعالسازی توسط مشتری :</label>
                    {{$subcode->getPerisanCustomerDate() ?? ''}}
                    <label>کد </label>
                    {{$subcode->customer->id ?? ''}}
                    <label> - امتیاز کل </label>
                    {{$subcode->getCustomerTime() ?? ''}}

                </div>
            </div>
        </div>
    </div>

@endsection