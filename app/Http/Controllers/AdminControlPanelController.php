<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\Models\PersonalInformation;
use App\Models\Season;
use App\Models\SeedInventory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminControlPanelController extends Controller
{
    //

    // Survey Page
    public function surveyQuestionsIndex(string $currentRoute): View {
        if($currentRoute == 'All') {
            return view('admin.adminpanel.survey.index', ['options' => Option::paginate(5), 'currentRoute' => 'All']);
        } elseif($currentRoute == 'Religion') {
            return view('admin.adminpanel.survey.index', ['options' => Option::where('Option_Name', 'Religion')->paginate(5), 'currentRoute' => 'Religion']);
        } else {
            return view('admin.adminpanel.survey.index', ['options' => Option::where('Option_Name', 'Livelihood')->paginate(5), 'currentRoute' => 'Livelihood']);
        }
    }

    public function surveyQuestionsStore(Request $request): RedirectResponse {
        $validation_rules = [
            'Option_Name' => 'required|string|max:24',
            'Name' => 'required|string|max:64|unique:options,Name',
        ];

        $validated_data = $request->validate($validation_rules);

        $capitalizedName = ucwords($validated_data['Name']);
        $capitalizedOptionName = ucwords($validated_data['Option_Name']);

        Option::create([
            'Option_Name' => $capitalizedOptionName,
            'Name' => $capitalizedName,
        ]);

        return redirect()->route('adminControlPanelSurvey.survey', ['currentRoute' => 'All'])->with('success', 'Option Successfully Added');
    }

    public function surveyQuestionsDestroy(Option $option): RedirectResponse {
        $option->delete();
        return redirect()->route('adminControlPanelSurvey.survey', ['currentRoute' => 'All'])->with('success', 'Option Successfully Deleted');
    }

    // Seed Distributions Page
    public function seedDistrubutionIndex(): view {
        return view('admin.adminpanel.seed.index', ['seasons' => Season::latest()->paginate(5)]);
    }

    public function seedDistrubutionStore(Request $request): RedirectResponse {
        $validation_rules = [
            'Season' => 'required|string|max:24',
        ];
        $validated_data = $request->validate($validation_rules);

        $lastSeason = Season::latest()->first();

        if($lastSeason) {
            $lastSeason->update([
                'Status' => 'Inactive',
            ]);
        }

        PersonalInformation::where('is_claimed', 1)->update([
            'is_claimed' => 0,
        ]);

        
        $totalSeeds = SeedInventory::sum('Quantity');
        $current_total_seeds = 0;

        if($lastSeason && $lastSeason->Quantity_of_Seeds === $totalSeeds) {
            $current_total_seeds = $lastSeason->Quantity_of_Seeds;
        } else {
            $current_total_seeds = $totalSeeds;
        }

        Season::create([
            'Season' => $validated_data['Season'],
            'Quantity_of_Seeds' => $current_total_seeds,
            'Year' => now()->year,
        ]);

        return redirect()->route('adminControlPanelSeed.seed')->with('success', 'Season Succesfull Added');
    }

    public function seedDistrubutionEnd(Season $season): RedirectResponse {
        $season->Status = 'Inactive';
        $season->save();

        PersonalInformation::where('is_claimed', 1)->update([
            'is_claimed' => 0,
        ]);

        return redirect()->route('adminControlPanelSeed.seed');
    }

    public function seedDistrubutionEdit(Request $request): RedirectResponse {
        $validation_rules = [
            'Season' => 'required|string|max:24',
        ];
        $validated_data = $request->validate($validation_rules);
        $findSeason = Season::find($request->id);
        $findSeason->Season = $validated_data['Season'];
        $findSeason->save();

        return redirect()->route('adminControlPanelSeed.seed');
    }
}
