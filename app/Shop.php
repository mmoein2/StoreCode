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
    public function category()
    {
        return $this->belongsTo(ShopCategory::class,'shop_category_id','id');
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
