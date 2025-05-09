<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditTrails extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'audits';

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function station()
    {
        $station = CompanyTerminals::find($this->tags);
        return $station->terminal;
    }

    public function event()
    {
        if ($this->event == "created") {
            return "New Record Creation";
        } else if ($this->event == "updated") {
            return "Record Update";
        } else if ($this->event == "deleted") {
            return "Record Deletion";
        } else if ($this->event == "restored") {
            return "Record Restoration";
        } else {
            return "Record Retrieval";
        }
    }

    public function oldValues()
    {
        $jsonString = json_encode($this->old_values);

        // Replace braces with square brackets and colons with " : "
        $string = trim(stripslashes(str_replace(['{', '}', ':'], ['[', ']', ' : '], $jsonString)), '"');

        return $string;
    }

    public function newValues()
    {
        $jsonString = json_encode($this->new_values);

        // Replace braces with square brackets and colons with " : "
        $string = trim(stripslashes(str_replace(['{', '}', ':'], ['[', ']', ' : '], $jsonString)), '"');

        return $string;
    }
}
