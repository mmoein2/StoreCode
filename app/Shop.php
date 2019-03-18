<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $guarded=[];
    public function category()
    {
        return $this->belongsTo(ShopCategory::class,'shop_category_id','id');
    }
    public function getShopDate()
    {

    }
}
