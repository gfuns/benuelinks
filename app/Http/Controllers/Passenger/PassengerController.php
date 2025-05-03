<?php
namespace App\Http\Controllers\Passenger;

use App\Http\Controllers\Controller;

class PassengerController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {
        return view("passenger.dashboard");
    }
}
