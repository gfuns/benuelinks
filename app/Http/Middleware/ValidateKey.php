<?php
namespace App\Http\Middleware;

use App\Helpers\ResponseHelper;
use App\Models\GeneralSettings;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->header('API-KEY') == null) {

            return ResponseHelper::error('Please Provide API Key', 412);

        } elseif ($request->header('API-KEY') != GeneralSettings::apiKey()->setting_value) {

            return ResponseHelper::error('Invalid API Key', 412);

        } else {
            // if (Auth::check()) {
            //     if (Auth::user()->status == "suspended") {
            //         return ResponseHelper::error('This account has been suspended', 403);

            //     } elseif (Auth::user()->status == "banned") {

            //         return ResponseHelper::error('This account has been banned', 403);

            //     } elseif (Auth::user()->status == "deleted") {
            //         return ResponseHelper::error('We could not find a user with these credentials on our records', 404);
            //     }
            // }

            return $next($request);
        }
    }
}
