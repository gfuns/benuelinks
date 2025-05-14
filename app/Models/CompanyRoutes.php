<?php
namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CompanyRoutes extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    public function generateTags(): array
    {
        return [
            Auth::user()->station,
        ];
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
