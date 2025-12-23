<?php
namespace App\Http\Controllers;

use App\Models\GuestBooking;
use App\Models\TravelBooking;

class CronController extends Controller
{
    public function cancelGuestReservation()
    {
        $reservations = GuestBooking::where("payment_status", "pending")->get();
        foreach ($reservations as $res) {
            $res->payment_status = "failed";
            $res->save();
        }
    }

    public function cancelPassengerReservation()
    {
        $reservations = TravelBooking::where("payment_status", "pending")->get();
        foreach ($reservations as $res) {
            $res->payment_status = "failed";
            $res->save();
        }
    }
}
