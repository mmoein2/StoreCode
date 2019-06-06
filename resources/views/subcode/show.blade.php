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
                    <label class="title">کد فرعی :</label>
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
                    @if($subcode->shop != null)
                    <a href="/shop?id={{$subcode->shop->id}}">
                    <label>{{$subcode->shop->name ?? ''}}</label>
                    <label>کد </label>
                    <lable>{{$subcode->shop->id ?? ''}}</lable>
                    </a>
                        @endif

                </div>
                <div class="col-md-12" style="direction: rtl;text-align: right">
                    <label class="title">مشخصات مشتری :</label>
                    @if($subcode->customer != null)
                    <a href="/customer/show?id={{$subcode->customer->id}}">
                    <label>{{$subcode->customer->fullname ?? ''}} </label>
                    <label>کد </label>
                    <lable>{{$subcode->customer->id ?? ''}} |</lable>
                    <label> امتیاز کل </label>
                    <lable>{{$subcode->customer->score ?? ''}}</lable>
                    </a>
                        @endif
                </div>
                <hr>
                <div class="col-md-6">
                    <label class="title">تاریخ تحویل به فروشگاه:</label>
                    {{$subcode->getPerisanCustomerDate()}}

                </div>
                <div class="col-md-6">
                    <label class="title">تاریخ فعالسازی توسط مشتری :</label>
                    <label>{{$subcode->getPerisanCustomerDate() ?? ''}}</label>
                    |

                    <label>کد </label>
                    <label>{{$subcode->customer->id ?? ''}}</label>
                    |
                    <label>  ساعت </label>
                    <label>{{$subcode->getCustomerTime() ?? ''}}</label>

                </div>
            </div>
        </div>
    </div>

@endsection