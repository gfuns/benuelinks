<?php
namespace App\Http\Controllers;

use App\Jobs\SendPasswordResetMail;
use App\Models\CompanyTerminals;
use App\Models\CustomerOtp;
use App\Models\GuestBooking;
use App\Models\NewsletterSubscription;
use App\Models\TravelBooking;
use App\Models\TravelSchedule;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use PDF;

class FrontEndController extends Controller
{

    /**
     * inviteUser
     *
     * @return void
     */
    public function inviteUser()
    {
        $referralcode = request()->ref;
        return view("auth.register", compact("referralcode"));
    }

    /**
     * adminLogin
     *
     * @return void
     */
    public function adminLogin()
    {
        return view("auth.admin");
    }

    /**
     * initiatePasswordReset
     *
     * @param Request request
     *
     * @return void
     */
    public function initiatePasswordReset(Request $request)
    {
        $validator = $this->validate($request, [
            'email' => 'required',
        ]);

        $accountExist = User::where("email", $request->email)->where("status", "!=", "suspended")->first();

        if (! $accountExist) {
            alert()->error("", "We could not find an account for the provided email");
            return back();
        }

        if (! $otp = CustomerOtp::updateOrCreate(
            [
                'user_id'  => $accountExist->id,
                'otp_type' => 'reset',
            ], [
                'otp'            => $this->generateOtp(),
                'otp_expiration' => Carbon::now()->addMinutes(5),
            ])) {

            alert()->error("", "Something Went Wrong");
            return back();
        }

        SendPasswordResetMail::dispatch($otp);
        Session::put("email", $request->email);
        return redirect()->route("pwdResetConfirmation");

    }

    /**
     * pwdResetConfirmation
     *
     * @return void
     */
    public function pwdResetConfirmation()
    {
        $email = Session::get("email");
        return view("auth.passwords.confirm", compact("email"));
    }

