<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempPaymentBeneficiary extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'file_id',
        'account_name',
        'account_number',
        'bank_code',
        'bank_name',
        'tracking_code',
        'amount',
        'imported',
        'comment',
    ];
}
