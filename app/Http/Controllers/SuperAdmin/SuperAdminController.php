<?php
namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\CompanyRoutes;
use App\Models\CompanyTerminals;
use App\Models\CompanyVehicles;
use App\Models\PlatformFeature;
use App\Models\States;
use App\Models\User;
use App\Models\UserPermission;
use App\Models\UserRole;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SuperAdminController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {
        return view("superadmin.dashboard");
    }

    /**
     * changePassword
     *
     * @return void
     */
    public function changePassword()
    {
        return view("superadmin.change_password");
    }

    /**
     * updatePassword
     *
     * @param Request request
     *
     * @return void
     */
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password'      => 'required',
            'new_password'          => 'required',
            'password_confirmation' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $user = Auth::user();

        if (! Hash::check($request->current_password, $user->password)) {
            toast('Invalid current password provided.', 'error');
            return back();
        } else {
            if ($request->new_password != $request->password_confirmation) {
                toast('Your newly seleted passwords do not match.', 'error');
                return back();
            } else {
                $user->password = Hash::make($request->new_password);
                $user->save();
            }
        }

        if ($user->save()) {
            toast('Password Changed Successfully.', 'success');
            return back();
        } else {
            toast('Something went wrong.', 'error');
            return back();
        }

    }

    /**
     * platformFeatures
     *
     * @return void
     */
    public function platformFeatures()
    {
        $features = PlatformFeature::all();
        return view("superadmin.platform_features", compact("features"));
    }

    /**
     * manageRoles
     *
     * @return void
     */
    public function manageRoles()
    {
        $userRoles = UserRole::all();
        return view("superadmin.manage_roles", compact("userRoles"));
    }

    /**
     * storeRole
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

        $role       = new UserRole;
        $role->role = $request->role;
        if ($role->save()) {
            toast('User Role Created Successfully', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * updateRole
     *
     * @param Request request
     *
     * @return void
     */
    public function updateUserRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role_id' => 'required|numeric',
            'role'    => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $parseRole = UserRole::where("role", $request->role)->where("id", "!=", $request->role_id)->count();
        if ($parseRole > 0) {
            toast('The provided user role is already allocated.', 'error');
            return back();
        }

        $role       = UserRole::find($request->role_id);
        $role->role = $request->role;
        if ($role->save()) {
            toast('User Role Updated Successfully', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
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
        return view('superadmin.manage_permissions', compact('role', 'platformFeatures'));
    }

    /**
     * grantFeaturePermission
     *
     * @param mixed role
     * @param mixed feature
     *
     * @return void
     */
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
     * userManagement
     *
     * @return void
     */
    public function userManagement()
    {
        $users     = User::where("role_id", "!=", 2)->get();
        $userRoles = UserRole::where("id", ">", 2)->get();
        $stations  = CompanyTerminals::where("status", "active")->get();
        return view("superadmin.user_management", compact("users", "userRoles", "stations"));
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
            'surname'      => 'required',
            'other_names'  => 'required',
            'email'        => 'required|unique:users',
            'phone_number' => 'required|unique:users',
            'station'      => 'required',
            'role'         => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $user               = new User;
        $user->last_name    = $request->surname;
        $user->other_names  = $request->other_names;
        $user->email        = $request->email;
        $user->phone_number = $request->phone_number;
        $user->station      = $request->station;
        $user->role_id      = $request->role;
        $user->password     = Hash::make($request->phone_number);
        if ($user->save()) {
            toast('User Account Created Successfully', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
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
            'surname'      => 'required',
            'other_names'  => 'required',
            'email'        => 'required',
            'phone_number' => 'required',
            'station'      => 'required',
            'role'         => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $user               = User::find($request->user_id);
        $user->last_name    = $request->surname;
        $user->other_names  = $request->other_names;
        $user->email        = $request->email;
        $user->phone_number = $request->phone_number;
        $user->station      = $request->station;
        $user->role_id      = $request->role;
        if ($user->save()) {
            toast('User Account Updated Successfully', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * activateUser
     *
     * @param mixed id
     *
     * @return void
     */
    public function activateUser($id)
    {
        $user         = User::find($id);
        $user->status = "active";
        if ($user->save()) {
            toast('User Account Activated Successfully', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * suspendUser
     *
     * @param mixed id
     *
     * @return void
     */
    public function suspendUser($id)
    {
        $user         = User::find($id);
        $user->status = "suspended";
        if ($user->save()) {
            toast('User Account Suspended Successfully', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * terminalManagement
     *
     * @return void
     */
    public function terminalManagement()
    {
        $terminals = CompanyTerminals::all();
        $states    = States::all();
        return view("superadmin.terminal_management", compact("terminals", "states"));
    }

    /**
     * storeTerminal
     *
     * @param Request request
     *
     * @return void
     */
    public function storeTerminal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'terminal' => 'required',
            'state'    => 'required',
            'lga'      => 'required',
            'address'  => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $terminal           = new CompanyTerminals;
        $terminal->terminal = $request->terminal;
        $terminal->state    = $request->state;
        $terminal->lga      = $request->lga;
        $terminal->address  = $request->address;
        if ($terminal->save()) {
            toast('Terminal Created Successfully', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    public function updateTerminal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'terminal_id' => 'required',
            'terminal'    => 'required',
            'state'       => 'required',
            'lga'         => 'required',
            'address'     => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $terminal           = CompanyTerminals::find($request->terminal_id);
        $terminal->terminal = $request->terminal;
        $terminal->state    = $request->state;
        $terminal->lga      = $request->lga;
        $terminal->address  = $request->address;
        if ($terminal->save()) {
            toast('Terminal Updated Successfully', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * activateTerminal
     *
     * @param mixed id
     *
     * @return void
     */
    public function activateTerminal($id)
    {
        $terminal         = CompanyTerminals::find($id);
        $terminal->status = "active";
        if ($terminal->save()) {
            toast('Terminal Activate Successfully', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * deactivateTerminal
     *
     * @param mixed id
     *
     * @return void
     */
    public function deactivateTerminal($id)
    {
        $terminal         = CompanyTerminals::find($id);
        $terminal->status = "inactive";
        if ($terminal->save()) {
            toast('Terminal Deactivate Successfully', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * fleetManagement
     *
     * @return void
     */
    public function fleetManagement()
    {
        $companyVehicles = CompanyVehicles::all();
        return view("superadmin.fleet_management", compact("companyVehicles"));
    }

    /**
     * storeVehicleDetails
     *
     * @param Request request
     *
     * @return void
     */
    public function storeVehicleDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vehicle_number'     => 'required|unique:company_vehicles',
            'manufacturer'       => 'required',
            'year'               => 'required',
            'model'              => 'required',
            'color'              => 'required',
            'plate_number'       => 'required|unique:company_vehicles',
            'chassis_number'     => 'required|unique:company_vehicles',
            'engine_number'      => 'required|unique:company_vehicles',
            'passenger_capacity' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $vehicle                 = new CompanyVehicles;
        $vehicle->vehicle_number = $request->vehicle_number;
        $vehicle->manufacturer   = $request->manufacturer;
        $vehicle->year           = $request->year;
        $vehicle->model          = $request->model;
        $vehicle->color          = $request->color;
        $vehicle->plate_number   = $request->plate_number;
        $vehicle->chassis_number = $request->chassis_number;
        $vehicle->engine_number  = $request->engine_number;
        $vehicle->seats          = $request->passenger_capacity;
        if ($vehicle->save()) {
            toast('Vechicle Information Stored Successfully', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * underMaintenance
     *
     * @param mixed id
     *
     * @return void
     */
    public function underMaintenance($id)
    {
        $vehicle         = CompanyVehicles::find($id);
        $vehicle->status = "under maintenance";
        if ($vehicle->save()) {
            toast('Vehicle Placed Under Maintenance', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * vehicleDecommissioned
     *
     * @param mixed id
     *
     * @return void
     */
    public function vehicleDecommissioned($id)
    {
        $vehicle         = CompanyVehicles::find($id);
        $vehicle->status = "decommissioned";
        if ($vehicle->save()) {
            toast('Vehicle Marked As Decommissioned', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * vehicleSold
     *
     * @param mixed id
     *
     * @return void
     */
    public function vehicleSold($id)
    {
        $vehicle         = CompanyVehicles::find($id);
        $vehicle->status = "sold";
        if ($vehicle->save()) {
            toast('Vehicle Marked As Sold', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * activateVehicle
     *
     * @param mixed id
     *
     * @return void
     */
    public function activateVehicle($id)
    {
        $vehicle         = CompanyVehicles::find($id);
        $vehicle->status = "active";
        if ($vehicle->save()) {
            toast('Vehicle Activated', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * updateVehicleDetails
     *
     * @param Request request
     *
     * @return void
     */
    public function updateVehicleDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vehicle_id'         => 'required',
            'vehicle_number'     => 'required',
            'manufacturer'       => 'required',
            'year'               => 'required',
            'model'              => 'required',
            'color'              => 'required',
            'plate_number'       => 'required',
            'chassis_number'     => 'required',
            'engine_number'      => 'required',
            'passenger_capacity' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $vehicle                 = CompanyVehicles::find($request->vehicle_id);
        $vehicle->vehicle_number = $request->vehicle_number;
        $vehicle->manufacturer   = $request->manufacturer;
        $vehicle->year           = $request->year;
        $vehicle->model          = $request->model;
        $vehicle->color          = $request->color;
        $vehicle->plate_number   = $request->plate_number;
        $vehicle->chassis_number = $request->chassis_number;
        $vehicle->engine_number  = $request->engine_number;
        $vehicle->seats          = $request->passenger_capacity;
        if ($vehicle->save()) {
            toast('Vechicle Information Updated Successfully', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * routeManagement
     *
     * @return void
     */
    public function routeManagement()
    {
        $companyTravelRoutes = CompanyRoutes::all();
        $terminals           = CompanyTerminals::where("status", "active")->where("id", ">", 1)->get();
        return view("superadmin.route_management", compact("companyTravelRoutes", "terminals"));
    }

    /**
     * storeRoute
     *
     * @param Request request
     *
     * @return void
     */
    public function storeRoute(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'take_off_point' => 'required',
            'destination'    => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        if ($request->take_off_point == $request->destination) {
            toast('Destination cannot be same as Take Off Point.', 'error');
            return back();
        }

        $route              = new CompanyRoutes;
        $route->departure   = $request->take_off_point;
        $route->destination = $request->destination;
        if ($route->save()) {
            toast('Travel Route Added Successfully', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * updateRoute
     *
     * @param Request request
     *
     * @return void
     */
    public function updateRoute(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'route_id'       => 'required',
            'take_off_point' => 'required',
            'destination'    => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        if ($request->take_off_point == $request->destination) {
            toast('Destination cannot be same as Take Off Point.', 'error');
            return back();
        }

        $route              = CompanyRoutes::find($request->route_id);
        $route->departure   = $request->take_off_point;
        $route->destination = $request->destination;
        if ($route->save()) {
            toast('Travel Route Updated Successfully', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * activateRoute
     *
     * @param mixed id
     *
     * @return void
     */
    public function activateRoute($id)
    {
        $route         = CompanyRoutes::find($id);
        $route->status = "active";
        if ($route->save()) {
            toast('Travel Route Activated', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * suspendRoute
     *
     * @param mixed id
     *
     * @return void
     */
    public function suspendRoute($id)
    {
        $route         = CompanyRoutes::find($id);
        $route->status = "suspended";
        if ($route->save()) {
            toast('Travel Route Suspended', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }
}
