<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\Jalalian;

class Customer extends Model
{
    protected $guarded=[];
    public function getPersianRegistrationDate()
    {
        if($this->registration_date==0)
            return "";
        $date = Jalalian::forge($this->registration_date/1000);
        $y=$date->getYear();
        $m=$date->getMonth();
        $d=$date->getDay();
        return "$y/$m/$d";
    }
}
