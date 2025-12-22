<?php
namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Mail\AccountCreationMail as AccountCreationMail;
use App\Models\AuditTrails;
use App\Models\AuthenticationLogs;
use App\Models\CompanyRoutes;
use App\Models\CompanyTerminals;
use App\Models\CompanyVehicles;
use App\Models\GuestAccounts;
use App\Models\PlatformFeature;
use App\Models\States;
use App\Models\TravelBooking;
use App\Models\TravelSchedule;
use App\Models\User;
use App\Models\UserPermission;
use App\Models\UserRole;
use Auth;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Mail;
use \Carbon\Carbon;

class SuperAdminController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {
        $terminal   = Auth::user()->station;
        $tickets    = TravelBooking::where("payment_status", "paid")->whereDate("travel_date", today())->count();
        $revenue    = TravelBooking::where("payment_status", "paid")->whereDate("travel_date", today())->sum("travel_fare");
        $trips      = TravelSchedule::where("status", "trip successful")->whereDate("scheduled_date", today())->count();
        $passengers = TravelBooking::where("payment_status", "paid")->whereDate("travel_date", today())->count();

        $param = [
            "tickets"    => $tickets,
            "revenue"    => $revenue,
            "trips"      => $trips,
            "passengers" => $passengers,
        ];

        $ticketsSold = [
            "topRoutes"   => $this->getTopRoutes(),
            "ticketSales" => $this->getTicketSales(),
        ];

        $revennueStats = [
            "period" => $this->getRevenuePeriod(),
            "stats"  => $this->getRevenueStats(),
        ];

        $scheduledTrips = TravelSchedule::whereDate("scheduled_date", today())->limit(5)->get();
        return view("superadmin.dashboard", compact("param", "scheduledTrips", "ticketsSold", "revennueStats"));
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
        $userRoles = UserRole::where("id", "!=", 2)->get();
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
            'role'     => 'required|unique:user_roles',
            'category' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $role           = new UserRole;
        $role->role     = $request->role;
        $role->category = $request->category;
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
            'role_id'  => 'required|numeric',
            'role'     => 'required',
            'category' => 'required',
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

        $role           = UserRole::find($request->role_id);
        $role->role     = $request->role;
        $role->category = $request->category;
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
        $users     = User::where("role_id", "!=", 2)->where("id", ">", 1)->get();
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

            try {
                Mail::to($user)->send(new AccountCreationMail($user));
            } catch (\Exception $e) {
                \Log::error($e->getMessage());
            } finally {
                toast('User Account Created Successfully', 'success');
                return back();
            }

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
        $drivers         = User::where("role_id", 3)->where("status", "active")->get();
        return view("superadmin.fleet_management", compact("companyVehicles", "drivers"));
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
            'display_photo'      => 'required',
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
        if ($request->has('display_photo')) {
            $image    = $request->file('display_photo');
            $filename = "/images/fleet/" . time() . "." . $image->getClientOriginalName();
            $path     = public_path('/images/fleet/');
            $image->move($path, $filename);
            $vehicle->display_photo = $filename;
        }

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
        if ($request->has('display_photo')) {
            $image    = $request->file('display_photo');
            $filename = "/images/fleet/" . time() . "." . $image->getClientOriginalName();
            $path     = public_path('/images/fleet/');
            $image->move($path, $filename);
            $vehicle->display_photo = $filename;
        }

