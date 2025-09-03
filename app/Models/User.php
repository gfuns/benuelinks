<?php
namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Jobs\SendEmailVerificationCode;
use App\Models\CustomerOtp;
use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;

class User extends Authenticatable implements Auditable
{
    use HasApiTokens, HasFactory, Notifiable;
    use \OwenIt\Auditing\Auditable;

    /**
     * {@inheritdoc}
     */
    public function generateTags(): array
    {
        if (Auth::user()) {
            return [
                Auth::user()->station,
            ];
        } else {
            return [];
        }
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'last_name',
        'other_names',
        'email',
        'phone_number',
        'password',
        'referral_channel',
        'referral_code',
        'role_id',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    public static function booted()
    {
        static::created(function ($user) {
            $user->referral_code = User::generateReferralCode($user->id);
            $user->save();

            if (request()->input('referral_code') != null) {
                $referee = User::where("referral_code", request()->input('referral_code'))->first();
                if (isset($referee)) {
                    $user->referral_id = $referee->id;
                    $user->save();
                }
            }

            if ($user->role_id == 2) {
                $otp = CustomerOtp::updateOrCreate(
                    [
                        'user_id'  => $user->id,
                        'otp_type' => 'email',
                    ], [
                        'otp'            => User::generateOtp(),
                        'otp_expiration' => Carbon::now()->addMinutes(5),
                    ]);

                if ($otp) {
                    SendEmailVerificationCode::dispatch($otp);
                }
            }
        });
    }

    /**
     * generateOtp
     *
     * @return void
     */
    public static function generateOtp()
    {
        $pin = range(0, 9);
        $set = shuffle($pin);
        $otp = "";
        for ($i = 0; $i < 4; $i++) {
            $otp = $otp . "" . $pin[$i];
        }

        return $otp;
    }

    /**
     * generateReferralCode
     *
     * @param mixed id
     *
     * @return void
     */
    public static function generateReferralCode($id)
    {

        if (strlen($id) == 1) {
            return "PMT0000" . $id;
        } else if (strlen($id) == 2) {
            return "PMT000" . $id;
        } else if (strlen($id) == 3) {
            return "PMT00" . $id;
        } else if (strlen($id) == 4) {
            return "PMT0" . $id;
        } else if (strlen($id) == 5) {
            return "PMT" . $id;
        }

    }

    public function terminal()
    {
        return $this->belongsTo('App\Models\CompanyTerminals', 'station');
    }

    public function userRole()
    {
        return $this->belongsTo('App\Models\UserRole', 'role_id');
    }

    public function group()
    {
        return $this->belongsTo('App\Models\WorkGroup', "work_group_id");
    }
}
