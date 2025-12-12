<?php
namespace App\Http\Controllers;

use App\Http\Controllers\AjaxController;
use App\Models\CompanyTerminals;
use App\Models\TravelBooking;
use App\Models\TravelSchedule;

class AjaxController extends Controller
{
    public function getSchedules($terminal, $date)
    {

        \Log::info("I got here");
        \Log::info($date);
        \Log::info($terminal);
        $destinationIds = TravelSchedule::where('departure', $terminal)
            ->whereDate('scheduled_date', $date)
            ->distinct()
            ->pluck('destination');

        \Log::info("Destination Ids");
        \Log::info($destinationIds);

        $schedules = CompanyTerminals::whereIn('id', $destinationIds)
            ->pluck('terminal', 'id');
        \Log::info("Schedules");
        \Log::info($schedules);

        return response()->json($schedules);
    }

    public function getDepatureTimes($terminal, $destination, $date)
    {
        $departureTimes = TravelSchedule::where('departure', $terminal)->where("destination", $destination)->whereDate("scheduled_date", $date)->pluck('scheduled_time', 'id');

        return response()->json($departureTimes);
    }

    public function getBookedSeats($scheduleId)
    {
        $bookedSeats = TravelBooking::where("schedule_id", $scheduleId)
            ->where("payment_status", "paid")
            ->pluck("seat")
            ->flatMap(function ($seat) {
                return collect(explode(',', $seat))
                    ->map(fn($s) => (int) trim($s));
            })
            ->unique()
            ->values()
            ->toArray();

        return response()->json([
            'bookedSeats' => $bookedSeats,
        ]);
    }

    public function getAvailableSeats($scheduleId)
    {
        $bookedSeats = TravelBooking::where("schedule_id", $scheduleId)
            ->where("payment_status", "paid")
            ->pluck("seat")
            ->flatMap(function ($seat) {
                return collect(explode(',', $seat))
                    ->map(fn($s) => (int) trim($s));
            })
            ->unique()
            ->values()
            ->toArray();

        $allSeats = range(1, 16); // seats 1 to 16

        $availableSeats = array_values(array_diff($allSeats, $bookedSeats));

        return response()->json([
            'availableSeats' => $availableSeats,
        ]);
    }
}
