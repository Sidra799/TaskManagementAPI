<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Roles extends Model
{
    use SoftDeletes;

    protected $fillable = ['name'];
    protected $hidden = [];

    /************* Relations *************/
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permissions_roles');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /************* Validation Rules *************/
    public static $addRules = [
        'name' => 'required',
        'permissions' => 'required'
    ];


    /************* Functions *************/
    public static function createRole($data)
    {
        $roleArray = array('name' => $data['name']);
        $role = Roles::create($roleArray);
        $roleId = $role->id;
        $permissionRole = [];
        foreach ($data['permissions'] as $permission) {
            array_push($permissionRole, [
                'permission_id' => $permission,
                'roles_id' => $roleId
            ]);
        }
        $permissionRoleArray =  permissions_roles::insert($permissionRole);
        return $role;
    }
    public static function getAllRoles()
    {
        return Roles::with('permissions')->get();
    }
    public static function getRoleById($id)
    {
        $role = Roles::findOrFail($id);
        $permissions = $role->permissions;
        return $role;
    }
    public static function updateRole($id, $data)
    {
        $role = Roles::findOrFail($id);
        $roleArray = [
            'name' => $data['name']
        ];
        $roleUpdated = $role->update($roleArray);
        if ($roleUpdated) {
            return $role->permissions()->sync($data['permissions']);
        }
    }
    public static  function deleteRole($id)
    {
        $role = Roles::findOrFail($id)->delete();
        return $role;
    }
    
}
