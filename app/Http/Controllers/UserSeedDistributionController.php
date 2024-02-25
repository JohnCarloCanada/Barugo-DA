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

class UserSeedDistributionController extends Controller
{
    //
    public function userIndex(Request $request): View {
        $farmers = Area::where(function($query) use ($request) {
            $query->where('Lot_No', 'LIKE', '%' . $request->search . '%');
        });

        return view('user.seeddistribution.index', ['farmers_lot_no' => $farmers->latest()->paginate(10), 'options' => SeedInventory::get(), 'search' => $request->search, 'seasons' => Season::latest()->first()]);
    } 

    public function userSeedClaiming(Request $request): RedirectResponse {
        $validated_rules = [
            'Seed_Variety' => 'required|string|max:99',
            /* 'Quantity' => 'required|decimal:0,2', */
        ];

        $request->validate($validated_rules);

        $area = Area::find($request->id);
        $season = Season::latest()->first();

        ClaimedSuccesful::dispatch($request, $area, $season);

        if (Session::has('error')) {
            return redirect()->route('userSeedDistribution.index')->with('error', Session::get('error'));
        }

        $Quantity = Session::get('totalSeedsQuantityToDecrement');

        activity('Activity Logs')->causedBy(Auth::user())->createdAt(now())->log('- Lot' . $area->Lot_No . ' claimed '. $request->Seed_Variety . '.');
        return redirect()->route('userSeedDistribution.index')->with('success', $area->Lot_No . '-' . 'succesfully claimed' . ' ' . $Quantity  . 'x' . ' amount of seeds.');
    }

    public function userShowClaimer(Area $area, Season $season){
        $all_areas = Area::where('Lot_No', $area->Lot_No)->get();

        foreach($all_areas as $areas) {
            foreach ($season->seedissuancehistory as $area_issuance) {
                if($areas->id == $area_issuance->area_id) {
                    return view('user.seeddistribution.checkClaimer', ['area' => $areas, 'issuanceExist' => true]);
                }
            }
        }
        return view('user.seeddistribution.checkClaimer', ['area' => $area, 'issuanceExist' => false]);
    }
}
