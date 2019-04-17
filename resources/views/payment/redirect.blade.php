<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>پرداخت</title>
</head>
<style>

    .login-box{

        font-family:tahoma;
        height: 100%;
        background-color: #d2d6de;


    }
    html
    {
        background-color: #d2d6de;

    }

</style>
<link rel="stylesheet" href="/css/app.css" />

<body>
<div class="login-box" style="width: 100%;height: 100%">
<div class="login-box-body" style="text-align: center;background-color: #d2d6de;margin-top: 10%">
    <h3 @if($state=="OK") style="color: green" @else style="color: #df7617" @endif>
        با موفقیت پرداخت شد
        {{$message}}
    </h3>
    <a href="intent://{{$state}}#Intent;scheme={{env('SCHEME')}};package={{env('ANDROID_PACKEAGE')}};end" class="btn btn-primary" style="margin-top: 30px;font-size: 16px">
        بازگشت به اپلیکیشن
    </a>

</div>
</div>
</body>
</html>
