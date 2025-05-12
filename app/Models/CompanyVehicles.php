<?php
namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CompanyVehicles extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    public function generateTags(): array
    {
        return [
            Auth::user()->station,
        ];
    }

    public function getdriver()
    {
        if (isset($this->driver)) {
            $driver = User::find($this->driver);
            if (isset($driver)) {
                return $driver->last_name . ", " . $driver->other_names . "<br/>" . $driver->phone_number;
            }

            return null;

        } else {
            return "A Driver is yet to be assigned to this Vehicle";
        }
    }
}
