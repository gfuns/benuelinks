<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditTrails;
use App\Models\AuthenticationLogs;
use App\Models\CompanyRoutes;
use App\Models\CompanyTerminals;
use App\Models\CompanyVehicles;
use App\Models\TravelBooking;
use App\Models\TravelSchedule;
use App\Models\User;
use App\Models\UserRole;
use Auth;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $terminal   = Auth::user()->station;
        $tickets    = TravelBooking::where("departure", $terminal)->whereDate("created_at", today())->count();
        $revenue    = TravelBooking::where("departure", $terminal)->where("boarding_status", "boarded")->whereDate("travel_date", today())->sum("travel_fare");
        $trips      = TravelSchedule::where("departure", $terminal)->where("status", "trip successful")->whereDate("scheduled_date", today())->count();
        $passengers = TravelBooking::where("departure", $terminal)->where("boarding_status", "boarded")->whereDate("travel_date", today())->count();

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

        $scheduledTrips = TravelSchedule::where("departure", $terminal)->whereDate("scheduled_date", today())->limit(5)->get();
        return view("admin.dashboard", compact("param", "scheduledTrips", "ticketsSold", "revennueStats"));
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
        $terminals           = CompanyTerminals::where("id", ">", 1)->where("status", "active")->get();
        $terminal            = CompanyTerminals::find(Auth::user()->station);
        $companyTravelRoutes = CompanyRoutes::where("departure", $terminal->id)->orWhere("destination", $terminal->id)->get();
        $departure           = null;
        $destination         = null;
        return view("admin.travel_routes", compact("companyTravelRoutes", "terminals", 'destination', 'departure'));
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

        return redirect()->route("admin.filterTravelRoutes", [$departure, $destination]);
    }

    public function filterTravelRoutes($departure = null, $destination = null)
    {
        $departure   = $departure == "null" ? null : $departure;
        $destination = $destination == "null" ? null : $destination;
        $station     = Auth::user()->station;

        if (isset($departure) && isset($destination)) {
            $companyTravelRoutes = CompanyRoutes::where("departure", $departure)->where("destination", $destination)->get();
        } else if (isset($departure) && ! isset($destination)) {
            $companyTravelRoutes = CompanyRoutes::where("departure", $departure)->get();
        } else if (! isset($departure) && isset($destination)) {
            $companyTravelRoutes = CompanyRoutes::where("destination", $destination)->get();
        } else {
            $companyTravelRoutes = CompanyRoutes::where("departure", $station)->orWhere("destination", $station)->get();
        }

        $terminals = CompanyTerminals::where("id", ">", 1)->where("status", "active")->get();

        return view("admin.travel_routes", compact("companyTravelRoutes", "terminals", "departure", "destination"));
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
        $startDate    = Carbon::today()->startOfMonth();
        $endDate      = Carbon::today()->endOfMonth();
        $transactions = TravelSchedule::where("departure", Auth::user()->station)->whereIn("status", ["in transit", "trip successful"])->whereBetween('scheduled_date', [$startDate, $endDate])->get();
        return view("admin.financial_report", compact("transactions", 'startDate', 'endDate'));
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

        return redirect()->route("admin.processTransactionFilter", [$startDate, $endDate]);
    }

    /**
     * processTransactionFilter
     *
     * @param mixed startDate
     * @param mixed endDate
     *
     * @return void
     */
    public function processTransactionFilter($startDate = null, $endDate = null)
    {
        if (isset($startDate) && isset($endDate)) {
            $transactions = TravelSchedule::where("departure", Auth::user()->station)->whereIn("status", ["in transit", "trip successful"])->whereBetween('scheduled_date', [$startDate, $endDate])->get();
        } else {
            $startDate    = Carbon::today()->startOfMonth();
            $endDate      = Carbon::today()->endOfMonth();
            $transactions = TravelSchedule::where("departure", Auth::user()->station)->whereIn("status", ["in transit", "trip successful"])->whereBetween('scheduled_date', [$startDate, $endDate])->get();
        }

        return view("admin.financial_report", compact("transactions", 'startDate', 'endDate'));
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
        $travelSchedules = TravelSchedule::orderBy("id", "desc")->where("departure", Auth::user()->station)->orWhere("destination", Auth::user()->station)->get();
        $companyVehicles = CompanyVehicles::where("status", "active")->get();

        $departure   = null;
        $destination = null;
        $date        = null;
        return view("admin.travel_schedule", compact("travelSchedules", "terminals", "weekData", "weekDates", "companyVehicles", "departure", "destination", "date"));
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
            if ($request->schedule_configuration == "specific") {
                $alreadyExist = TravelSchedule::where("departure", $request->take_off_point)->where("destination", $request->destination)->whereDate("scheduled_date", $request->scheduled_date)->where("scheduled_time", $request->departure_time)->first();
                if (! isset($alreadyExist)) {
                    $schedule                 = new TravelSchedule;
                    $schedule->departure      = $request->take_off_point;
                    $schedule->destination    = $request->destination;
                    $schedule->scheduled_time = $request->departure_time;
                    $schedule->scheduled_date = $request->scheduled_date;
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
                        $schedule->save();
                    }
                }
            }

            toast('Travel Schedule Created Successfully', 'success');
            return back();
        } catch (\Exception $e) {
            toast('Somethint went wrong. Please try again later.', 'error');
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

        return redirect()->route("admin.filterTravelSchedule", [$departure, $destination, $date]);
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
            $travelSchedules = TravelSchedule::where(function ($query) {
                $query->where("departure", Auth::user()->station)
                    ->orWhere("destination", Auth::user()->station);
            })->whereDate("scheduled_date", $date)->get();
        } else {
            $travelSchedules = TravelSchedule::where("departure", Auth::user()->station)->orWhere("destination", Auth::user()->station)->get();
        }

        $weekData  = $this->getWeekData();
        $weekDates = $this->getWeekDates();

        $terminals = CompanyTerminals::where("id", ">", 1)->where("status", "active")->get();

        $companyVehicles = CompanyVehicles::where("status", "active")->get();
        return view("admin.travel_schedule", compact("travelSchedules", "terminals", "weekData", "weekDates", "companyVehicles", "departure", "destination", "date"));
    }

    /**
     * bookPassengers
     *
     * @return void
     */
    public function bookPassengers()
    {
        $searchParam  = null;
        $terminal     = Auth::user()->station;
        $vehicleTypes = CompanyVehicles::select('model')->distinct()->get();
        $bookings     = TravelBooking::where("classification", "booking")->where("departure", $terminal)->get();
        $status       = null;
        $date         = null;
        $route        = null;
        $travelRoutes = CompanyRoutes::where("departure", $terminal)->get();
        return view("admin.passenger_booking", compact("bookings", "vehicleTypes", 'searchParam', "status", "date", "travelRoutes", "route"));
    }

    /**
     * searchBooking
     *
     * @return void
     */
    public function searchBooking(Request $request)
    {
        $searchParam  = $request->booking_number;
        $terminal     = Auth::user()->station;
        $vehicleTypes = CompanyVehicles::select('model')->distinct()->get();
        $bookings     = TravelBooking::where("classification", "booking")->where("departure", $terminal)->where("booking_number", $searchParam)->get();
        $status       = null;
        $date         = null;
        $route        = null;
        $travelRoutes = CompanyRoutes::where("departure", $terminal)->get();
        return view("admin.passenger_booking", compact("bookings", "vehicleTypes", 'searchParam', "status", "date", "travelRoutes", "route"));
    }

    /**
     * processBooking
     *
     * @param Request request
     *
     * @return void
     */
    public function processBooking(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'travel_date'     => 'required',
            'destination'     => 'required',
            'departure_time'  => 'required',
            'vehicle_choice'  => 'required',
            'seat_number'     => 'required',
            'passenger_name'  => 'required',
            'phone_number'    => 'required',
            'payment_channel' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $schedule = TravelSchedule::where("departure", Auth::user()->station)->where("destination", $request->destination)->whereDate("scheduled_date", $request->travel_date)->where("scheduled_time", $request->departure_time)->first();

        $route = CompanyRoutes::where("departure", Auth::user()->station)->where("destination", $request->destination)->first();

        if (isset($schedule) && isset($route)) {
            $booking                  = new TravelBooking;
            $booking->schedule_id     = $schedule->id;
            $booking->departure       = Auth::user()->station;
            $booking->destination     = $request->destination;
            $booking->vehicle         = $schedule->vehicle;
            $booking->vehicle_type    = $request->vehicle_choice;
            $booking->travel_date     = $request->travel_date;
            $booking->departure_time  = $request->departure_time;
            $booking->full_name       = $request->passenger_name;
            $booking->phone_number    = $request->phone_number;
            $booking->seat            = $request->seat_number;
            $booking->payment_channel = $request->payment_channel;
            $booking->classification  = "booking";
            $booking->payment_status  = "paid";
            $booking->travel_fare     = $route->transport_fare;
            $booking->booking_number  = $this->genBookingID();
            if ($booking->save()) {
                toast('Booking Successful', 'success');
                return back();
            } else {
                toast('Something went wrong. Please try again', 'error');
                return back();
            }
        } else {
            dd("No Route or Schedule");
            toast('Something went wrong. Please try again', 'error');
            return back();
        }

    }

    /**
     * filterBookings
     *
     * @param Request request
     *
     * @return void
     */
    public function filterBookings(Request $request)
    {
        $route  = $request->travel_route;
        $status = $request->booking_status;
        $date   = $request->travel_date;

        return redirect()->route("admin.processBookingFiltering", [$route, $status, $date]);
    }

    public function processBookingFiltering($route = null, $status = null, $date = null)
    {
        $route    = $route == "null" ? null : $route;
        $status   = $status == "null" ? null : $status;
        $date     = $date == "null" ? null : $date;
        $terminal = Auth::user()->station;

        if (isset($route) && isset($status) && isset($date)) {
            $bookings = TravelBooking::where("classification", "booking")->where("departure", $terminal)->where("destination", $route)->where("booking_status", $status)->whereDate("travel_date", $date)->get();
        } else if (isset($route) && isset($status) && ! isset($date)) {
            $bookings = TravelBooking::where("classification", "booking")->where("departure", $terminal)->where("destination", $route)->where("booking_status", $status)->get();
        } else if (isset($route) && ! isset($status) && isset($date)) {
            $bookings = TravelBooking::where("classification", "booking")->where("departure", $terminal)->where("destination", $route)->whereDate("travel_date", $date)->get();
        } else if (! isset($route) && isset($status) && isset($date)) {
            $bookings = TravelBooking::where("classification", "booking")->where("departure", $terminal)->where("booking_status", $status)->whereDate("travel_date", $date)->get();
        } else if (isset($route) && ! isset($status) && ! isset($date)) {
            $bookings = TravelBooking::where("classification", "booking")->where("departure", $terminal)->where("destination", $route)->get();
        } else if (! isset($route) && isset($status) && ! isset($date)) {
            $bookings = TravelBooking::where("classification", "booking")->where("departure", $terminal)->where("booking_status", $status)->get();
        } else if (! isset($route) && ! isset($status) && isset($date)) {
            $bookings = TravelBooking::where("classification", "booking")->where("departure", $terminal)->whereDate("travel_date", $date)->get();
        } else {
            $bookings = TravelBooking::where("classification", "booking")->where("departure", $terminal)->get();
        }

        $searchParam  = null;
        $terminal     = Auth::user()->station;
        $vehicleTypes = CompanyVehicles::select('model')->distinct()->get();
        $travelRoutes = CompanyRoutes::where("departure", $terminal)->get();
        return view("admin.passenger_booking", compact("bookings", "vehicleTypes", 'searchParam', "date", "status", "route", 'travelRoutes'));

    }

    /**
     * validateTicket
     *
     * @param mixed id
     *
     * @return void
     */
    public function validateTicket($id)
    {
        $booking                 = TravelBooking::find($id);
        $booking->booking_status = "validated";
        if ($booking->save()) {
            toast('Ticket Validated Successfully', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * printBookingTicket
     *
     * @param mixed id
     *
     * @return void
     */
    public function printBookingTicket($id)
    {
        $booking = TravelBooking::find($id);
        return view("admin.print_ticket", compact("booking"));
    }

    /**
     * boardPassengers
     *
     * @return void
     */
    public function boardPassengers()
    {
        $terminal        = Auth::user()->station;
        $travelSchedules = TravelSchedule::where("departure", $terminal)->where("status", "boarding in progress")->get();
        return view("admin.board_passengers", compact("travelSchedules"));
    }

    /**
     * viewPassengers
     *
     * @param mixed id
     *
     * @return void
     */
    public function viewPassengers($id)
    {
        $travelSchedule = TravelSchedule::find($id);
        $passengers     = TravelBooking::where("schedule_id", $id)->get();
        return view("admin.passenger_list", compact("travelSchedule", "passengers"));
    }

    /**
     * processPassengerBoarding
     *
     * @param Request request
     *
     * @return void
     */
    public function processPassengerBoarding(Request $request)
    {
        $selectedIds = $request->input('selected_items');

        $passengers = TravelBooking::whereIn('id', $selectedIds)->update(["boarding_status" => "boarded"]);
        if ($passengers) {
            toast('Selected Passengers Boarded Successfully', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();

        }
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
        return view("admin.passenger_manifest", compact("travelSchedule", "passengers"));
    }

    /**
     * genBookingID
     *
     * @return void
     */
    public function genBookingID()
    {
        // Get the current timestamp
        $timestamp = (string) (strtotime('now') . microtime(true));

        // Remove any non-numeric characters (like dots)
        $cleanedTimestamp = preg_replace('/[^0-9]/', '', $timestamp);

        // Shuffle the digits
        $shuffled = str_shuffle($cleanedTimestamp);

        // Extract the first 12 characters
        $code = substr($shuffled, 0, 12);

        return "PMT-BK-" . $code;
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
            ->where("departure", Auth::user()->station)
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
            ->where("departure", Auth::user()->station)
            ->groupBy('schedule_id')
            ->orderByDesc('tickets_sold')
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
            $dailySales = TravelBooking::where("departure", Auth::user()->station)->whereDate('created_at', $date)
                ->sum('travel_fare');
            $stats[] = $dailySales;
        }

        $revenue = implode(', ', $stats);

        return $revenue;
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
