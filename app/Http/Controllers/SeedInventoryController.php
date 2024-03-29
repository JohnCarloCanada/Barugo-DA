<?php

namespace App\Http\Controllers;

use App\Models\Season;
use App\Models\SeedInventory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SeedInventoryController extends Controller
{
    //

    public function seedInventoryIndex(Request $request): View {
        $seeds = SeedInventory::where(function($query) use ($request) {
            $query->where('Seed_Variety', 'LIKE', '%' . $request->search . '%');
        });
        return view('admin.adminpanel.seed.index', ['seeds' => $seeds->orderBy('Seed_Type', 'asc')->latest()->paginate(5), 'search' => $request->search]);
    }

    public function seedInventoryStore(Request $request): RedirectResponse {
        $request['Seed_Variety'] = preg_replace('/\s+/', ' ', $request['Seed_Variety']);
        $request['Company'] = preg_replace('/\s+/', ' ', $request['Company']);
        $request['Description'] = preg_replace('/\s+/', ' ', $request['Description']);

        $validated_rules = [
            'Seed_Type' => 'required|string|max:24',
            'Seed_Variety' => 'required|string|max:99|unique:seed_inventories,Seed_Variety',
            'Company' => 'required|string|max:99',
            'Quantity' => 'required|decimal:0,2',
            'Description' => 'nullable|string|max:255'
        ];

        $validated_data = $request->validate($validated_rules);

        $newly_added_seed = SeedInventory::create([
            'Seed_Type' => $validated_data['Seed_Type'],
            'Seed_Variety' => $validated_data['Seed_Variety'],
            'Company' => $validated_data['Company'],
            'Quantity' => $validated_data['Quantity'],
            'Description' => $validated_data['Description'],
        ]);

        $currently_active_season = Season::latest()->where('Status', 'Active')->first();

        $current_total_seeds = SeedInventory::sum('Quantity');

        if($currently_active_season) {
            $currently_active_season->update([
                'Quantity_of_Seeds' => $current_total_seeds,
            ]);
        }

        activity('Activity Logs')->causedBy(Auth::user())->performedOn($newly_added_seed)->createdAt(now())->log('- Succesfully added ' . $newly_added_seed->Quantity . 'x' . ' amount of ' . $newly_added_seed->Seed_Variety . '.');
        
        return redirect()->route('adminControlPanelSeed.index')->with('success', $newly_added_seed->Quantity . 'x' . ' amount of ' . $newly_added_seed->Seed_Variety . ' ' . 'seed succesfully added');
    }

    // Buttons
    public function seedInventoryDestroy(SeedInventory $seedInventory): RedirectResponse {
        $seed_name = $seedInventory->Seed_Variety;
        $seedInventory->delete();
        $currently_active_season = Season::latest()->where('Status', 'Active')->first();

        if($currently_active_season) {
            $currently_active_season->update([
                'Quantity_of_Seeds' => SeedInventory::sum('Quantity'),
            ]);
        }

        activity('Activity Logs')->causedBy(Auth::user())->performedOn($seedInventory)->createdAt(now())->log('- Succesfully deleted ' . $seed_name . '.');

        return redirect()->route('adminControlPanelSeed.index')->with('success', $seed_name . ' ' . 'Succesfully Deleted');
    }

    // Update Seed Information
    public function seedInventoryUpdate(Request $request): RedirectResponse {
        $request['Seed_Variety'] = preg_replace('/\s+/', ' ', $request['Seed_Variety']);
        $request['Company'] = preg_replace('/\s+/', ' ', $request['Company']);
        $request['Description'] = preg_replace('/\s+/', ' ', $request['Description']);

        $validated_rules = [
            'Seed_Type' => 'required|string|max:24',
            'Seed_Variety' => ['required', 'string', 'max:99', Rule::unique('seed_inventories')->ignore($request->id)],
            'Company' => 'required|string|max:99',
            'Quantity' => 'required|decimal:0,2',
            'NoHectare' => 'required|decimal:0,2',
            'Sacks' => 'required|decimal:0,2',
            'Description' => 'nullable|string|max:255'
        ];

        $validated_data = $request->validate($validated_rules);
        $findSeed = SeedInventory::find($request->id);

        $seed = $findSeed->update([
            'Seed_Type' => $validated_data['Seed_Type'],
            'Seed_Variety' => $validated_data['Seed_Variety'],
            'Company' => $validated_data['Company'],
            'Quantity' => $validated_data['Quantity'],
            'NoHectare' => $validated_data['NoHectare'],
            'NoBags' => $validated_data['Sacks'],
            'Description' => $validated_data['Description'],
        ]);

        $currently_active_season = Season::latest()->where('status', 'active')->first();
        if($currently_active_season) {
            $currently_active_season->update([
                'Quantity_of_Seeds' => SeedInventory::sum('Quantity'),
            ]);
        }

        activity('Activity Logs')->causedBy(Auth::user())->performedOn($findSeed)->createdAt(now())->log('- Succesfully Updated ' . $findSeed->Seed_Variety . '.');

        return redirect()->route('adminControlPanelSeed.index')->with('success', $findSeed->Seed_Variety . ' ' . 'Succesfully Updated');

    }
}
