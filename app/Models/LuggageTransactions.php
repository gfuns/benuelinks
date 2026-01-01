<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LuggageTransactions extends Model
{
    use HasFactory;

    public function departurePoint()
    {
        return $this->belongsTo('App\Models\CompanyTerminals', "terminal_id");

    }

    public function booking()
    {
        return $this->belongsTo('App\Models\TravelBooking', "booking_id");

    }

    public function ticketerdetail()
    {
        return $this->belongsTo('App\Models\User', "ticketer");

    }
}
