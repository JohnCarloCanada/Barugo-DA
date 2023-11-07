<?php

namespace App\Listeners;

use App\Events\ClaimedSuccesful;
use App\Events\HandleError;
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
        $seed = SeedInventory::where('Seed_Variety', $event->request->Seed_Variety)->first();
        $currentSeasonThatIsActive = Season::latest()->where('Status', 'Active');

        if($seed) {
            if($seed->Quantity >= $event->request->Quantity) {
                $seed->decrement('Quantity', $event->request->Quantity);

                $currentSeasonThatIsActive->update([
                    'Quantity_of_Seeds' => SeedInventory::sum('Quantity'),
                ]);
            } else {
                HandleError::dispatch('Error Claiming ' . $seed->Seed_Variety . ' only has this remaining quantity ' . $seed->Quantity . '.');
            }
        }
    }
}
