<?php

namespace App\Listeners;

use App\Events\HandleUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

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
        activity()->causedBy($user)->createdAt(now())->log('logged Out');
    }
}
