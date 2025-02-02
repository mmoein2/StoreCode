<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConfirmShop extends Model
{
    protected $guarded=[];
    public function shop()
    {
        return $this->belongsTo(Shop::class,'shop_id','id');
    }
}
