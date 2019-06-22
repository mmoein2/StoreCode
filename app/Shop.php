<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Shop extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $guarded=[];
    protected $hidden=['shop_category_id','created_at','updated_at','play_id','password'];
    protected $casts=[
        'images'=>'array'
    ];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if(auth()->check())
        {
            $this->appends=['is_followed','club_count'];
        }
    }

    public function getIsFollowedAttribute()
    {
        if(auth()->check()) {
            $cs = CustomerShop::where('shop_id', $this->id)->where('customer_id', auth()->id())->exists();
            return $cs==true ? 1 : 0;
        }
    }
    public function getClubCountAttribute()
    {
         return SubCode::where('shop_id',$this->id)->where('customer_id','!=',null )->distinct('customer_id')->count();

    }



    public function category()
    {
        return $this->belongsTo(ShopCategory::class,'shop_category_id','id');
    }

    public function city()
    {
        return $this->belongsTo(City::class,'city_id','id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class,'province_id','id');
    }
    public function getShopDate()
    {

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
