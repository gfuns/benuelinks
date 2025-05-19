<?php
namespace App\Http\Controllers;

use App\Jobs\SendPasswordResetMail;
use App\Models\CustomerOtp;
use App\Models\NewsletterSubscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class FrontEndController extends Controller
{

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
}
