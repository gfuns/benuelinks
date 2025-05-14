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
            return "Pending";
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

    public function travelRoute()
    {
        $terminal    = $this->departurePoint->terminal;
        $destination = $this->destinationPoint->terminal;

        return $terminal . " => " . $destination;
    }

    public function departurePoint()
    {
        return $this->belongsTo('App\Models\CompanyTerminals', "departure");

    }

    public function destinationPoint()
    {
        return $this->belongsTo('App\Models\CompanyTerminals', "destination");
    }
}
