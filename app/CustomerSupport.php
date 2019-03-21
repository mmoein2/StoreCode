<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\Jalalian;

class CustomerSupport extends Model
{
    public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
    public function getPersianCreatedAt()
    {
        if($this->created_at==null)
            return "";
        $date = Jalalian::fromCarbon($this->created_at);
        $y=$date->getYear();
        $m=$date->getMonth();
        $d=$date->getDay();
        return "$y/$m/$d";
    }
    public function getStatus()
    {
        if($this->status==true)
            return "خوانده شده";

        if($this->status==false)
            return "خوانده نشده";
    }
    public function getColorForStatus()
    {
        if($this->status==true)
            return "success";
        elseif($this->status==false)
            return "danger";
    }
}
