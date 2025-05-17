<?php
namespace App\Jobs;

use App\Mail\PasswordResetMail as PasswordResetMail;
use App\Models\CustomerOtp;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;

class SendPasswordResetMail
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $otp;
    /**
     * Create a new job instance.
     */
    public function __construct(CustomerOtp $otp)
    {
        $this->otp = $otp;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $otp  = $this->otp;
        $user = User::find($otp->user_id);

        try {
            Mail::to($user)->send(new PasswordResetMail($user, $otp->otp));
        } catch (\Exception $e) {
            report($e);
        }
    }
}
