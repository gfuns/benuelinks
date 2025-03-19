<?php
namespace App\Listeners;

use App\Models\AuthenticationLogs;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Auth;

class LogUserAuthentication
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $eventType   = get_class($event);
        $description = '';
        $userId      = Auth::user()->id;
        $workGroup   = Auth::user()->work_group_id;

        if ($event instanceof Login) {
            $eventType   = 'Login';
            $description = 'User logged In';
        } elseif ($event instanceof Logout) {
            $eventType   = 'Logout';
            $description = 'User logged Out';
        }

        AuthenticationLogs::create([
            'user_id'     => $userId,
            'event'       => $eventType,
            'description' => $description,
            'ip_address'  => request()->ip(),
            'user_agent'  => request()->userAgent(),
        ]);

    }
}
