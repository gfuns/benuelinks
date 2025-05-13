<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelBooking extends Model
{
    use HasFactory;

    public function departurePoint()
    {
        return $this->belongsTo('App\Models\CompanyTerminals', "departure");

    }

    public function destinationPoint()
    {
        return $this->belongsTo('App\Models\CompanyTerminals', "destination");
    }

    public function travelRoute()
    {
        $terminal    = $this->departurePoint->terminal;
        $destination = $this->destinationPoint->terminal;

        return $terminal . " => " . $destination;
    }
}
