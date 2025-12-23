<?php
namespace App\Http\Controllers;

use App\Models\GuestBooking;
use App\Models\TravelBooking;
use Carbon\Carbon;

class CronController extends Controller
{
    public function cancelGuestReservation()
    {
        $reservations = GuestBooking::where('payment_status', 'pending')
            ->whereNotNull('reservation_date')
            ->where('reservation_date', '<=', Carbon::now()->subMinutes(10))
            ->get();

        foreach ($reservations as $res) {
            $res->payment_status = "failed";
            $res->save();
        }
    }

    public function cancelPassengerReservation()
    {
        $reservations = TravelBooking::where('payment_status', 'pending')
            ->whereNotNull('reservation_date')
            ->where('reservation_date', '<=', Carbon::now()->subMinutes(30))
            ->get();

        foreach ($reservations as $res) {
            $res->payment_status = "failed";
            $res->save();
        }
    }
}
