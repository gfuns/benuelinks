<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthenticationLogs extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function terminal()
    {
        return $this->belongsTo('App\Models\CompanyTerminals', 'station');
    }

    protected $fillable = [
        'user_id',
        'station',
        'event',
        'description',
        'ip_address',
        'user_agent',
    ];
}
