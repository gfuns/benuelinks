<?php
namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class TravelSchedule extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    public function generateTags(): array
    {
        return [
            Auth::user()->station,
        ];
    }

    public function getvehicle()
    {
        if (isset($this->vehicle)) {
            $vehicle = $this->vehicledetail;
            return $vehicle->vehicle_number . "<br/> (" . $vehicle->manufacturer . " " . $vehicle->model . ")";
        } else {
            return "Awaiting Vehicle Assignment";
        }
    }

    public function getvehicleType()
    {
        if (isset($this->vehicle)) {
            $vehicle = $this->vehicledetail;
            return $vehicle->manufacturer . " " . $vehicle->model;
        } else {
            return "Hummer Bumper Bus";
        }
    }

    public function getdriver()
    {
        if (isset($this->vehicle)) {
            $driver = User::find($this->vehicledetail->driver);
            if (isset($driver)) {
                return $driver->last_name . ", " . $driver->other_names . "<br/> (" . $driver->phone_number . ")";
            } else {
                return "A Driver is yet to be assigned to this Vehicle";
            }

        } else {
            return "Awaiting Vehicle Assignment";
        }
    }

    public function vehicledetail()
    {
        return $this->belongsTo('App\Models\CompanyVehicles', "vehicle");

    }

    public function ticketerdetail()
    {
        return $this->belongsTo('App\Models\User', "ticketer");

    }

    public function travelRoute()
    {
        $terminal    = $this->departurePoint->terminal;
        $destination = $this->destinationPoint->terminal;

        return $terminal . " => " . $destination;
    }

    public function transportFare()
    {
        $route = CompanyRoutes::where("departure", $this->departure)->where("destination", $this->destination)->first();

        return $route->transport_fare ?? 0;
    }

    public function bookedSeats()
    {
        $bookedSeats = TravelBooking::where("schedule_id", $this->id)->where("payment_status", "paid")->pluck("seat")->map(fn($seat) => (int) $seat) // ensure they are integers
            ->values()
            ->toArray();

        return $bookedSeats;
    }

    public function availableSeats()
    {
        $bookedSeats = TravelBooking::where("schedule_id", $this->id)
            ->where("payment_status", "paid")
            ->pluck("seat")
            ->flatMap(function ($seat) {
                return collect(explode(',', $seat))
                    ->map(fn($s) => (int) trim($s));
            })
            ->unique()
            ->values()
            ->toArray();
        $bookings = count($bookedSeats);

        return (16 - $bookings);
    }

    public function departurePoint()
    {
        return $this->belongsTo('App\Models\CompanyTerminals', "departure");

    }

    public function destinationPoint()
    {
        return $this->belongsTo('App\Models\CompanyTerminals', "destination");
    }

    public function passengers()
    {
        $boardedPassengers = TravelBooking::where("schedule_id", $this->id)->where("boarding_status", "boarded")->count();
        $vehicle           = CompanyVehicles::find($this->vehicle);
        $vehicleCapacity   = isset($vehicle) ? $vehicle->seats : "Undefined";
        return $boardedPassengers . " / " . $vehicleCapacity;
    }

    public function travelFare()
    {
        $route = CompanyRoutes::where("departure", $this->departure)->where("destination", $this->destination)->first();
        return number_format($route->transport_fare, 2);
    }

    public function generatedRevenue()
    {
        $revenue = TravelBooking::where("schedule_id", $this->id)->where("boarding_status", "boarded")->sum("travel_fare");
        return number_format($revenue, 2);
    }
}
