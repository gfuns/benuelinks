<?php
namespace App\Http\Controllers\Passenger;

use App\Http\Controllers\Controller;
use App\Models\CompanyRoutes;
use App\Models\CompanyTerminals;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PassengerController extends Controller
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
        return view("passenger.dashboard");
    }

    /**
     * accountSettings
     *
     * @return void
     */
    public function accountSettings()
    {
        return view("passenger.account_settings");
    }

    /**
     * updateProfile
     *
     * @param Request request
     *
     * @return void
     */
    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'last_name'    => 'required',
            'other_names'  => 'required',
            'phone_number' => 'required',
        ]);

        $user               = Auth::user();
        $user->last_name    = $request->last_name;
        $user->other_names  = $request->other_names;
        $user->phone_number = $request->phone_number;
        $user->nok          = $request->nok_name;
        $user->nok_phone    = $request->nok_phone;
        if ($user->save()) {
            alert()->success('', 'Profile Information Updated Successfully.');
            return back();
        } else {
            alert()->error('', 'Something Went Wrong!');
            return back();
        }
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
            alert()->error('', 'Invalid Current Password Provided!');
            return back();
        } else {
            if ($request->new_password != $request->password_confirmation) {
                alert()->error('', 'Your Newly Selected Passwords Do Not Match!');
                return back();
            } else {
                $user->password = Hash::make($request->new_password);
                $user->save();
            }
        }

        if ($user->save()) {
            alert()->success('', 'Password Changed Successfully.');
            return back();
        } else {
            alert()->error('', 'Something Went Wrong!');
            return back();
        }

    }

    /**
     * referrals
     *
     * @return void
     */
    public function referrals()
    {
        $referrals = User::where("refferal_id", Auth::user()->id)->get();
        return view("passenger.referrals", compact("referrals"));
    }

    /**
     * pricing
     *
     * @return void
     */
    public function pricing()
    {
        $companyTerminals = CompanyTerminals::where("id", ">", 1)->where("status", "active")->get();
        $companyRoutes    = CompanyRoutes::where("status", "active")->get();
        $filter           = null;
        $takeoff          = null;
        $destination      = null;
        return view("passenger.route_prices", compact("companyTerminals", "companyRoutes", "filter", "takeoff", "destination"));
    }
}
