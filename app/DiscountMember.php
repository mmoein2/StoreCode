<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiscountMember extends Model
{
    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }
}
