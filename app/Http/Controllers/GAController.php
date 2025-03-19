<?php
namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Session;

class GAController extends Controller
{
    /**
     * enableGA
     *
     * @param Request request
     *
     * @return void
     */
    public function enableGA(Request $request)
    {
        $gaCode   = $request->google2fa_code;
        $gaSecret = $request->google2fa_secret;

        if ($gaCode == null || $gaSecret == null) {
            toast('Please enter a valid Google 2FA Code.', 'error');
            return back();
        }

        $user      = Auth::user();
        $google2fa = app('pragmarx.google2fa');
        $valid     = $google2fa->verifyKey($gaSecret, $gaCode);

        if ($valid) {
            $user->google2fa_secret = $gaSecret;
            $user->auth_2fa         = "GoogleAuth";
            if ($user->save()) {
                $data = [
                    'id'   => Auth::user()->id,
                    'time' => now(),
                ];
                Session::put('myGoogle2fa', $data);

                return redirect()->route("home");
            } else {
                toast('Something went wrong.', 'error');
                return back();
            }

        } else {
            toast('Invalid Google 2FA Code.', 'error');
            return back();

        }

    }

    /**
     * verify2FA
     *
     * @param Request request
     *
     * @return void
     */
    public function verify2FA(Request $request)
    {

        $gaCode = $request->google2fa_code;

        $user      = Auth::user();
        $google2fa = app('pragmarx.google2fa');
        $valid     = $google2fa->verify($gaCode, Auth::user()->google2fa_secret);

        if ($valid) {
            $data = [
                'id'   => Auth::user()->id,
                'time' => now(),
            ];
            Session::put('myGoogle2fa', $data);

            return back();
        } else {
            return back()->with(['error' => "Something Went Wrong"]);
        }
    }
}
