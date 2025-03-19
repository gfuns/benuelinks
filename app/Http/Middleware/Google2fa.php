<?php
namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class Google2fa
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
        if (isset(Auth::user()->auth_2fa)) {

            if (Session::has("myGoogle2fa")) {
                return $next($request);
            } else {
                return response()->view("google2fa.index");
            }

        } else {
            $google2fa       = app('pragmarx.google2fa');
            $google2faSecret = $google2fa->generateSecretKey();
            $QRImage         = $google2fa->getQRCodeInline(
                env('APP_NAME'),
                Auth::user()->email,
                $google2faSecret,
                140
            );

            return response()->view("google2fa.setup", compact("google2faSecret", "QRImage"));
        }
    }
}
