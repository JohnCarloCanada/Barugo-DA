<?php

namespace App\Listeners;

use App\Events\ClaimedSuccesful;
use App\Models\SeedIssuanceHistory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Session;

class CreateIssuanceHistory
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
        $totalSeedsQuantityToDecrement = Session::get('totalSeedsQuantityToDecrement');
        if(Session::has('error')) {
            return;
        } else {
            $newly_created_seed_issuance = SeedIssuanceHistory::create([
                'season_id' => $event->season->id,
                'area_id' => $event->area->id,
                'Seed_Variety' => $event->request->Seed_Variety,
                'Quantity' => $totalSeedsQuantityToDecrement
            ]);
        }
    }
}
