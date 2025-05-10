<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyRoutes;
use App\Models\CompanyTerminals;
use App\Models\User;
use App\Models\UserRole;
use Auth;
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {
        return view("admin.dashboard");
    }

    /**
     * changePassword
     *
     * @return void
     */
    public function changePassword()
    {
        return view("admin.change_password");
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
     * userManagement
     *
     * @return void
     */
    public function userManagement()
    {
        $terminal  = CompanyTerminals::find(Auth::user()->station);
        $users     = User::where("station", $terminal->id)->get();
        $userRoles = UserRole::where("id", ">", 2)->get();
        return view("admin.user_management", compact("users", "userRoles", "terminal"));
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
     * travelRoutes
     *
     * @return void
     */
    public function travelRoutes()
    {
        $terminal            = CompanyTerminals::find(Auth::user()->station);
        $companyTravelRoutes = CompanyRoutes::where("departure", $terminal->id)->orWhere("destination", $terminal->id)->get();
        return view("admin.travel_routes", compact("companyTravelRoutes"));
    }

}
