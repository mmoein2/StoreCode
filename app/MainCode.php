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
}
