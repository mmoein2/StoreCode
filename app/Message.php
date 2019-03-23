<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\Jalalian;

class Message extends Model
{
    protected $guarded=[];
    protected $hidden=['isMessage','shop_id','created_at','updated_at'];
    public function shop()
    {
        return $this->belongsTo(Shop::class,'shop_id','id');
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
        if($this->IsMessage==true)
            return "خوانده شده";

        if($this->IsMessage==false)
            return "خوانده نشده";
    }
    public function getColorForStatus()
    {
        if($this->IsMessage==true)
            return "success";
        elseif($this->IsMessage==false)
            return "danger";
    }

}
