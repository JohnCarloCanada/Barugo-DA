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
            /* 'Quantity' => 'required|decimal:0,2', */
        ];
        $validated_data = $request->validate($validated_rules);

        $area = Area::find($request->id);
        $season = Season::latest()->first();


        ClaimedSuccesful::dispatch($request, $area, $season);

        if (Session::has('error')) {
            return redirect()->route('adminSeedDistribution.index')->with('error', Session::get('error'));
        }

        $Quantity = Session::get('totalSeedsQuantityToDecrement');

        activity('Activity Logs')->causedBy(Auth::user())->createdAt(now())->log('- Lot' . $area->Lot_No . ' claimed '. $request->Seed_Variety . '.');
        return redirect()->route('adminSeedDistribution.index')->with('success', $area->Lot_No . '-' . 'succesfully claimed' . ' ' . $Quantity  . 'x' . ' amount of seeds.');
    }

    public function adminSeedIssuance(Season $season): View {
        $status = $season->Status == 'Inactive' ? 'Ended' : 'Ongoing';
        $seedsClaimedPerBrgyAndSeason = [];

        foreach ($season->seedissuancehistory as $brgy_name) {
            $seedsClaimedPerBrgyAndSeason[] = [
                'Brgy_Name' => $brgy_name->area->Owner_Address,
            ];
        }

        return view('admin.adminpanel.season.issuance', ['issuance_history' => $season->seedissuancehistory()->latest()->paginate(25), 'Season' => $season, 'season' => $season->Season, 'year' => $season->Year, 'status' => $status, 'barangay_names' => collect($seedsClaimedPerBrgyAndSeason)]);
    }

    public function adminShowClaimer(Area $area, Season $season){
        $all_areas = Area::where('Lot_No', $area->Lot_No)->get();

        foreach($all_areas as $areas) {
            foreach ($season->seedissuancehistory as $area_issuance) {
                if($areas->id == $area_issuance->area_id) {
                    return view('admin.seeddistribution.checkClaimer', ['area' => $areas, 'issuanceExist' => true]);
                }
            }
        }
        return view('admin.seeddistribution.checkClaimer', ['area' => $area, 'issuanceExist' => false]);
    }
}
