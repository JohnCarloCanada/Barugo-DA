<?php

namespace App\Http\Controllers;

use App\Events\ClaimedSuccesful;
use App\Models\PersonalInformation;
use App\Models\Season;
use App\Models\SeedInventory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminSeedDistributionController extends Controller
{
    //
    public function adminIndex(Request $request): View {
        $farmers = PersonalInformation::where(function($query) use ($request) {
            $query->where('RSBSA_No', 'LIKE', '%' . $request->search . '%');
        });

        return view('admin.seeddistribution.index', ['farmers' => $farmers->latest()->paginate(10), 'options' => SeedInventory::get(), 'search' => $request->search, 'seasons' => Season::latest()->first()]);
    } 

    public function adminSeedClaiming(Request $request): RedirectResponse {
        $validated_rules = [
            'Seed_Variety' => 'required|string|max:99',
            'Quantity' => 'required|string|max:99|unique:seed_inventories,Seed_Variety',
        ];
        $request->validate($validated_rules);
        ClaimedSuccesful::dispatch($request);
        return redirect()->route('adminSeedDistribution.index')->with('success', 'Seed Succesfully Claimed');
    }
}
