<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Permission;
use Illuminate\Http\Request;
use PHPUnit\TextUI\Help;

class PermissionController extends Controller
{
    public function addPermission(Request $request)
    {
        $validator = $this->validate($request, Permission::$addRules);
        $permission = Permission::createPermission($validator);
        if ($permission) {
            $code = Helper::SUCCESS_PERMISSION_CREATE;
            return response(['message' => Helper::$success[$code]]);
        } else {
            $code = Helper::ERROR_PERMISSION_CREATE;
            return response(['error' => 1, 'message' => Helper::$errors[$code]]);
        }
    }
    public function getAllPermissions()
    {
        $permission = Permission::getAllPermissions();
        if ($permission) {
            $code = Helper::SUCCESS_PERMISSION_FOUND;
            return response(['data' => $permission, 'message' => Helper::$success[$code]]);
        } else {
            $code = Helper::ERROR_PERMISSION_FOUND;
            return response(['error' => 1, 'message' => Helper::$errors[$code]]);
        }
    }
    public function updatePermission(Request $request, $id)
    {
        $validator = $this->validate($request, Permission::$addRules);
        $permission = Permission::updatePermission($id, $validator);
        if ($permission) {
            return response(['message' => 'Permission Updated']);
        } else {
            return response(['error' => 1, 'message' => 'Permission Not Updated']);
        }
    }
    public function deletePermission($id)
    {
        $permission = Permission::deletePermission($id);
        if ($permission) {
            $code = Helper::SUCCESS_PERMISSION_DELETE;
            return response(['message' => Helper::$success[$code]]);
        } else {
            $code = Helper::ERROR_PERMISSION_DELETE;
            return response(['error' => 1, 'message' => Helper::$errors[$code]]);
        }
    }
}
