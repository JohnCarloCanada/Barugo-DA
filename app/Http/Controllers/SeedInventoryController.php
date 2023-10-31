<?php

namespace App\Http\Controllers;

use App\Models\Season;
use App\Models\SeedInventory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SeedInventoryController extends Controller
{
    //
    public function seedInventoryStore(Request $request): RedirectResponse {
        $validated_rules = [
            'Seed_Type' => 'required|string|max:24',
            'Seed_Variety' => 'required|string|max:99|unique:seed_inventories,Seed_Variety',
            'Company' => 'required|string|max:99',
            'Quantity' => 'required|numeric',
        ];
        $validated_data = $request->validate($validated_rules);
        $newly_added_seeds = SeedInventory::create($validated_data);
        $currently_active_season = Season::latest()->first();
        $current_total_seeds = $currently_active_season->Quantity_of_Seeds + $newly_added_seeds->Quantity;
        $currently_active_season->update([
            'Quantity_of_Seeds' => $current_total_seeds,
        ]);

        return redirect()->route('adminControlPanelSeed.seed')->with('success', 'Seed Succesfully Added');
    }
}
