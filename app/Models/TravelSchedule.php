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

    public function departurePoint()
    {
        return $this->belongsTo('App\Models\CompanyTerminals', "departure");

    }

    public function destinationPoint()
    {
        return $this->belongsTo('App\Models\CompanyTerminals', "destination");
    }
}
