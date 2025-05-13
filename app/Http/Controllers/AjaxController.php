<?php
namespace App\Http\Controllers;

use App\Http\Controllers\AjaxController;
use App\Models\CompanyTerminals;
use App\Models\TravelSchedule;

class AjaxController extends Controller
{
    public function getSchedules($terminal, $date)
    {

        $destinationIds = TravelSchedule::where('departure', $terminal)
            ->whereDate('scheduled_date', $date)
            ->distinct()
            ->pluck('destination');

        $schedules = CompanyTerminals::whereIn('id', $destinationIds)
            ->pluck('terminal', 'id');

        return response()->json($schedules);
    }

    public function getDepatureTimes($terminal, $destination, $date)
    {
        $departureTimes = TravelSchedule::where('departure', $terminal)->where("destination", $destination)->whereDate("scheduled_date", $date)->pluck('scheduled_time', 'id');

        return response()->json($departureTimes);
    }
}
