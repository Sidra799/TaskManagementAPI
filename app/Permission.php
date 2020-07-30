<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use SoftDeletes;

    protected $fillable = ['name'];

    protected $hidden = [];

    /************* Relations *************/
    public function roles()
    {
        $this->belongsToMany(Roles::class, 'permission_roles');
    }

    /************* Validation Rules *************/
    public static $addRules = [
        'name' => 'required'
    ];


    /************* Functions *************/
    public static function createPermission($permission)
    {
        return Permission::create($permission);
    }
    public static function getAllPermissions()
    {
        return Permission::all();
    }
    public static function updatePermission($id, $data)
    {
        $permission = Permission::findOrFail($id);
        return $permission->update($data);
    }
    public static  function deletePermission($id)
    {
        $permission = Permission::findOrFail($id)->delete();
        return $permission;
    }
}
