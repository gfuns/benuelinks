<?php
namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class UserPermission extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    public function generateTags(): array
    {
        return [
            Auth::user()->station,
        ];
    }

    public function feature()
    {
        return $this->belongsTo('App\Models\PlatformFeature', "feature_id");
    }
}
