<?php

namespace App\Listeners;

use App\Events\ClaimedSuccesful;
use App\Models\PersonalInformation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
        $farmer = PersonalInformation::find($event->request->id);
        $farmer->is_claimed = true;
        $farmer->update();
    }
}
