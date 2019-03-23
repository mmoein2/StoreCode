<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\Jalalian;

class MainCode extends Model
{
    protected $guarded=[];
    public function shop()
    {
        return $this->belongsTo(Shop::class,'shop_id','id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
    public function prize()
    {
        return $this->belongsTo(Prize::class,'prize_id','id');
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
        if($this->status==true)
            return "مصرف شده";

        if($this->status==false)
            return "مصرف نشده";
    }
    public function getColorForStatus()
    {
        if($this->status==true)
            return "danger";
        elseif($this->status==false)
            return "success";
    }
    public function getCustomerTime()
    {
        if($this->customer_date==0)
            return "";
        $date = Jalalian::forge($this->customer_date/1000,new \DateTimeZone('Asia/Tehran'));
        $h=$date->getHour();
        $m=$date->getMinute();
        $s=$date->getSecond();
        return "$h:$m:$s";
    }

}
