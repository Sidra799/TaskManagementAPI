<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class permissions_roles extends Model
{
    protected $fillable = ['role_id','permission_id'];
    protected $hidden = [];
}
