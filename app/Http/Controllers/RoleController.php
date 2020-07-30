<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Permission;
use App\Roles;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function getRoleData()
    {
        $permissions = Permission::getAllPermissions();
        $roles = Roles::getAllRoles();
        $roleData = array(
            'permission' => $permissions,
            'roles' => $roles
        );
        if ($roleData) {
            $code = Helper::SUCCESS_ROLE_FOUND;
            return response(['data' => $roleData, 'message' => Helper::$success[$code]]);
        } else {
            $code = Helper::ERROR_ROLE_FOUND;
            return response(['error' => 1, 'message' => Helper::$errors[$code]]);
        }
    }
    public function addRole(Request $request)
    {
        $validator = $this->validate($request, Roles::$addRules);
        $role = Roles::createRole($validator);
        if ($role) {
            $code = Helper::SUCCESS_ROLE_CREATE;
            return response(['message' => Helper::$success[$code]]);
        } else {
            $code = Helper::ERROR_ROLE_CREATE;
            return response(['error' => 1, 'message' => Helper::$errors[$code]]);
        }
    }
    public function getRole($id)
    {
        $role = Roles::getRoleById($id);
        if ($role) {
            $code = Helper::SUCCESS_ROLE_FOUND;
            return response(['data' => $role, 'message' => Helper::$success[$code]]);
        } else {
            $code = Helper::ERROR_ROLE_FOUND;
            return response(['error' => 1, 'message' => Helper::$errors[$code]]);
        }
    }
    public function updateRole($id, Request $request)
    {
        $validator = $this->validate($request, Roles::$addRules);
        $role = Roles::updateRole($id, $validator);
        if ($role) {
            $code = Helper::SUCCESS_ROLE_UPDATE;
            return response(['message' => Helper::$success[$code]]);
        } else {
            $code = Helper::ERROR_ROLE_UPDATE;
            return response(['error' => 1, 'message' => Helper::$errors[$code]]);
        }
    }
    public function deleteRole($id)
    {
        $role = Roles::deleteRole($id);
        if ($role) {
            $code = Helper::SUCCESS_ROLE_DELETE;
            return response(['message' => Helper::$success[$code]]);
        } else {
            $code = Helper::ERROR_ROLE_DELETE;
            return response(['error' => 1, 'message' => Helper::$errors[$code]]);
        }
    }
}
