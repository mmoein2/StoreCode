<?php
/**
 * Created by PhpStorm.
 * User: moein
 * Date: 4/16/19
 * Time: 6:48 PM
 */

namespace App\Utility;


class SamanPayment
{
    public static function getError($res_code)
    {
        switch($res_code)
        {
            case '-1':$prompt="خطا درپردازش اطلاعات ارسالی";break;
            case '-3':$prompt="ورودی حاوی کارکترهای غیرمجاز";break;
            case '-4':$prompt="کلمه عبور یا کد فروشنده اشتباه است";break;
            case '-6':$prompt="سند قبلا برگشت کامل یافته است یا خارج از زمان ۳۰ دقیقه ارسال شده است";break;
            case '-7':$prompt="رسید دیجیتال خالی است";break;
            case '-8':$prompt="طول ورودی بیشتر از حد مجاز است";break;
            case '-9':$prompt="وجود کاراکترهای غیرمجاز در مبلغ بازگشتی";break;
            case '-10':$prompt="رسید دیجیتال بصورت Base64 نیست";break;
            case '-11':$prompt="طول ورودی ها کمتر از حد مجاز است";break;
            case '-12':$prompt="مبلغ برگشتی منفی است";break;
            case '-13':$prompt="مبلغ برگشتی برای برگشت جزئی بیش از مبلغ برگشت خورده ی رسید دیجیتال است";break;
            case '-14':$prompt="چنین تراکنشی تعریف نشده است";break;
            case '-15':$prompt="مبلغ برگشتی بصورت اعشاری داده شده است";break;
            case '-16':$prompt="خطای داخلی سیستم";break;
            case '-17':$prompt="برگشت زدن جزیی تراکنش مجاز نمیباشد";break;
            case '-18':$prompt="ای پی سرور فروشنده نامعتبر است";break;
            default:$prompt="خطاي نامشخص";
        }
        return $prompt;
    }

    public static function getState($state)
    {
        switch($state)
        {
            case "OK":
                $prompt = "پرداخت با موفقیت انجام شده";
                break;
            case "Canceled By User":
                $prompt = "تراكنش توسط خريدار كنسل شده است";
                break;
            case "Invalid Amount":
                $prompt = "مبلغ سند برگشتی، از مبلغ تراکنش اصلی بیشتر است";
                break;
            case "Invalid Transaction":
                $prompt = "درخواست برگشت یک تراکنش رسیده است ، درحالی که تراکنش اصلی پیدا نمی شود";
                break;
            case "Invalid Card Number":
                $prompt = "شماره کارت نامعتیر است";
                break;
            case "No Such Issuer":
                $prompt = "چنین صادر کننده کارتی وجود ندارد";
                break;
            case "Expired Card Pick Up":
                $prompt = "از تاریخ انقضای کارت گذشته است و کارت دیگر معتبر نیست";
                break;
            case "Allowable PIN Tries Exceeded Pick Up":
                $prompt = "رمز کارت 3 مرتبه اشتباه وارد شده است و در نتیجه کارت غیر فعال خواهد شد";
                break;
            case "Incorrect PIN":
                $prompt = "خریدار رمز کارت را اشتباه وارد کرده است";
                break;
            case "Exceeds Withdrawal Amount Limit":
                $prompt = "مبلغ بیش از سقف برداشت می باشد";
                break;
            case "Transaction Cannot Be Completed":
                $prompt = "تراکنش Authorize شده است (شماره PIN و PAN درست هست) ولی امکان سند خوردن وجود ندارد";
                break;
            case "Response Received Too Late":
                $prompt = "تراکنش در شبکه بانکی Timeout خورده است";
                break;
            case "Suspected Fraud Pick Up":
                $prompt = "خریدار یا فیلد CVV2 و یا فیلد ExpDate را اشتباه وارد کرده است (یا اصلا وارد نکرده است)";
                break;
            case "No Sufficient Funds":
                $prompt = "موجودی حساب خریدار، کافی نیست";
                break;
            case "Issuer Down Slm":
                $prompt = "سیستم بانک صادر کننده کارت خریدار، در وضعیت عملیاتی نیست";
                break;
            case "TME Error":
                $prompt = "کلیه خطاهای دیگر بانک باعث ایجاد چنین خطایی می گردد";
                break;

            default:$prompt="خطاي نامشخص";
        }
        return $prompt;
    }
}