    /**
     * passwordResetVerification
     *
     * @param Request request
     *
     * @return void
     */
    public function passwordResetVerification(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'   => 'required',
            'digit_1' => 'required',
            'digit_2' => 'required',
            'digit_3' => 'required',
            'digit_4' => 'required',
        ]);

        if ($validator->fails()) {
            alert()->error("", "Please enter the complete confirmation code");
            return back();
        }

        $confirmationCode = $request->digit_1 . "" . $request->digit_2 . "" . $request->digit_3 . "" . $request->digit_4;

        $customer = User::where("email", $request->email)->where("status", "!=", "suspended")->first();

        if (! $customer) {
            alert()->error("", "Something Went Wrong");
            return back();
        }

        $codeIsValid = CustomerOtp::where("otp_type", "reset")->where("user_id", $customer->id)->where("otp", $confirmationCode)->first();

        if (! $codeIsValid) {
            alert()->error("", "The provided password reset code is invalid");
            return back();
        }

        if (now() > $codeIsValid->otp_expiration) {
            alert()->error("", "The provided password reset code has expired");
            return back();
        }

        if (! $codeIsValid->delete()) {
            alert()->error("", "Something Went Wrong");
            return back();
        }

        Session::put("email", $request->email);
        return redirect()->route("newPassword");
    }

    /**
     * newPassword
     *
     * @return void
     */
    public function newPassword()
    {
        $email = Session::get("email");
        return view("auth.passwords.reset", compact("email"));
    }

    /**
     * createNewPassword
     *
     * @param Request request
     *
     * @return void
     */
    public function createNewPassword(Request $request)
    {
        $validator = $this->validate($request, [
            'email'                 => 'required',
            'password'              => 'required',
            'password_confirmation' => 'required',
        ]);

        $customer = User::where("email", $request->email)->where("status", "!=", "suspended")->first();

        if (! $customer) {
            alert()->error("", "Something Went Wrong");
            return back();
        }

        if ($request->password != $request->password_confirmation) {
            alert()->error("", "Your newly seleted passwords do not match");
            return back();
        } else {
            $customer->password = Hash::make($request->password);
            if (! $customer->save()) {
                alert()->error("", "Something Went Wrong");
                return back();
            }
        }

        Session::forget("email");

        alert()->success("", "Password Changed Successfully");
        return redirect("/login");

    }

    /**
     * Generate a 4-digit One-Time Code
     *
     * @param null
     *
     * @return String $otp
     */
    public function generateOtp()
    {
        $pin = range(0, 9);
        $set = shuffle($pin);
        $otp = "";
        for ($i = 0; $i < 4; $i++) {
            $otp = $otp . "" . $pin[$i];
        }

        return $otp;
    }

    /**
     * newsletterSubscription
     *
     * @param Request request
     *
     * @return void
     */
    public function newsletterSubscription(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $exist = NewsletterSubscription::where("email", $request->email)->first();

        if (isset($exist)) {
            alert()->success("", "You have successfully subscribed to our newsletter.");
            return back();
        }

        $subscription        = new NewsletterSubscription;
        $subscription->email = $request->email;
        if ($subscription->save()) {
            alert()->success("", "You have successfully subscribed to our newsletter.");
            return back();
        } else {
            alert()->error("", "Something went wrong, please try again later.");
            return back();
        }
    }

    /**
     * welcome
     *
     * @return void
     */
    public function welcome()
    {
        $companyTerminals = CompanyTerminals::where("id", ">", 1)->where("status", "active")->get();
        return view("welcome", compact("companyTerminals"));
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
        return redirect()->route("guest.availableBuses", [$departure, $destination, $date]);
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

        return view("available_buses", compact("schedules", "title", "date"));
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

        $schedule      = TravelSchedule::find($request->schedule_id);
        $selectedSeats = $request->input('seatnumber', []);
        $seatNumber    = $selectedSeats[0] ?? null; // Returns null if array is empty

        if (! isset($seatNumber)) {
            alert()->error('', 'Please Select Your Preferred Seat Number!');
            return back();
        }

        if (isset($schedule)) {
            $booking                  = new GuestBooking;
            $booking->guest_number    = $this->genGuestID();
            $booking->schedule_id     = $schedule->id;
            $booking->departure       = $schedule->departure;
            $booking->destination     = $schedule->destination;
            $booking->vehicle         = $schedule->vehicle;
            $booking->vehicle_type    = $request->vehicle_type;
            $booking->travel_date     = $schedule->scheduled_date;
            $booking->departure_time  = $schedule->scheduled_time;
            $booking->full_name       = "Guest User";
            $booking->phone_number    = "Guest Phone";
            $booking->seat            = $seatNumber;
            $booking->payment_channel = "pending";
            $booking->classification  = "booking";
            $booking->payment_status  = "pending";
            $booking->travel_fare     = $schedule->transportFare();
            $booking->booking_number  = $this->genBookingID();
            $booking->booking_method  = "online";
            $booking->booking_status  = "pending";
            if ($booking->save()) {
                Session::put("guestBookingID", encrypt($booking->id));
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
        $id      = decrypt($id);
        $booking = GuestBooking::find($id);
        return view("passenger_details", compact("booking"));
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
            'legal_name'   => 'required',
            'email'        => 'required',
            'phone_number' => 'required',
            'gender'       => 'required',
            'nok'          => 'required',
            'nok_phone'    => 'required',
        ]);

        $booking               = GuestBooking::find($request->booking_id);
        $booking->full_name    = $request->legal_name;
        $booking->email        = $request->email;
        $booking->phone_number = $request->phone_number;
        $booking->gender       = $request->gender;
        $booking->nok          = $request->nok_name;
        $booking->nok_phone    = $request->nok_phone;
        if ($booking->save()) {
            return redirect()->route("guest.bookingPreview", [$booking->id]);
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
        $booking = GuestBooking::find($id);
        return view("booking_preview", compact("booking"));
    }

    /**
     * bookingReceipt
     *
     * @param mixed id
     *
     * @return void
     */
    public function bookingReceipt($id)
    {
        Session::forget('guestBookingID');
        $booking = TravelBooking::find($id);
        return view("booking_receipt", compact("booking"));
    }

    public function downloadReceipt($id)
    {
        $booking = TravelBooking::find($id);

        view()->share(['booking' => $booking]);
        $pdf      = PDF::loadView('download_receipt');
        $fileName = "Booking_Receipt_" . $booking->booking_number . ".pdf";
        return $pdf->download($fileName);
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
     * genGuestID
     *
     * @return void
     */
    public function genGuestID()
    {
        // Get the current timestamp
        $timestamp = (string) (strtotime('now') . microtime(true));

        // Remove any non-numeric characters (like dots)
        $cleanedTimestamp = preg_replace('/[^0-9]/', '', $timestamp);

        // Shuffle the digits
        $shuffled = str_shuffle($cleanedTimestamp);

        // Extract the first 12 characters
        $code = substr($shuffled, 0, 12);

        return "PMT-GUEST-" . $code;
    }

    /**
     * apiBasedDestinations
     *
     * @return void
     */
    public function apiBasedDestinations()
    {
        return new JsonResponse([
            'status_code' => (int) 200,
            'status'      => "Successful",
            'data'        => [
                'destinations' => CompanyTerminals::select("id", "terminal")->where("status", "active")->get(),
            ],
        ], 200);
    }
}
