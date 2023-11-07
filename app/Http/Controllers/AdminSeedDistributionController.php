<?php

namespace App\Http\Controllers;

use App\Events\ClaimedSuccesful;
use App\Models\Area;
use App\Models\PersonalInformation;
use App\Models\Season;
use App\Models\SeedInventory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminSeedDistributionController extends Controller
{
    //
    public function adminIndex(Request $request): View {
        $farmers = Area::where(function($query) use ($request) {
            $query->where('Lot_No', 'LIKE', '%' . $request->search . '%');
        });

        return view('admin.seeddistribution.index', ['farmers_lot_no' => $farmers->latest()->paginate(10), 'options' => SeedInventory::get(), 'search' => $request->search, 'seasons' => Season::latest()->first()]);
    } 

    public function adminSeedClaiming(Request $request): RedirectResponse {
        $validated_rules = [
            'Seed_Variety' => 'required|string|max:99',
            'Quantity' => 'required|string|max:99|unique:seed_inventories,Seed_Variety',
        ];
        $validated_date = $request->validate($validated_rules);
        ClaimedSuccesful::dispatch($request);

        if (Session::has('error')) {
            return redirect()->route('adminSeedDistribution.index')->with('error', Session::get('error'));
        }

        activity()->causedBy(Auth::user())->createdAt(now())->log('- Lot' . $request->id . ' claimed '. $request->Seed_Variety . '.');
        return redirect()->route('adminSeedDistribution.index')->with('success', $request->id . '-' . 'succesfully claimed' . ' ' . $validated_date['Quantity']  . 'x' . ' amount of seeds.');
    }
}
