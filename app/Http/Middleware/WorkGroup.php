<?php

namespace App\Http\Middleware;

use App\Models\UserRole;
use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WorkGroup
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()) {
            if (Auth::user()->role->role != "Auditor General" && Auth::user()->role->role != "Super Admin") {

                if (Auth::user()->status == "active") {

                    view()->composer('*', function ($view) {
                        $groupRole = UserRole::find(Auth::user()->role_id);

                        $view->with('groupRole', $groupRole);
                    });

                    return $next($request);
                } else {
                    Auth::logout();
                    alert()->error('Access Denied!', 'Account Suspended.')->persistent('Dismiss');
                    return redirect()->route("welcome");
                }
            } else {
                Auth::logout();
                alert()->error('Access Denied!', 'You do not have the rights and privileges to this module.')->persistent('Dismiss');
                return redirect()->route("welcome");
            }
        } else {
            return redirect()->route('welcome');
        }
    }
}
