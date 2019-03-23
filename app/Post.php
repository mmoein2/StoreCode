<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded=[];
    public function shop()
    {
        return $this->belongsTo(Shop::class,'shop_id','id');
    }
}
