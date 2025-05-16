<?php
namespace App\Http\Controllers\Passenger;

use App\Http\Controllers\Controller;
use App\Models\CompanyRoutes;
use App\Models\CompanyTerminals;
use App\Models\TravelBooking;
use App\Models\TravelSchedule;
use App\Models\User;
use App\Models\WalletTransactions;
use Auth;
use Carbon\Carbon;
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
        $companyTerminals = CompanyTerminals::where("id", ">", 1)->where("status", "active")->get();

        if (Carbon::now()->gt(Carbon::today()->addHours(12))) {
            $schedules = TravelSchedule::where("status", "scheduled")->whereDate("scheduled_date", Carbon::tomorrow())->limit(5)->get();
        } else {
            $schedules = TravelSchedule::where("status", "scheduled")->whereDate("scheduled_date", Carbon::today())->limit(5)->get();
        }

        return view("passenger.dashboard", compact("companyTerminals", "schedules"));
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
        $filter           = null;
        $takeoff          = null;
        $keyword          = null;
        $destination      = null;
        if (request()->filter == "quick" && request()->search != null) {
            $filter    = "quick";
            $keyword   = request()->search;
            $terminals = CompanyTerminals::query()->where("status", "active")
                ->whereLike(['terminal'], request()->search)->pluck("id");

            $companyRoutes = CompanyRoutes::where(function ($query) use ($terminals) {
                $query->whereIn("departure", $terminals)
                    ->orWhereIn("destination", $terminals);
            })->whereDate("status", "active")->get();
        } else if (request()->filter == "advanced") {
            $filter  = "advanced";
            $keyword = request()->search;
            if (isset(request()->takeoff) && isset(request()->destination)) {
                $takeoff       = request()->takeoff;
                $destination   = request()->destination;
                $companyRoutes = CompanyRoutes::where("departure", $takeoff)->where("destination", $destination)->where("status", "active")->get();
            } else if (isset(request()->takeoff) && ! isset(request()->destination)) {
                $takeoff       = request()->takeoff;
                $companyRoutes = CompanyRoutes::where("departure", $takeoff)->where("status", "active")->get();
            } else if (isset(request()->takeoff) && ! isset(request()->destination)) {
                $destination   = request()->destination;
                $companyRoutes = CompanyRoutes::where("destination", $destination)->where("status")->get();
            } else {
                $companyRoutes = CompanyRoutes::where("status", "active")->get();
            }
        } else {
            $companyRoutes = CompanyRoutes::where("status", "active")->get();
        }
        return view("passenger.route_prices", compact("companyTerminals", "companyRoutes", "filter", "keyword", "takeoff", "destination"));
    }

    /**
     * wallet
     *
     * @return void
     */
    public function wallet()
    {
        $transactions = WalletTransactions::orderBy("id", "desc")->where("user_id", Auth::user()->id)->get();
        return view("passenger.wallet", compact("transactions"));
    }

    /**
     * walletPinSetup
     *
     * @param Request request
     *
     * @return void
     */
    public function walletPinSetup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'wallet_pin'       => 'required',
            'pin_confirmation' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        if ($request->wallet_pin != $request->pin_confirmation) {
            alert()->error('', 'Wallet PIN and Wallet PIN Confirmation Do Not Match!');
            return back();
        }

        $user             = Auth::user();
        $user->wallet_pin = Hash::make($request->wallet_pin);
        $user->save();
        if ($user->save()) {
            alert()->success('', 'Wallet PIN Setup Successfully.');
            return back();
        } else {
            alert()->error('', 'Something Went Wrong!');
            return back();
        }
    }

    /**
     * updateWalletPin
     *
     * @param Request request
     *
     * @return void
     */
    public function updateWalletPin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_pin'      => 'required',
            'new_pin'          => 'required',
            'pin_confirmation' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $user = Auth::user();

        if (! Hash::check($request->current_pin, $user->wallet_pin)) {
            alert()->error('', 'Invalid Current PIN Provided!');
            return back();
        } else {
            if ($request->new_pin != $request->pin_confirmation) {
                alert()->error('', 'New PIN and New PIN Confirmation Do Not Match!');
                return back();
            } else {
                $user->wallet_pin = Hash::make($request->new_pin);
                $user->save();
            }
        }

        if ($user->save()) {
            alert()->success('', 'Wallet PIN Updated Successfully.');
            return back();
        } else {
            alert()->error('', 'Something Went Wrong!');
            return back();
        }
    }

    /**
     * searchSchedule
     *
     * @param Request request
     *
     * @return void
     */
    public function searchSchedule(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'takeoff'        => 'required',
            'destination'    => 'required',
            'departure_date' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $departure   = $request->takeoff;
        $destination = $request->destination;
        $date        = $request->departure_date;
        return redirect()->route("passenger.availableBuses", [$departure, $destination, $date]);
    }

    /**
     * availableBuses
     *
     * @param mixed departure
     * @param mixed destination
     * @param mixed date
     *
     * @return void
     */
    public function availableBuses($departure, $destination, $date)
    {
        $schedules = TravelSchedule::where("departure", $departure)->where("destination", $destination)->whereDate("scheduled_date", $date)->where("status", "scheduled")->get();

        return view("passenger.available_buses", compact("schedules"));
    }

    /**
     * bookingHistory
     *
     * @return void
     */
    public function bookingHistory()
    {
        $filter    = request()->filter;
        $startDate = request()->start_date;
        $endDate   = request()->end_date;

        if ($filter == "advanced" && isset($startDate) && isset($endDate)) {
            $bookingHistory = TravelBooking::whereBetween("travel_date", [$startDate, $endDate])->get();

        } else if (request()->filter == "advanced") {
            $bookingHistory = TravelBooking::all();
        }
        return view("passenger.booking_history", compact("filter", "bookingHistory", "startDate", "endDate"));
    }
}
