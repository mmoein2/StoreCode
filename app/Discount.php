<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends=['burned','count'];

    }
    public function getBurnedAttribute()
    {
            $cs = DiscountMember::where('is_burned', true)->where('discount_id', $this->id)->count();
            return $cs;
    }
    public function getCountAttribute()
    {
        $cs = DiscountMember::where('discount_id', $this->id)->count();
        return $cs;
    }
}
