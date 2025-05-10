<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditTrails;
use App\Models\AuthenticationLogs;
use App\Models\CompanyRoutes;
use App\Models\CompanyTerminals;
use App\Models\User;
use App\Models\UserRole;
use Auth;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use \Carbon\Carbon;

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

    /**
     * authenticationReport
     *
     *
     * @return void
     */
    public function authenticationReport()
    {
        $terminal   = CompanyTerminals::find(Auth::user()->station)->id;
        $startDate  = Carbon::today()->startOfMonth();
        $endDate    = Carbon::today()->endOfMonth();
        $activities = AuthenticationLogs::orderBy("id", "desc")->where("station", $terminal)->whereBetween('created_at', [$startDate, $endDate])->get();
        $event      = null;
        return view("admin.authentication_logs", compact("terminal", "activities", "event"));
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
        $startDate = isset($request->start_date) ? $this->cleanDate($request->start_date) : $request->start_date;
        $endDate   = isset($request->end_date) ? $this->cleanDate($request->end_date) : $request->end_date;

        if ($startDate > $endDate) {
            toast('End Date must be a date after Start Date.', 'error');
            return back();
        }

        return redirect()->route("admin.fetchUserAuths", [$eventType, $startDate, $endDate]);
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
    public function fetchUserAuths($eventType = null, $startDate = null, $endDate = null)
    {

        $terminal  = CompanyTerminals::find(Auth::user()->station)->id;
        $eventType = $eventType == "null" ? null : $eventType;
        $event     = $eventType == "null" ? null : $eventType;
        $station   = CompanyTerminals::find($terminal);
        $startDate = isset($startDate) ? $this->purifyDate($startDate) : $startDate;
        $endDate   = isset($endDate) ? $this->purifyDate($endDate) : $endDate;

        if (isset($eventType) && isset($startDate) && isset($endDate)) {
            $activities = AuthenticationLogs::orderBy("id", "desc")->where("station", $terminal)->where("event", $eventType)->whereBetween('created_at', [$startDate, $endDate])->get();

        } else if (isset($eventType) && ! isset($startDate) && ! isset($endDate)) {
            $startDate  = Carbon::today()->startOfMonth();
            $endDate    = Carbon::today()->endOfMonth();
            $activities = AuthenticationLogs::orderBy("id", "desc")->where("station", $terminal)->where("event", $eventType)->whereBetween('created_at', [$startDate, $endDate])->get();

        } elseif (! isset($eventType) && isset($startDate) && isset($endDate)) {
            $activities = AuthenticationLogs::orderBy("id", "desc")->where("station", $terminal)->whereBetween('created_at', [$startDate, $endDate])->get();
        } else {
            $startDate  = Carbon::today()->startOfMonth();
            $endDate    = Carbon::today()->endOfMonth();
            $activities = AuthenticationLogs::orderBy("id", "desc")->where("station", $terminal)->whereBetween('created_at', [$startDate, $endDate])->get();
        }

        return view("admin.authentication_logs", compact("station", "terminal", "event", "activities", "eventType", "startDate", "endDate"));
    }

    /**
     * auditTrailReport
     *
     *
     * @return void
     */
    public function auditTrailReport()
    {
        $terminal   = CompanyTerminals::find(Auth::user()->station)->id;
        $startDate  = Carbon::today()->startOfMonth();
        $endDate    = Carbon::today()->endOfMonth();
        $activities = AuditTrails::orderBy("id", "desc")->where("tags", $terminal)->whereBetween('created_at', [$startDate, $endDate])->get();
        $event      = null;
        return view("admin.audit_trails", compact("activities", "event"));
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
        $startDate = isset($request->start_date) ? $this->cleanDate($request->start_date) : $request->start_date;
        $endDate   = isset($request->end_date) ? $this->cleanDate($request->end_date) : $request->end_date;

        if ($startDate > $endDate) {
            toast('End Date must be a date after Start Date.', 'error');
            return back();
        }

        return redirect()->route("admin.fetchAuditTrails", [$eventType, $startDate, $endDate]);
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
    public function fetchAuditTrails($eventType = null, $startDate = null, $endDate = null)
    {

        $terminal  = CompanyTerminals::find(Auth::user()->station)->id;
        $event     = $eventType == "null" ? null : $eventType;
        $eventType = $eventType == "null" ? null : $eventType;
        $startDate = isset($startDate) ? $this->purifyDate($startDate) : $startDate;
        $endDate   = isset($endDate) ? $this->purifyDate($endDate) : $endDate;

        if (isset($eventType) && isset($startDate) && isset($endDate)) {
            $activities = AuditTrails::orderBy("id", "desc")->where("tags", $terminal)->where("event", $eventType)->whereBetween('created_at', [$startDate, $endDate])->get();

        } else if (isset($eventType) && ! isset($startDate) && ! isset($endDate)) {
            $startDate  = Carbon::today()->startOfMonth();
            $endDate    = Carbon::today()->endOfMonth();
            $activities = AuditTrails::orderBy("id", "desc")->where("tags", $terminal)->where("event", $eventType)->whereBetween('created_at', [$startDate, $endDate])->get();

        } elseif (! isset($eventType) && isset($startDate) && isset($endDate)) {
            $activities = AuditTrails::orderBy("id", "desc")->where("tags", $terminal)->whereBetween('created_at', [$startDate, $endDate])->get();
        } else {
            $startDate  = Carbon::today()->startOfMonth();
            $endDate    = Carbon::today()->endOfMonth();
            $activities = AuditTrails::orderBy("id", "desc")->where("tags", $terminal)->whereBetween('created_at', [$startDate, $endDate])->get();

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

        return view("admin.audit_trails", compact("activities", "terminal", "event", "eventType", "startDate", "endDate"));
    }

    /**
     * financialReport
     *
     * @return void
     */
    public function financialReport()
    {
        return view("admin.financial_report");
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

}
