<?php
namespace App\Http\Controllers;

use App\Jobs\SendEmailVerificationCode;
use App\Models\CustomerOtp;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
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
        if (Auth::user()->role_id == 1) {
            return redirect()->route("superadmin.dashboard");
        } else if (Auth::user()->role_id == 2) {
            return redirect()->route("passenger.dashboard");
        } else {
            return redirect()->route("admin.dashboard");
        }
        return view("dashboard");
    }

    /**
     * verifyEmail
     *
     * @param Request request
     *
     * @return void
     */
    public function verifyEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'digit_1' => 'required',
            'digit_2' => 'required',
            'digit_3' => 'required',
            'digit_4' => 'required',
        ]);

        if ($validator->fails()) {
            toast("Please enter the complete verification code", 'error');
            return back();
        }

        $verificationCode = $request->digit_1 . "" . $request->digit_2 . "" . $request->digit_3 . "" . $request->digit_4;

        $codeIsValid = CustomerOtp::where("otp_type", "email")->where("user_id", Auth::user()->id)->where("otp", $verificationCode)->first();

        if (! $codeIsValid) {
            alert()->error('', 'The provided verification code is invalid.');
            return back();
        }

        if (now() > $codeIsValid->otp_expiration) {
            alert()->error('', 'The provided verification code has expired.');
            return back();
        }

        if (! Auth::user()->update(['email_verified_at' => now()])) {
            alert()->error('', 'Something Went Wrong.');
            return back();
        }

        if (! $codeIsValid->delete()) {
            alert()->error('', 'Something Went Wrong.');
            return back();
        }

        alert()->success("", "Email Verified Successfully");
        return redirect()->route("home");
    }

    /**
     * sendVerificationMail
     *
     * @param Request request
     *
     * @return void
     */
    public function sendVerificationMail(Request $request)
    {

        if (! $otp = CustomerOtp::updateOrCreate(
            [
                'user_id'  => Auth::user()->id,
                'otp_type' => 'email',
            ], [
                'otp'            => $this->generateOtp(),
                'otp_expiration' => Carbon::now()->addMinutes(5),
            ])) {
            return back();
        }

        SendEmailVerificationCode::dispatch($otp);
        alert()->success("", "Verification Code Sent Successfully");
        return back();

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

}
