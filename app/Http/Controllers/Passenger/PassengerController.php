<?php
namespace App\Http\Controllers\Passenger;

use App\Http\Controllers\Controller;
use App\Mail\BookingSuccessful as BookingSuccessful;
use App\Models\CompanyRoutes;
use App\Models\CompanyTerminals;
use App\Models\GuestBooking;
use App\Models\TravelBooking;
use App\Models\TravelSchedule;
use App\Models\User;
use App\Models\WalletTransactions;
use App\Models\XtrapayPayments;
use Auth;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Mail;

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
            'last_name'       => 'required',
            'other_names'     => 'required',
            'phone_number'    => 'required',
            'gender'          => 'required',
            'dob'             => 'required',
            'bvn'             => 'required',
            'contact_address' => 'required',
        ]);

        $user               = Auth::user();
        $user->last_name    = $request->last_name;
        $user->other_names  = $request->other_names;
        $user->phone_number = $request->phone_number;
        $user->gender       = $request->gender;
        if (! isset(Auth::user()->bvn)) {
            $user->bvn = $request->bvn;
        }
        if (! isset(Auth::user()->dob)) {
            $user->dob = $request->dob;
        }
        $user->contact_address = $request->contact_address;
        $user->nok             = $request->nok_name;
        $user->nok_phone       = $request->nok_phone;
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
        $referrals = User::where("referral_id", Auth::user()->id)->get();
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
        $balances = [
            "deposits" => Auth::user()->wallet_balance,
            "bonuses"  => 0,
        ];

        $transactions = WalletTransactions::orderBy("id", "desc")->where("user_id", Auth::user()->id)->get();
        return view("passenger.wallet", compact("transactions", "balances"));
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

        try {
            DB::beginTransaction();

            $response = Http::accept('application/json')->withHeaders([
                'authorization' => "Bearer " . env('XTRAPAY_TOKEN'),
                'content_type'  => "Content-Type: application/json",
            ])->post(env("XTRAPAY_BASE_URL") . "/peace/loyalty-va", [
                'bvn'   => Auth::user()->bvn,
                'email' => Auth::user()->email,
                'name'  => Auth::user()->last_name . " " . Auth::user()->other_names,
            ]);

            // \Log::info($response);

            if ($response->failed()) {
                $data = json_decode($response, true);
                toast($data["message"], 'error');
                return back();

            } else {
                $data = json_decode($response, true);
                // \Log::info($data);
                // dd($data);
                if ($data["status"] === true) {

                    $user                 = Auth::user();
                    $user->wallet_pin     = Hash::make($request->wallet_pin);
                    $user->account_number = $data["data"]["account_number"];
                    $user->account_name   = $data["data"]["account_name"];
                    $user->bank           = "Providus Bank";
                    $user->save();

                    DB::commit();

                    alert()->success('', 'Wallet PIN Setup Successfully.');
                    return back();
                } else {
                    toast($data["message"], 'error');
                    return back();
                }

            }
        } catch (\Exception $e) {

            DB::rollback();

            report($e);

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
            'current_pin'      => 'required|digits:4',
            'new_pin'          => 'required|digits:4',
            'pin_confirmation' => 'required|digits:4',
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

        $departure   = CompanyTerminals::find($departure)->terminal;
        $destination = CompanyTerminals::find($destination)->terminal;
        $title       = $departure . " => " . $destination;
        $date        = date_format(new DateTime($date), 'l - jS M, Y');

        return view("passenger.available_buses", compact("schedules", "title", "date"));
    }

    /**
     * seatSelection
     *
     * @param Request reques
     *
     * @return void
     */
    public function seatSelection(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'schedule_id'  => 'required',
            'seatnumber'   => 'required',
            'vehicle_type' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            alert()->error('', $errors);
            return back();
        }

        $submittedSeats = collect($request->seatnumber)
            ->map(fn($s) => (int) $s)
            ->unique()
            ->values();

        //Check if Seat Number is already selected on Travel Booking
        $trvbookedSeats = TravelBooking::where('schedule_id', $request->schedule_id)
            ->whereIn("payment_status", ["paid", "locked", "pending"])
            ->pluck('seat')
            ->flatMap(function ($seat) {
                return collect(explode(',', $seat))
                    ->map(fn($s) => (int) trim($s));
            })
            ->unique();
        $trvBkSeatExist = $submittedSeats->intersect($trvbookedSeats);

        //Check if Seat Number is already selceted on Guest Booking
        $guestbookedSeats = GuestBooking::where('schedule_id', $request->schedule_id)
            ->whereIn("payment_status", ["paid", "locked", "pending"])
            ->pluck('seat')
            ->flatMap(function ($seat) {
                return collect(explode(',', $seat))
                    ->map(fn($s) => (int) trim($s));
            })
            ->unique();
        $guestBkSeatExist = $submittedSeats->intersect($guestbookedSeats);

        if ($trvBkSeatExist->isNotEmpty() || $guestBkSeatExist->isNotEmpty()) {
            alert()->error('', "Seat Number Already Selected! Please Choose Another Seat.");
            return back();
        }

        $schedule      = TravelSchedule::find($request->schedule_id);
        $seats         = $request->input('seatnumber', []);
        $selectedSeats = implode(', ', $seats);
        $seatCount     = count($seats);
        $seatNumber    = $selectedSeats ?? null; // Returns null if array is empty
        if (! isset($seatNumber)) {
            alert()->error('', 'Please Select Your Preferred Seat Number!');
            return back();
        }

        if (isset($schedule)) {
            $booking                    = new TravelBooking;
            $booking->user_id           = Auth::user()->id;
            $booking->schedule_id       = $schedule->id;
            $booking->departure         = $schedule->departure;
            $booking->destination       = $schedule->destination;
            $booking->vehicle           = $schedule->vehicle;
            $booking->vehicle_type      = $request->vehicle_type;
            $booking->travel_date       = $schedule->scheduled_date;
            $booking->departure_time    = $schedule->scheduled_time;
            $booking->full_name         = Auth::user()->last_name . ", " . Auth::user()->other_names;
            $booking->phone_number      = Auth::user()->phone_number;
            $booking->nok               = Auth::user()->nok;
            $booking->nok_phone         = Auth::user()->nok_phone;
            $booking->seat              = $seatNumber;
            $booking->payment_channel   = "pending";
            $booking->classification    = "booking";
            $booking->payment_status    = "pending";
            $booking->travel_fare       = ($seatCount * $schedule->transportFare());
            $booking->booking_number    = $this->genBookingID();
            $booking->booking_method    = "online";
            $booking->booking_status    = "pending";
            $booking->ticketer          = $schedule->ticketer;
            $booking->assigned_ticketer = $schedule->ticketer;
            $booking->reservation_date  = now();
            if ($booking->save()) {
                return redirect()->route("passenger.passengerDetails", [$booking->id]);
            } else {
                alert()->error('', 'Something went wrong. Please try again');
                return back();
            }
        } else {
            alert()->error('', 'Something went wrong. Please try again');
            return back();
        }

    }

    /**
     * passengerDetails
     *
     * @param mixed id
     *
     * @return void
     */
    public function passengerDetails($id)
    {
        $booking = TravelBooking::find($id);
        return view("passenger.passenger_details", compact("booking"));
    }

    /**
     * updatePassengerDetails
     *
     * @param Request request
     *
     * @return void
     */
    public function updatePassengerDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'booking_id'   => 'required',
            'last_name'    => 'required',
            'other_names'  => 'required',
            'email'        => 'required',
            'phone_number' => 'required',
            'gender'       => 'required',
            'nok'          => 'required',
            'nok_phone'    => 'required',
        ]);

        $booking               = TravelBooking::find($request->booking_id);
        $booking->full_name    = $request->last_name . ", " . $request->other_names;
        $booking->email        = $request->email;
        $booking->phone_number = $request->phone_number;
        $booking->gender       = $request->gender;
        $booking->nok          = $request->nok_name;
        $booking->nok_phone    = $request->nok_phone;
        if ($booking->save()) {
            return redirect()->route("passenger.bookingPreview", [$booking->id]);
        } else {
            alert()->error('', 'Something Went Wrong!');
            return back();
        }
    }

    /**
     * bookingPreview
     *
     * @param mixed id
     *
     * @return void
     */
    public function bookingPreview($id)
    {
        $booking        = TravelBooking::find($id);
        $accountBalance = Auth::user()->wallet_balance;
        return view("passenger.booking_preview", compact("booking", "accountBalance"));
    }

    /**
     * payWithWallet
     *
     * @param mixed id
     *
     * @return void
     */
    public function payWithWallet($id)
    {
        try {
            $booking = TravelBooking::find($id);

            $accountBalance = Auth::user()->wallet_balance;

            if ($accountBalance < $booking->travel_fare) {
                alert()->error('', 'Insufficient Wallet Balance');
                return back();
            }

            DB::beginTransaction();

            $user                 = Auth::user();
            $user->wallet_balance = (double) ($accountBalance - $booking->travel_fare);
            $user->save();

            $walletTrx                 = new WalletTransactions;
            $walletTrx->user_id        = Auth::user()->id;
            $walletTrx->trx_type       = "debit";
            $walletTrx->reference      = self::genInternalRef(Auth::user()->id);
            $walletTrx->amount         = $booking->travel_fare;
            $walletTrx->balance_before = $accountBalance;
            $walletTrx->balance_after  = ($accountBalance - $booking->travel_fare);
            $walletTrx->description    = "Payment for Trip with Booking No: {$booking->booking_number}";
            $walletTrx->status         = "successful";
            $walletTrx->save();

            $booking->payment_status  = "paid";
            $booking->payment_channel = "wallet";
            $booking->booking_status  = "booked";
            $booking->save();

            DB::commit();

            try {
                Mail::to($booking)->send(new BookingSuccessful($booking));
            } catch (\Exception $e) {
                \Log::error($e->getMessage());
            } finally {
                alert()->success('', 'Trip Booked Successfully!');
                return redirect()->route("passenger.bookingHistory");
            }

            alert()->success('', 'Trip Booked Successfully!');
            return redirect()->route("passenger.bookingHistory");
        } catch (\Exception $e) {
            DB::rollback();
            report($e);

            alert()->error('', 'Something Went Wrong!');
            return back();
        }

    }

    /**
     * payWithXtrapay
     *
     * @param Request request
     *
     * @return void
     */
    public function payWithXtrapay(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'booking_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            alert()->error('', $errors);
            return back();
        }

        try {
            DB::beginTransaction();

            $booking   = TravelBooking::find($request->booking_id);
            $reference = self::genInternalRef(Auth::user()->id);

            $response = Http::accept('application/json')->withHeaders([
                'authorization' => "Bearer " . env('XTRAPAY_TOKEN'),
                'content_type'  => "Content-Type: application/json",
            ])->post(env("XTRAPAY_BASE_URL") . "/peace/guest-va", [
                "reference" => $reference, // required, unique per transaction
                "amount"    => $booking->travel_fare,
                "depot"     => $booking->departurePoint->terminal,
                "meta"      => [
                    "customerId" => Auth::user()->id,
                    "note"       => "Passenger Booking",
                ],
            ]);

            // \Log::info($response);

            if ($response->failed()) {
                $data = json_decode($response, true);
                toast($data["message"], 'error');
                return back();

            } else {
                $data = json_decode($response, true);
                // \Log::info($data);
                if ($data["status"] === true) {

                    $xtrapay                 = new XtrapayPayments;
                    $xtrapay->transaction_id = $booking->id;
                    $xtrapay->reference      = $data["data"]["reference"];
                    $xtrapay->amount         = $booking->travel_fare;
                    $xtrapay->trx_type       = "booking";
                    $xtrapay->bank           = "Providus Bank";
                    $xtrapay->account_name   = $data["data"]["account_name"];
                    $xtrapay->account_number = $data["data"]["account_number"];
                    $xtrapay->save();

                    DB::commit();

                    return redirect()->route("passenger.paymentDetails", [$xtrapay->reference]);
                } else {
                    toast($data["message"], 'error');
                    return back();
                }

            }

        } catch (\Throwable $e) {
            DB::rollback();
            report($e);
            alert()->error('', $e->getMessage());
            return back();
        }
    }

    /**
     * paymentDetails
     *
     * @param mixed reference
     *
     * @return void
     */
    public function paymentDetails($reference)
    {
        $paymentDetails = XtrapayPayments::where("reference", $reference)->first();
        if ($paymentDetails->status == "pending") {

            return view("passenger.payment_details", compact("paymentDetails"));

        } else if ($paymentDetails->status == "successful") {

            alert()->success('', 'Trip Booked Successfully!');
            return redirect()->route("passenger.bookingHistory");

            $booking                  = TravelBooking::find($paymentDetails->transaction_id);
            $booking->payment_status  = "paid";
            $booking->payment_channel = "transfer";
            $booking->booking_status  = "booked";
            $booking->save();

            try {
                Mail::to($booking)->send(new BookingSuccessful($booking));
            } catch (\Exception $e) {
                \Log::error($e->getMessage());
            } finally {
                alert()->success('', 'Trip Booked Successfully!');
                return redirect()->route("passenger.bookingHistory");
            }

        } else {
            alert()->error('', 'This transaction has timed out and your payment was not received!');
            return redirect()->route("passenger.bookingPreview", [$paymentDetails->transaction_id]);
        }

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
            $bookingHistory = TravelBooking::orderBy("id", "desc")->where("user_id", Auth::user()->id)->where("payment_status", "paid")->whereBetween("travel_date", [$startDate, $endDate])->get();
        } else {
            $bookingHistory = TravelBooking::orderBy("id", "desc")->where("user_id", Auth::user()->id)->where("payment_status", "paid")->get();
        }
        return view("passenger.booking_history", compact("filter", "bookingHistory", "startDate", "endDate"));
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
     * genMiddlewareRef
     *
     * @param mixed businessId
     *
     * @return void
     */
    public function genMiddlewareRef($businessId)
    {
        $data = [
            "business_id"    => $businessId,
            "classification" => "booking",
        ];

        $url      = "https://peacemasstransit.ng/api/v1/generateReference";
        $response = Http::timeout(600)->accept('application/json')->withHeaders([
            'x-api-key' => env("MIDDLEWARE_KEY"),
        ])->post($url, $data);

        $data = json_decode($response, true);

        $reference = $data['response']['data'];

        return $reference;
    }

    /**
     * genInternalRef
     *
     * @return void
     */
    public function genInternalRef($clientId)
    {
        // Get the current timestamp
        $timestamp = (string) (strtotime('now') . microtime(true));

        // Remove any non-numeric characters (like dots)
        $cleanedTimestamp = preg_replace('/[^0-9]/', '', $timestamp);

        $microtime = substr($cleanedTimestamp, -4);

        // Shuffle the digits
        $shuffled = str_shuffle($cleanedTimestamp);

        // Extract the first 5 characters
        $code = substr($shuffled, 0, 11);

        $reference = $clientId . $microtime . $code;

        return substr($reference, 0, 12);
    }

    /**
     * genTrxId
     *
     * @return void
     */
    public function genTrxId()
    {
        $pin  = range(0, 12);
        $set  = shuffle($pin);
        $code = "";
        for ($i = 0; $i < 12; $i++) {
            $code = $code . "" . $pin[$i];
        }

        return "PMT" . $code;
    }

    public function bankOneDate($date)
    {
        $date    = str_replace('/', '-', $date);
        $newDate = date('Y-m-d', strtotime($date));
        return $newDate;
    }

    public function logAccount($accountNo, $accountName, $bizId)
    {
        $data = [
            "account_name"   => $accountName,
            "account_number" => $accountNo,
            "business_id"    => $bizId,
        ];

        $url      = "https://peacemasstransit.ng/api/v1/logAccount";
        $response = Http::timeout(600)->accept('application/json')->withHeaders([
            'x-api-key' => env("MIDDLEWARE_KEY"),
        ])->post($url, $data);

        $data = json_decode($response, true);

    }
}