        if ($vehicle->save()) {
            toast('Vechicle Information Updated Successfully', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * assignDriver
     *
     * @param Request request
     *
     * @return void
     */
    public function assignDriver(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vehicle_id' => 'required',
            'driver'     => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $vehicle         = CompanyVehicles::find($request->vehicle_id);
        $vehicle->driver = $request->driver;
        if ($vehicle->save()) {
            toast('Driver Assigned Successfully', 'success');
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
        $departure           = null;
        $destination         = null;
        return view("superadmin.route_management", compact("companyTravelRoutes", "terminals", "departure", "destination"));
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
            'transport_fare' => 'required|numeric',
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

        $route                 = new CompanyRoutes;
        $route->departure      = $request->take_off_point;
        $route->destination    = $request->destination;
        $route->transport_fare = $request->transport_fare;
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
            'transport_fare' => 'required|numeric',
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

        $route                 = CompanyRoutes::find($request->route_id);
        $route->departure      = $request->take_off_point;
        $route->destination    = $request->destination;
        $route->transport_fare = $request->transport_fare;
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

    /**
     * searchTravelRoutes
     *
     * @param Request request
     *
     * @return void
     */
    public function searchTravelRoutes(Request $request)
    {
        $departure   = $request->take_off_point;
        $destination = $request->destination;

        return redirect()->route("superadmin.filterTravelRoutes", [$departure, $destination]);
    }

    public function filterTravelRoutes($departure = null, $destination = null)
    {
        $departure   = $departure == "null" ? null : $departure;
        $destination = $destination == "null" ? null : $destination;

        if (isset($departure) && isset($destination)) {
            $companyTravelRoutes = CompanyRoutes::where("departure", $departure)->where("destination", $destination)->get();
        } else if (isset($departure) && ! isset($destination)) {
            $companyTravelRoutes = CompanyRoutes::where("departure", $departure)->get();
        } else if (! isset($departure) && isset($destination)) {
            $companyTravelRoutes = CompanyRoutes::where("destination", $destination)->get();
        } else {
            $companyTravelRoutes = CompanyRoutes::all();
        }

        $terminals = CompanyTerminals::where("id", ">", 1)->where("status", "active")->get();

        return view("superadmin.route_management", compact("companyTravelRoutes", "terminals", "departure", "destination"));
    }

    /**
     * travelSchedule
     *
     * @return void
     */
    public function travelSchedule()
    {
        $weekData  = $this->getWeekData();
        $weekDates = $this->getWeekDates();

        $terminals       = CompanyTerminals::where("id", ">", 1)->where("status", "active")->get();
        $travelSchedules = TravelSchedule::whereDate('scheduled_date', '>=', now()->toDateString())->orderBy('id', 'desc')->get();
        $companyVehicles = CompanyVehicles::where("status", "active")->get();

        $departure   = null;
        $destination = null;
        $date        = null;

        $ticketers = User::where("role_id", 4)->where("status", "active")->get();

        return view("superadmin.travel_schedule", compact("terminals", 'travelSchedules', "destination", "departure", "date", "weekData", "weekDates", "companyVehicles", "ticketers"));
    }

    /**
     * storeTravelSchedule
     *
     * @param Request request
     *
     * @return void
     */
    public function storeTravelSchedule(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'take_off_point'         => 'required',
            'destination'            => 'required',
            'departure_time'         => 'required',
            'ticketer'               => 'required',
            'schedule_configuration' => 'required',
            'scheduled_date'         => 'required_if:schedule_configuration,specific',
            'week_date'              => 'required_if:schedule_configuration,weekly',
            'month_date'             => 'required_if:schedule_configuration,monthly',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        try {
            $route = CompanyRoutes::where("departure", $request->take_off_point)->where("destination", $request->destination)->first();
            if (! isset($route)) {
                toast('No Route Found For The Departure To Destination. Please Create Route.', 'error');
                return back();
            }

            if ($request->schedule_configuration == "specific") {
                $alreadyExist = TravelSchedule::where("departure", $request->take_off_point)->where("destination", $request->destination)->whereDate("scheduled_date", $request->scheduled_date)->where("scheduled_time", $request->departure_time)->first();
                if (! isset($alreadyExist)) {
                    $schedule                 = new TravelSchedule;
                    $schedule->departure      = $request->take_off_point;
                    $schedule->destination    = $request->destination;
                    $schedule->scheduled_time = $request->departure_time;
                    $schedule->scheduled_date = $request->scheduled_date;
                    $schedule->ticketer       = $request->ticketer;
                    $schedule->save();
                }

            } else if ($request->schedule_configuration == "weekly") {
                $selectedDates = $request->input('week_date', []);
                foreach ($selectedDates as $swd) {
                    $alreadyExist = TravelSchedule::where("departure", $request->take_off_point)->where("destination", $request->destination)->whereDate("scheduled_date", $swd)->where("scheduled_time", $request->departure_time)->first();
                    if (! isset($alreadyExist)) {
                        $schedule                 = new TravelSchedule;
                        $schedule->departure      = $request->take_off_point;
                        $schedule->destination    = $request->destination;
                        $schedule->scheduled_time = $request->departure_time;
                        $schedule->scheduled_date = $swd;
                        $schedule->ticketer       = $request->ticketer;
                        $schedule->save();
                    }
                }
            } else {
                $selectedDates = $request->input('month_date', []);
                foreach ($selectedDates as $smd) {
                    $alreadyExist = TravelSchedule::where("departure", $request->take_off_point)->where("destination", $request->destination)->whereDate("scheduled_date", $smd)->where("scheduled_time", $request->departure_time)->first();
                    if (! isset($alreadyExist)) {
                        $schedule                 = new TravelSchedule;
                        $schedule->departure      = $request->take_off_point;
                        $schedule->destination    = $request->destination;
                        $schedule->scheduled_time = $request->departure_time;
                        $schedule->scheduled_date = $smd;
                        $schedule->ticketer       = $request->ticketer;
                        $schedule->save();
                    }
                }
            }

            toast('Travel Schedule Created Successfully', 'success');
            return back();
        } catch (\Exception $e) {
            report($e);
            toast('Something went wrong. Please try again later.', 'error');
            return back();
        }

    }

    /**
     * adjustDepartureTime
     *
     * @param Request request
     *
     * @return void
     */
    public function adjustDepartureTime(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'schedule_id'    => 'required',
            'departure_time' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $schedule                 = TravelSchedule::find($request->schedule_id);
        $schedule->scheduled_time = $request->departure_time;
        if ($schedule->save()) {
            toast('Departure Time Adjusted Successfully', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * updateTripStatus
     *
     * @param Request request
     *
     * @return void
     */
    public function updateTripStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'schedule_id' => 'required',
            'trip_status' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $schedule         = TravelSchedule::find($request->schedule_id);
        $schedule->status = $request->trip_status;
        if ($schedule->save()) {
            toast('Trip Status Updated Successfully', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * assignVehicle
     *
     * @param Request request
     *
     * @return void
     */
    public function assignVehicle(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'schedule_id' => 'required',
            'vehicle'     => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $schedule          = TravelSchedule::find($request->schedule_id);
        $schedule->vehicle = $request->vehicle;
        if ($schedule->save()) {
            toast('Vehicle Assigned Successfully', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * suspendTrip
     *
     * @param mixed id
     *
     * @return void
     */
    public function suspendTrip($id)
    {
        $schedule         = TravelSchedule::find($id);
        $schedule->status = "trip suspended";
        if ($schedule->save()) {
            toast('Trip Suspended Successfully', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * searchTravelSchedule
     *
     * @param Request request
     *
     * @return void
     */
    public function searchTravelSchedule(Request $request)
    {
        $departure   = $request->take_off_point;
        $destination = $request->destination;
        $date        = $request->scheduled_date;

        return redirect()->route("superadmin.filterTravelSchedule", [$departure, $destination, $date]);
    }

    /**
     * filterTravelSchedule
     *
     * @param mixed departure
     * @param mixed destination
     * @param mixed date
     *
     * @return void
     */
    public function filterTravelSchedule($departure = null, $destination = null, $date = null)
    {
        $departure   = $departure == "null" ? null : $departure;
        $destination = $destination == "null" ? null : $destination;

        if (isset($departure) && isset($destination) && isset($date)) {
            $travelSchedules = TravelSchedule::where("departure", $departure)->where("destination", $destination)->whereDate("scheduled_date", $date)->get();
        } else if (isset($departure) && isset($destination) && ! isset($date)) {
            $travelSchedules = TravelSchedule::where("departure", $departure)->where("destination", $destination)->get();
        } else if (isset($departure) && ! isset($destination) && isset($date)) {
            $travelSchedules = TravelSchedule::where("departure", $departure)->whereDate("scheduled_date", $date)->get();
        } else if (! isset($departure) && isset($destination) && isset($date)) {
            $travelSchedules = TravelSchedule::where("destination", $destination)->whereDate("scheduled_date", $date)->get();
        } else if (isset($departure) && ! isset($destination) && ! isset($date)) {
            $travelSchedules = TravelSchedule::where("departure", $departure)->get();
        } else if (! isset($departure) && isset($destination) && ! isset($date)) {
            $travelSchedules = TravelSchedule::where("destination", $destination)->get();
        } else if (! isset($departure) && ! isset($destination) && isset($date)) {
            $travelSchedules = TravelSchedule::whereDate("scheduled_date", $date)->get();
        } else {
            $travelSchedules = TravelSchedule::all();
        }

        $weekData  = $this->getWeekData();
        $weekDates = $this->getWeekDates();

        $terminals = CompanyTerminals::where("id", ">", 1)->where("status", "active")->get();

        $companyVehicles = CompanyVehicles::where("status", "active")->get();
        return view("superadmin.travel_schedule", compact("travelSchedules", "terminals", "companyVehicles", "departure", "destination", "date", "weekData", "weekDates"));
    }

    /**
     * authenticationReport
     *
     *
     * @return void
     */
    public function authenticationReport()
    {
        $terminals  = CompanyTerminals::where("status", "active")->get();
        $startDate  = Carbon::today()->startOfMonth();
        $endDate    = Carbon::today()->endOfMonth();
        $activities = AuthenticationLogs::orderBy("id", "desc")->whereBetween('created_at', [$startDate, $endDate])->get();
        $terminal   = null;
        $event      = null;
        return view("superadmin.authentication_logs", compact("terminals", "terminal", "activities", "event"));
    }

    /**
     * searchUserAuths
     *
     * @param Request request
     *
     * @return void
     */
    public function searchUserAuths(Request $request)
    {

        if (isset($request->start_date) || isset($request->end_date)) {
            $validator = Validator::make($request->all(), [
                'start_date' => 'required',
                'end_date'   => 'required',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                $errors = implode("<br>", $errors);
                toast($errors, 'error');
                return back();
            }
        }

        $eventType = $request->event_type;
        $terminal  = $request->terminal;
        $startDate = isset($request->start_date) ? $this->cleanDate($request->start_date) : $request->start_date;
        $endDate   = isset($request->end_date) ? $this->cleanDate($request->end_date) : $request->end_date;

        if ($startDate > $endDate) {
            toast('End Date must be a date after Start Date.', 'error');
            return back();
        }

        return redirect()->route("superadmin.fetchUserAuths", [$terminal, $eventType, $startDate, $endDate]);
    }

    /**
     * fetchUserAuths
     *
     * @param mixed workgroup
     * @param mixed eventType
     * @param mixed startDate
     * @param mixed endDate
     *
     * @return void
     */
    public function fetchUserAuths($terminal = null, $eventType = null, $startDate = null, $endDate = null)
    {

        $eventType = $eventType == "null" ? null : $eventType;
        $event     = $eventType == "null" ? null : $eventType;
        $terminal  = $terminal == "null" ? null : $terminal;
        $station   = CompanyTerminals::find($terminal);
        $startDate = isset($startDate) ? $this->purifyDate($startDate) : $startDate;
        $endDate   = isset($endDate) ? $this->purifyDate($endDate) : $endDate;

        if (isset($terminal) && isset($eventType) && isset($startDate) && isset($endDate)) {
            $activities = AuthenticationLogs::orderBy("id", "desc")->where("station", $terminal)->where("event", $eventType)->whereBetween('created_at', [$startDate, $endDate])->get();

        } else if (isset($terminal) && isset($eventType) && ! isset($startDate) && ! isset($endDate)) {
            $startDate  = Carbon::today()->startOfMonth();
            $endDate    = Carbon::today()->endOfMonth();
            $activities = AuthenticationLogs::orderBy("id", "desc")->where("station", $terminal)->where("event", $eventType)->whereBetween('created_at', [$startDate, $endDate])->get();

        } elseif (isset($terminal) && ! isset($eventType) && isset($startDate) && isset($endDate)) {
            $activities = AuthenticationLogs::orderBy("id", "desc")->where("station", $terminal)->whereBetween('created_at', [$startDate, $endDate])->get();
        } elseif (! isset($terminal) && isset($eventType) && isset($startDate) && isset($endDate)) {
            $activities = AuthenticationLogs::orderBy("id", "desc")->where("event", $eventType)->whereBetween('created_at', [$startDate, $endDate])->get();
        } elseif (! isset($terminal) && ! isset($eventType) && isset($startDate) && isset($endDate)) {
            $activities = AuthenticationLogs::orderBy("id", "desc")->whereBetween('created_at', [$startDate, $endDate])->get();
        } elseif (isset($terminal) && ! isset($eventType) && ! isset($startDate) && ! isset($endDate)) {
            $startDate  = Carbon::today()->startOfMonth();
            $endDate    = Carbon::today()->endOfMonth();
            $activities = AuthenticationLogs::orderBy("id", "desc")->where("station", $terminal)->whereBetween('created_at', [$startDate, $endDate])->get();
        } else {
            $startDate  = Carbon::today()->startOfMonth();
            $endDate    = Carbon::today()->endOfMonth();
            $activities = AuthenticationLogs::orderBy("id", "desc")->whereBetween('created_at', [$startDate, $endDate])->get();

        }
        $terminals = CompanyTerminals::where("status", "active")->get();

        return view("superadmin.authentication_logs", compact("terminals", "station", "terminal", "event", "activities", "eventType", "startDate", "endDate"));
    }

    /**
     * auditTrailReport
     *
     *
     * @return void
     */
    public function auditTrailReport()
    {
        $terminals  = CompanyTerminals::where("status", "active")->get();
        $startDate  = Carbon::today()->startOfMonth();
        $endDate    = Carbon::today()->endOfMonth();
        $activities = AuditTrails::orderBy("id", "desc")->whereBetween('created_at', [$startDate, $endDate])->get();
        $terminal   = null;
        $event      = null;
        return view("superadmin.audit_trails", compact("terminals", "activities", "terminal", "event"));
    }

    /**
     * searchAuditTrails
     *
     * @param Request request
     *
     * @return void
     */
    public function searchAuditTrails(Request $request)
    {

        if (isset($request->start_date) || isset($request->end_date)) {
            $validator = Validator::make($request->all(), [
                'start_date' => 'required',
                'end_date'   => 'required',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                $errors = implode("<br>", $errors);
                toast($errors, 'error');
                return back();
            }
        }

        $eventType = $request->event_type;
        $terminal  = $request->terminal;
        $startDate = isset($request->start_date) ? $this->cleanDate($request->start_date) : $request->start_date;
        $endDate   = isset($request->end_date) ? $this->cleanDate($request->end_date) : $request->end_date;

        if ($startDate > $endDate) {
            toast('End Date must be a date after Start Date.', 'error');
            return back();
        }

        return redirect()->route("superadmin.fetchAuditTrails", [$terminal, $eventType, $startDate, $endDate]);
    }

    /**
     * fetchAuditTrails
     *
     * @param mixed eventType
     * @param mixed startDate
     * @param mixed endDate
     *
     * @return void
     */
    public function fetchAuditTrails($terminal = null, $eventType = null, $startDate = null, $endDate = null)
    {

        $eventType = $eventType == "null" ? null : $eventType;
        $event     = $eventType == "null" ? null : $eventType;
        $terminal  = $terminal == "null" ? null : $terminal;
        $startDate = isset($startDate) ? $this->purifyDate($startDate) : $startDate;
        $endDate   = isset($endDate) ? $this->purifyDate($endDate) : $endDate;
        $station   = CompanyTerminals::find($terminal);

        if (isset($terminal) && isset($eventType) && isset($startDate) && isset($endDate)) {
            $activities = AuditTrails::orderBy("id", "desc")->where("tags", $terminal)->where("event", $eventType)->whereBetween('created_at', [$startDate, $endDate])->get();

        } else if (isset($terminal) && isset($eventType) && ! isset($startDate) && ! isset($endDate)) {
            $startDate  = Carbon::today()->startOfMonth();
            $endDate    = Carbon::today()->endOfMonth();
            $activities = AuditTrails::orderBy("id", "desc")->where("tags", $terminal)->where("event", $eventType)->whereBetween('created_at', [$startDate, $endDate])->get();

        } elseif (isset($terminal) && ! isset($eventType) && isset($startDate) && isset($endDate)) {
            $activities = AuditTrails::orderBy("id", "desc")->where("tags", $terminal)->whereBetween('created_at', [$startDate, $endDate])->get();
        } elseif (! isset($terminal) && isset($eventType) && isset($startDate) && isset($endDate)) {
            $activities = AuditTrails::orderBy("id", "desc")->where("event", $eventType)->whereBetween('created_at', [$startDate, $endDate])->get();
        } elseif (! isset($terminal) && ! isset($eventType) && isset($startDate) && isset($endDate)) {
            $activities = AuditTrails::orderBy("id", "desc")->whereBetween('created_at', [$startDate, $endDate])->get();
        } elseif (isset($terminal) && ! isset($eventType) && ! isset($startDate) && ! isset($endDate)) {
            $startDate  = Carbon::today()->startOfMonth();
            $endDate    = Carbon::today()->endOfMonth();
            $activities = AuditTrails::orderBy("id", "desc")->where("tags", $terminal)->whereBetween('created_at', [$startDate, $endDate])->get();
        } else {
            $startDate  = Carbon::today()->startOfMonth();
            $endDate    = Carbon::today()->endOfMonth();
            $activities = AuditTrails::orderBy("id", "desc")->whereBetween('created_at', [$startDate, $endDate])->get();

        }

        if ($eventType == "created") {
            $eventType = "New Record Creation";
        } else if ($eventType == "updated") {
            $eventType = "Record Update";
        } else if ($eventType == "deleted") {
            $eventType = "Record Deletion";
        } else if ($eventType == "restored") {
            $eventType = "Record Restoration";
        }

        $terminals = CompanyTerminals::where("status", "active")->get();
        return view("superadmin.audit_trails", compact("terminals", "activities", "terminal", "event", "eventType", "startDate", "endDate"));
    }

    /**
     * printPassengerManifest
     *
     * @param mixed id
     *
     * @return void
     */
    public function printPassengerManifest($id)
    {
        $travelSchedule = TravelSchedule::find($id);
        $passengers     = TravelBooking::orderBy("seat", "asc")->where("schedule_id", $id)->where("boarding_status", "boarded")->get();
        return view("superadmin.passenger_manifest", compact("travelSchedule", "passengers"));
    }

    /**
     * financialReport
     *
     * @return void
     */
    public function financialReport(Request $request)
    {
        if (isset($request->start_date) || isset($request->end_date)) {
            $validator = Validator::make($request->all(), [
                'start_date' => 'required',
                'end_date'   => 'required',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                $errors = implode("<br>", $errors);
                toast($errors, 'error');
                return back();
            }
        }

        $startDate = request()->start_date ?? Carbon::today()->startOfMonth();
        $endDate   = request()->end_date ?? Carbon::today()->endOfMonth();

        if ($startDate > $endDate) {
            toast('End Date must be a date after Start Date.', 'error');
            return back();
        }

        $terminal = request()->terminal;
        $bus      = request()->bus;
        $ticketer = request()->ticketer;

        $query = TravelSchedule::query();

        $query->orderBy("id", "desc");

        $query->whereIn("status", ["in transit", "trip successful"])->whereBetween('scheduled_date', [$startDate, $endDate]);

        if (isset(request()->terminal)) {
            $query->where("departure", $terminal);
        }

        if (isset(request()->bus)) {
            $query->where("vehicle", $bus);
        }

        if (isset(request()->ticketer)) {
            $query->where("ticketer", $ticketer);
        }

        $transactions = $query->get();
        $terminals    = CompanyTerminals::where("status", "active")->get();
        $vehicles     = CompanyVehicles::where("status", "active")->get();
        $ticketers    = User::where("role_id", 4)->get();
        return view("superadmin.financial_report", compact("transactions", 'startDate', 'endDate', 'bus', 'terminal', 'ticketer', 'terminals', 'vehicles', 'ticketers'));
    }

    /**
     * filterTransactions
     *
     * @param Request request
     *
     * @return void
     */
    public function filterTransactions(Request $request)
    {
        if (isset($request->start_date) || isset($request->end_date)) {
            $validator = Validator::make($request->all(), [
                'start_date' => 'required',
                'end_date'   => 'required',
                'terminal'   => 'nullable',
                'bus'        => 'nullable',
                'ticketer'   => 'nullable',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                $errors = implode("<br>", $errors);
                toast($errors, 'error');
                return back();
            }
        }

        $startDate = isset($request->start_date) ? $this->cleanDate($request->start_date) : $request->start_date;
        $endDate   = isset($request->end_date) ? $this->cleanDate($request->end_date) : $request->end_date;

        if ($startDate > $endDate) {
            toast('End Date must be a date after Start Date.', 'error');
            return back();
        }

        return redirect()->route("superadmin.processTransactionFilter", [$startDate, $endDate, $terminal, $bus, $ticketer]);
    }

    /**
     * processTransactionFilter
     *
     * @param mixed startDate
     * @param mixed endDate
     *
     * @return void
     */
    public function processTransactionFilter($startDate = null, $endDate = null, $terminal = null, $bus = null, $ticketer = null)
    {
        if (isset($startDate) && isset($endDate)) {
            $transactions = TravelSchedule::whereIn("status", ["in transit", "trip successful"])->whereBetween('scheduled_date', [$startDate, $endDate])->get();
        } else {
            $startDate    = Carbon::today()->startOfMonth();
            $endDate      = Carbon::today()->endOfMonth();
            $transactions = TravelSchedule::whereIn("status", ["in transit", "trip successful"])->whereBetween('scheduled_date', [$startDate, $endDate])->get();
        }

        return view("superadmin.financial_report", compact("transactions", 'startDate', 'endDate'));
    }

    /**
     * endOfDayReport
     *
     * @return void
     */
    public function endOfDayReport()
    {
        $date         = request()->travel_date ?? date("Y-m-d");
        $route        = request()->travel_route;
        $ticketer     = request()->ticketer;
        $ticketerData = null;
        $routeData    = null;

        if (isset(request()->travel_route)) {
            $routeData = CompanyRoutes::find($route);
        }

        $baseQuery = TravelBooking::where('payment_status', 'paid')
            ->whereDate('travel_date', $date);

        if (isset(request()->ticketer)) {
            $baseQuery->where('ticketer', $ticketer);
            $ticketerData = User::find($ticketer);
        }

        if (isset($routeData)) {
            $baseQuery->where('departure', $routeData->departure)
                ->where('destination', $routeData->destination);
        }

        $params = [
            "tickets"         => (clone $baseQuery)->count(),
            "revenue"         => (clone $baseQuery)->sum("travel_fare"),
            "onlinebooking"   => (clone $baseQuery)->where("booking_method", "online")->count(),
            "physicalbooking" => (clone $baseQuery)->where("booking_method", "physical")->count(),
            "transfer"        => (clone $baseQuery)->where("payment_channel", "transfer")->sum("travel_fare"),
            "card"            => (clone $baseQuery)->where("payment_channel", "card payment")->sum("travel_fare"),
            "wallet"          => (clone $baseQuery)->where("payment_channel", "wallet")->sum("travel_fare"),
        ];

        $totals = [
            "bookingmethod"  => $params['onlinebooking'] + $params['physicalbooking'],
            "paymentchannel" => $params['transfer'] + $params['card'] + $params['wallet'],
        ];

        $travelRoutes = CompanyRoutes::where("status", "active")->get();
        $ticketers    = User::where("role_id", 4)->get();
        return view("superadmin.eod_report", compact("params", "totals", "date", "travelRoutes", "ticketers", "route", "routeData", "ticketer", "ticketerData"));
    }

    /**
     * extraLuggageReport
     *
     * @return void
     */
    public function extraLuggageReport()
    {
        alert()->info('Coming Soon.');
        return back();
    }

    /**
     * extraLuggageConfig
     *
     * @return void
     */
    public function extraLuggageConfig()
    {
        alert()->info('Coming Soon.');
        return back();
    }

    /**
     * cleanDate
     *
     * @param mixed date
     *
     * @return void
     */
    public function cleanDate($date)
    {
        $newDate = preg_replace("|/|", "-", $date);
        return $newDate;
    }

    /**
     * purifyDate
     *
     * @param mixed date
     *
     * @return void
     */
    public function purifyDate($date)
    {
        $date    = preg_replace("|-|", "/", $date);
        $newDate = $this->formatDate($date);
        return $newDate;
    }

    /**
     * formatDate
     *
     * @param mixed date
     *
     * @return void
     */
    public function formatDate($date)
    {
        $date          = str_replace('/', '-', $date);
        $newDate       = date('Y-m-d', strtotime($date));
        $formattedDate = new DateTime($newDate);
        return $formattedDate;
    }

    /**
     * getTopRoutes
     *
     * @return void
     */
    public function getTopRoutes()
    {
        $topTrips = TravelBooking::select('schedule_id', DB::raw('COUNT(*) as tickets_sold'))
            ->with(['schedule.departurePoint', 'schedule.destinationPoint'])
            ->groupBy('schedule_id')
            ->orderByDesc('tickets_sold')
            ->limit(5)
            ->get();

        $tripNames = [];

        foreach ($topTrips as $booking) {
            $trip = $booking->schedule;

            if ($trip && $trip->departurePoint && $trip->destinationPoint) {
                $departure   = preg_replace("/Terminal/", "", $trip->departurePoint->terminal);
                $destination = preg_replace("/Terminal/", "", $trip->destinationPoint->terminal);
                $tripNames[] = trim($departure) . ' - ' . trim($destination);
            }
        }

        return $tripNames;
    }

    /**
     * getTicketSales
     *
     * @return void
     */
    public function getTicketSales()
    {
        $topTrips = TravelBooking::select('schedule_id', DB::raw('COUNT(*) as tickets_sold'))
            ->with(['schedule.departurePoint', 'schedule.destinationPoint'])
            ->groupBy('schedule_id')
            ->orderByDesc('tickets_sold')
            ->where("payment_status", "paid")
            ->whereDate('travel_date', today())
            ->limit(5)
            ->get();

        $ticketSoldArr = [];

        foreach ($topTrips as $booking) {
            $trip = $booking->schedule;

            if ($trip && $trip->departurePoint && $trip->destinationPoint) {
                $ticketSoldArr[] = $booking->tickets_sold;
            }
        }

        $ticketSold = implode(', ', $ticketSoldArr);

        return $ticketSold;
    }

    /**
     * getRevenuePeriod
     *
     * @return void
     */
    public function getRevenuePeriod()
    {
        $dates = [];

        for ($i = 6; $i >= 0; $i--) {
            $date    = Carbon::today()->subDays($i);
            $dates[] = $date->format('M jS'); // e.g., Mar 21st
        }

        return $dates;
    }

    /**
     * getRevenueStats
     *
     * @return void
     */
    public function getRevenueStats()
    {
        $stats = [];

        for ($i = 6; $i >= 0; $i--) {
            $date       = Carbon::today()->subDays($i);
            $dailySales = TravelBooking::where("payment_status", "paid")->whereDate('travel_date', $date)->sum('travel_fare');
            $stats[]    = $dailySales;
        }

        $revenue = implode(', ', $stats);

        return $revenue;
    }

    /**
     * guestAccounts
     *
     * @return void
     */
    public function guestAccounts()
    {
        $lastRecord    = GuestAccounts::count();
        $marker        = $this->getMarkers($lastRecord, request()->page);
        $guestAccounts = GuestAccounts::paginate(50);

        return view("superadmin.guest_accounts", compact("guestAccounts", "lastRecord", "marker"));
    }

    /**
     * generateGuestAccount
     *
     * @return void
     */
    public function generateGuestAccount()
    {
        $baseURL   = env("BANK_ONE_BASE_URL");
        $authToken = env("MY_BANK_ONE_AUTH_TOKEN");
        $url       = $baseURL . '/BankOneWebAPI/api/Account/CreateAccountQuick/2?authToken=' . $authToken;

        try {
            $postData = [
                'TransactionTrackingRef'    => Str::uuid(),
                'AccountOpeningTrackingRef' => Str::uuid(),
                'ProductCode'               => env("BANK_ONE_PRODUCT_CODE"),
                'CustomerID'                => "057270",
                'LastName'                  => "Peace",
                'OtherNames'                => "Mass Transit",
                'BVN'                       => "11234567890",
                'PhoneNo'                   => "07007322362",
                'Gender'                    => 0,
                'DateOfBirth'               => $this->bankOneDate("1990-01-01"),
                'Address'                   => "39 Ajose Adeogun Street, Off Obafemi Awolowo Way, Utako, Abuja",
                'AccountOfficerCode'        => env("BANK_ONE_ACCOUNT_OFFICER"),
                'Email'                     => "support@peacextracomfort.com",
                'AccountTier'               => 2,
            ];

            $response = Http::post($url, $postData);

            if ($response->failed()) {
                // dd("Yesy");
                toast('An Error Occured While Creating Account For Customer On Bank One Infrastructure', 'error');
                return back();

            } else {
                $data = json_decode($response, true);
                // dd($data);
                if ($data["IsSuccessful"] === false) {
                    toast($data["Message"], 'error');
                    return back();
                }

                DB::beginTransaction();

                $guestAccount                       = new GuestAccounts;
                $guestAccount->last_name            = $postData["LastName"];
                $guestAccount->other_names          = $postData["OtherNames"];
                $guestAccount->email                = $postData["Email"];
                $guestAccount->phone_number         = $postData["PhoneNo"];
                $guestAccount->gender               = "Male";
                $guestAccount->dob                  = $this->formatDate($postData["DateOfBirth"]);
                $guestAccount->bvn                  = $postData["BVN"];
                $guestAccount->contact_address      = $postData["Address"];
                $guestAccount->account_number       = $data["Message"]["AccountNumber"];
                $guestAccount->bankOneBankId        = $data["Message"]["Id"];
                $guestAccount->bankOneCustomerId    = $data["Message"]["CustomerID"];
                $guestAccount->bankOneAccountNumber = $data["Message"]["BankoneAccountNumber"];
                $guestAccount->save();

                DB::commit();

                $accountName = $guestAccount->last_name . " " . $guestAccount->other_names;

                $this->logAccount($guestAccount->account_number, $accountName, $guestAccount->id);

            }

            toast('Guest Accounts Created Successfully', 'success');
            return back();
        } catch (\Exception $e) {
            DB::rollback();

            report($e);

            toast('Something went wrong. Please try again ' . $e->getMessage(), 'error');
            return back();
        }
    }

    /**
     * logAccount
     *
     * @param mixed accountNo
     * @param mixed accountName
     * @param mixed bizId
     *
     * @return void
     */
    public function logAccount($accountNo, $accountName, $bizId)
    {
        $data = [
            "account_name"   => $accountName,
            "account_number" => $accountNo,
            "business_id"    => $bizId,
            "guest_account"  => 1,
        ];

        $url      = "https://peacemasstransit.ng/api/v1/logAccount";
        $response = Http::timeout(600)->accept('application/json')->withHeaders([
            'x-api-key' => env("MIDDLEWARE_KEY"),
        ])->post($url, $data);

        $data = json_decode($response, true);

    }

    /**
     * bankOneDate
     *
     * @param mixed date
     *
     * @return void
     */
    public function bankOneDate($date)
    {
        $date    = str_replace('/', '-', $date);
        $newDate = date('Y-m-d', strtotime($date));
        return $newDate;
    }

    /**
     * getMarkers Helper Function
     *
     * @param mixed lastRecord
     * @param mixed pageNum
     *
     * @return void
     */
    public function getMarkers($lastRecord, $pageNum)
    {
        if ($pageNum == null) {
            $pageNum = 1;
        }
        $end    = (50 * ((int) $pageNum));
        $marker = [];
        if ((int) $pageNum == 1) {
            $marker["begin"] = (int) $pageNum;
            $marker["index"] = (int) $pageNum;
        } else {
            $marker["begin"] = number_format(((50 * ((int) $pageNum)) - 49), 0);
            $marker["index"] = number_format(((50 * ((int) $pageNum)) - 49), 0);
        }

        if ($end > $lastRecord) {
            $marker["end"] = number_format($lastRecord, 0);
        } else {
            $marker["end"] = number_format($end, 0);
        }

        return $marker;
    }

    /**
     * getWeekData
     *
     * @return void
     */
    public function getWeekData()
    {
        $startOfWeek = Carbon::now()->startOfWeek(Carbon::MONDAY);
        $endOfWeek   = Carbon::now()->endOfWeek(Carbon::SUNDAY);

        $weekNumber = $startOfWeek->format('W'); // ISO-8601 week number

        $formatted = "Week {$weekNumber}: " . $startOfWeek->format('jS F, Y') . " - " . $endOfWeek->format('jS F, Y');

        return $formatted;
    }

    /**
     * getWeekDates
     *
     * @return void
     */

    public function getWeekDates()
    {

        $startOfWeek = Carbon::now()->startOfWeek(Carbon::MONDAY);
        $datesOfWeek = [];

        for ($i = 0; $i < 7; $i++) {
            $date          = $startOfWeek->copy()->addDays($i);
            $datesOfWeek[] = [
                'date'  => $date->toDateString(),          // e.g. "2025-05-12"
                'label' => strtoupper($date->format('D')), // e.g. "MON"
            ];
        }

        return $datesOfWeek;
    }

}
