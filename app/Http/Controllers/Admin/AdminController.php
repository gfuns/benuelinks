<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlatformFeature;
use App\Models\User;
use App\Models\UserPermission;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
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

    /**
     * userManagement
     *
     * @return void
     */
    public function userManagement()
    {
        $keyword = null;
        $filter  = null;
        $role    = null;
        $status  = null;

        $userRoles = UserRole::where("id", ">", 1)->get();

        if (request()->filter == "quick" && request()->search != null) {
            $filter  = "quick";
            $keyword = request()->search;
            $users   = User::query()->orderBy("id", "desc")->where("role_id", ">", 1)
                ->whereLike(['first_name', 'last_name', 'email'], request()->search)->get();
        } else if (request()->filter == "advanced" && request()->search != null) {
            $filter  = "advanced";
            $role    = request()->role;
            $status  = request()->status;
            $keyword = request()->search;
            if (request()->status != null && request()->role == null) {
                $users = User::query()->orderBy("id", "desc")->where("role_id", ">", 1)->where("status", request()->status)->whereLike(['first_name', 'last_name', 'email'], request()->search)->get();
            } else if (request()->status == null && request()->role != null) {
                $users = User::query()->orderBy("id", "desc")->where("role_id", request()->role)->whereLike(['first_name', 'last_name', 'email'], request()->search)->get();
            } else if (request()->status != null && request()->role != null) {
                $users = User::query()->orderBy("id", "desc")->where("status", request()->status)->where("role_id", request()->role)->whereLike(['first_name', 'last_name', 'email'], request()->search)->get();
            } else {
                $users = User::query()->orderBy("id", "desc")->where("role_id", ">", 1)->whereLike(['first_name', 'last_name', 'email'], request()->search)->get();
            }
        } else {
            $users = User::where("role_id", ">", 1)->get();
        }
        return view("admin.user_management", compact('users', 'userRoles', 'status', 'filter', 'keyword', "role"));
    }

    /**
     * storeUser
     *
     * @param Request request
     *
     * @return void
     */
    public function storeUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name'   => 'required',
            'last_name'    => 'required',
            'email'        => 'required|unique:users',
            'phone_number' => 'required|unique:users',
            'role'         => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $role = UserRole::find($request->role);

        try {

            $user                 = new User;
            $user->first_name     = $request->first_name;
            $user->last_name      = $request->last_name;
            $user->email          = $request->email;
            $user->phone_number   = $request->phone_number;
            $user->password       = Hash::make($request->phone_number);
            $user->role_id        = $request->role;
            $user->payroll_rights = $request->payroll_right;
            $user->save();

            toast("User Account Created Successfully.", 'success');
            return back();

        } catch (\Exception $e) {

            toast("Something Went Wrong. Please Try Again. ", 'error');
            return back();
        }
    }

    /**
     * updateUser
     *
     * @param Request request
     *
     * @return void
     */
    public function updateUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'      => 'required',
            'first_name'   => 'required',
            'last_name'    => 'required',
            'email'        => 'required',
            'phone_number' => 'required',
            'role'         => 'required',

        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $role = UserRole::find($request->role);

        try {

            $user                 = User::find($request->user_id);
            $user->first_name     = $request->first_name;
            $user->last_name      = $request->last_name;
            $user->email          = $request->email;
            $user->phone_number   = $request->phone_number;
            $user->role_id        = $request->role;
            $user->payroll_rights = $request->payroll_right;
            $user->save();

            toast("User Information Updated Successfully.", 'success');
            return back();

        } catch (\Exception $e) {

            toast("Something Went Wrong. Please Try Again.", 'error');
            return back();
        }
    }

    /**
     * suspendUser
     *
     * @return void
     */
    public function suspendUser(Request $request)
    {
        $user         = User::find($request->userid);
        $user->status = "suspended";
        if ($user->save()) {
            return response()->json([
                'title'   => 'Successful',
                'status'  => 'success',
                'message' => 'User Suspended.',
            ]);
        } else {
            return response()->json([
                'title'   => 'Failed to suspend user',
                'status'  => 'error',
                'message' => 'Something went wrong',
            ]);
        }
    }

    /**
     * activateUser
     *
     * @param mixed id
     *
     * @return void
     */
    public function activateUser(Request $request)
    {
        $user         = User::find($request->userid);
        $user->status = "active";
        if ($user->save()) {
            return response()->json([
                'title'   => 'Successful',
                'status'  => 'success',
                'message' => 'User Activated.',
            ]);
        } else {
            return response()->json([
                'title'   => 'Failed to activate user',
                'status'  => 'error',
                'message' => 'Something went wrong',
            ]);
        }
    }

    /**
     * userRoles
     *
     * @return void
     */
    public function userRoles()
    {
        $userRoles = UserRole::where("id", ">", 1)->get();
        return view("admin.user_roles", compact("userRoles"));
    }

    /**
     * storeUserRole
     *
     * @param Request request
     *
     * @return void
     */
    public function storeUserRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role' => 'required|unique:user_roles',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $userRole       = new UserRole;
        $userRole->role = $request->role;
        if ($userRole->save()) {
            return back()->with(["success" => "User Role Created successfully."]);
        } else {
            return back()->with(["error" => "Something went wrong."]);

        }
    }

    /**
     * updateUserRole
     *
     * @param Request request
     *
     * @return void
     */
    public function updateUserRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role_id' => 'required',
            'role'    => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $userRole       = UserRole::find($request->role_id);
        $userRole->role = $request->role;
        if ($userRole->save()) {
            return back()->with(["success" => "User Role Updated successfully."]);
        } else {
            return back()->with(["error" => "Something went wrong."]);

        }
    }

    /**
     * platformFeatures
     *
     * @param mixed id
     *
     * @return void
     */
    public function platformFeatures()
    {
        $platformFeatures = PlatformFeature::all();
        return view("admin.platform_features", compact("platformFeatures"));
    }

    /**
     * managePermissions
     *
     * @param mixed id
     *
     * @return void
     */
    public function managePermissions($id)
    {
        $role             = UserRole::find($id);
        $platformFeatures = PlatformFeature::all();
        return view("admin.role_permissions", compact("role", "platformFeatures"));
    }

    public function grantFeaturePermission($role, $feature)
    {
        $permission             = new UserPermission;
        $permission->role_id    = $role;
        $permission->feature_id = $feature;
        if ($permission->save()) {
            toast('Feature Permission Granted', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * revokeFeaturePermission
     *
     * @param mixed role
     * @param mixed feature
     *
     * @return void
     */
    public function revokeFeaturePermission($role, $feature)
    {
        $permission = UserPermission::where("role_id", $role)->where("feature_id", $feature)->first();
        if ($permission->delete()) {
            toast('Feature Permission Revoked', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * grantCreatePermission
     *
     * @param mixed role
     * @param mixed feature
     *
     * @return void
     */
    public function grantCreatePermission($role, $feature)
    {
        $permission             = UserPermission::where("role_id", $role)->where("feature_id", $feature)->first();
        $permission->can_create = 1;
        if ($permission->save()) {
            toast('Can Create Permission Granted', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * revokeCreatePermission
     *
     * @param mixed role
     * @param mixed feature
     *
     * @return void
     */
    public function revokeCreatePermission($role, $feature)
    {
        $permission             = UserPermission::where("role_id", $role)->where("feature_id", $feature)->first();
        $permission->can_create = 0;
        if ($permission->save()) {
            toast('Can Create Permission Revoked', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * grantEditPermission
     *
     * @param mixed role
     * @param mixed feature
     *
     * @return void
     */
    public function grantEditPermission($role, $feature)
    {
        $permission           = UserPermission::where("role_id", $role)->where("feature_id", $feature)->first();
        $permission->can_edit = 1;
        if ($permission->save()) {
            toast('Can Edit Permission Granted', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * revokeEditPermission
     *
     * @param mixed role
     * @param mixed feature
     *
     * @return void
     */
    public function revokeEditPermission($role, $feature)
    {
        $permission           = UserPermission::where("role_id", $role)->where("feature_id", $feature)->first();
        $permission->can_edit = 0;
        if ($permission->save()) {
            toast('Can Edit Permission Revoked', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * grantDeletePermission
     *
     * @param mixed role
     * @param mixed feature
     *
     * @return void
     */
    public function grantDeletePermission($role, $feature)
    {
        $permission             = UserPermission::where("role_id", $role)->where("feature_id", $feature)->first();
        $permission->can_delete = 1;
        if ($permission->save()) {
            toast('Can Delete Permission Granted', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * revokeDeletePermission
     *
     * @param mixed role
     * @param mixed feature
     *
     * @return void
     */
    public function revokeDeletePermission($role, $feature)
    {
        $permission             = UserPermission::where("role_id", $role)->where("feature_id", $feature)->first();
        $permission->can_delete = 0;
        if ($permission->save()) {
            toast('Can Delete Permission Revoked', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * storeUserPayrolRights
     *
     * @param Request request
     *
     * @return void
     */
    public function storeUserPayrolRights(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'       => 'required',
            'payroll_right' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $user                = User::find($request->user_id);
        $user->payrol_rights = $request->payroll_right;
        if ($user->save()) {
            return back()->with(["success" => "Payroll Rights Successfully Assigned."]);
        } else {
            return back()->with(["error" => "Something went wrong."]);
        }
    }

    /**
     * clearCache
     *
     * @return void
     */
    public function clearCache()
    {

        $exitCode = \Artisan::call('cache:clear');
        $exitCode = \Artisan::call('config:clear');
        $exitCode = \Artisan::call('route:clear');
        $exitCode = \Artisan::call('view:clear');

        return response()->json([
            'title'   => 'Successful',
            'status'  => 'success',
            'message' => 'Cache Cleared and Optimized.',
        ]);
    }
}
