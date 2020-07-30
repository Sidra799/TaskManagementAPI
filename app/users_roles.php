<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class users_roles extends Model
{
    protected $fillable = ['role_id','users_id'];
    protected $hidden = [];
}
