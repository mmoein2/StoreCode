<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermissionUser extends Model
{
    public function permission()
    {
        return $this->belongsTo(Permission::class,'permission_id','id');
    }
}
