<?php

namespace App\Listeners;

use DateTime;
use App\Events\HandleUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HandleUserLogout
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
    public function handle(HandleUser $event): void
    {
        //
        $user = Auth::user();
        Auth::guard('web')->logout();
        $event->request->session()->invalidate();
        $event->request->session()->regenerateToken();

        // DA System Logs
        activity('Activity Logs')->causedBy($user)->createdAt(now())->log('- Logged Out');

        // HRMS User Logs
        $todayDate = new DateTime();
        $user_id = $user->id;
        $activityLog = ['user_id'=> $user_id, 'description' => 'Has log out', 'date_time' => $todayDate->format('D, M j, Y g:i A'), 'created_at' => now(), 'updated_at' => now()];
        DB::connection('secondary')->table('user_logs')->insert($activityLog);
    }
}
