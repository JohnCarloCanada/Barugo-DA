<?php

namespace App\Listeners;

use App\Events\ClaimedSuccesful;
use App\Models\Season;
use App\Models\SeedInventory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateInventoryAfterClaiming
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
        $seed = SeedInventory::where('Seed_Variety', $event->request->Seed_Variety);
        $currentSeasonThatIsActive = Season::latest()->where('Status', 'Active');
        if($seed) {
            $seed->decrement('Quantity', $event->request->Quantity);
        }
        $currentSeasonThatIsActive->update([
            'Quantity_of_Seeds' => SeedInventory::sum('Quantity'),
        ]);
    }
}
