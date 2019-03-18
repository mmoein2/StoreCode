<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\Jalalian;

class SubCode extends Model
{
    protected $guarded=[];
    public function getPerisanExpireDate()
    {
        if($this->expiration_date==0)
            return "";
        $date = Jalalian::forge($this->expiration_date/1000);
        $y=$date->getYear();
        $m=$date->getMonth();
        $d=$date->getDay();
        return "$y/$m/$d";
    }
    public function getStatus()
    {
        if($this->status==0)
            return "استفاده نشده";

        if($this->status==1)
            return "در اختیار فروشگاه";

        if($this->status==2)
            return "استفاده شده";
    }
    public function getColorForStatus()
    {
        if($this->status==0)
            return "";

        if($this->status==1)
            return "success";

        if($this->status==2)
            return "danger";
    }
    public function getPerisanShopDate()
    {
        if($this->shop_date==0)
            return "";
        $date = Jalalian::forge($this->shop_date/1000);
        $y=$date->getYear();
        $m=$date->getMonth();
        $d=$date->getDay();
        return "$y/$m/$d";
    }
    public function getPerisanCustomerDate()
    {
        if($this->customer_date==0)
            return "";
        $date = Jalalian::forge($this->customer_date/1000);
        $y=$date->getYear();
        $m=$date->getMonth();
        $d=$date->getDay();
        return "$y/$m/$d";
    }
    public function getCustomerTime()
    {
        if($this->customer_date==0)
            return "";
        $date = Jalalian::forge($this->customer_date/1000);
        $h=$date->getHour();
        $m=$date->getMinute();
        $s=$date->getSecond();
        return "$h:$m:$s";
    }
    public function shop()
    {
        return $this->belongsTo(Shop::class,'shop_id','id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
}
