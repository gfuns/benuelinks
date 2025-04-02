<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralSettings extends Model
{
    use HasFactory;

    public static function scopeApiKey($query)
    {
        return $query->where("setting", "api_key")->first();
    }
}
