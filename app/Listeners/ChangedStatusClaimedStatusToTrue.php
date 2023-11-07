<?php

namespace App\Listeners;

use App\Events\ClaimedSuccesful;
use App\Models\Area;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Session;

class ChangedStatusClaimedStatusToTrue
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
    public function handle(ClaimedSuccesful $event): void
    {
        //
        if (Session::has('error')) {
            return;
        } else {
            Area::where('Lot_No', $event->request->id)->update([
                'is_claimed' => 1, 
            ]);
        }
    }
}
