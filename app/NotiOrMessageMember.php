<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotiOrMessageMember extends Model
{
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
