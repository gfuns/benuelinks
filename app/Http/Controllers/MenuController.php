<?php
namespace App\Http\Controllers;

use App\Models\UserPermission;

class MenuController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public static function allowAccess($role, $feature)
    {
        $result     = false;
        $permission = UserPermission::where("role_id", $role)->where("feature_id", $feature)->first();
        if (isset($permission)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    public static function canCreate($role, $feature)
    {
        $result     = false;
        $permission = UserPermission::where("role_id", $role)->where("feature_id", $feature)->first();
        if ($permission->can_create == 1) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    public static function canEdit($role, $feature)
    {
        $result     = false;
        $permission = UserPermission::where("role_id", $role)->where("feature_id", $feature)->first();
        if ($permission->can_edit == 1) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    public static function canDelete($role, $feature)
    {
        $result     = false;
        $permission = UserPermission::where("role_id", $role)->where("feature_id", $feature)->first();
        if ($permission->can_delete == 1) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    public static function displayMiniEmployee($role, $feature)
    {
        $result     = false;
        $permission = UserPermission::where("role_id", $role)->where("feature_id", $feature)->first();
        if (isset($permission)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }
}
