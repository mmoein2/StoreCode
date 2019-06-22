<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Morilog\Jalali\Jalalian;

class Customer extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $guarded=[];
    public function getPersianRegistrationDate()
    {
        if($this->registration_date==0)
            return "";
        $date = Jalalian::forge($this->registration_date/1000)->format('Y/m/d');
        return $date;
    }

    public function getStatus()
    {
        if($this->status==false)
            return "غیر فعال";

        if($this->status==true)
            return "فعال";

    }
    public function getColorForStatus()
    {
        if($this->status==false)
            return "danger";

        if($this->status==true)
            return "success";

    }
    public function city()
    {
        return $this->belongsTo(City::class,'city_id','id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class,'province_id','id');
    }

    public function latestSubCode()
    {
        return $this->hasOne(SubCode::class,'customer_id','id')->orderByDesc('customer_date');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
