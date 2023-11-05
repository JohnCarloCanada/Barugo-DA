<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\Models\PersonalInformation;
use App\Models\Season;
use App\Models\SeedInventory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminControlPanelController extends Controller
{
    //

    // Survey Page
    public function surveyQuestionsIndex(string $currentRoute): View {
        if($currentRoute == 'All') {
            $temp_options = Option::paginate(5);
        } elseif($currentRoute == 'Religion') {
            $temp_options = Option::where('Option_Name', 'Religion')->paginate(5);
        } else {
            $temp_options = Option::where('Option_Name', 'Livelihood')->paginate(5);
        }
        
        $options = ['options' => $temp_options, 'currentRoute' => $currentRoute];

        return view('admin.adminpanel.survey.index', $options);
    }

    public function surveyQuestionsStore(Request $request): RedirectResponse {
        $validation_rules = [
            'Option_Name' => 'required|string|max:24',
            'Name' => 'required|string|max:64|unique:options,Name',
        ];

        $validated_data = $request->validate($validation_rules);

        $capitalizedName = ucwords($validated_data['Name']);
        $capitalizedOptionName = ucwords($validated_data['Option_Name']);

        $NewlyCreated = Option::create([
            'Option_Name' => $capitalizedOptionName,
            'Name' => $capitalizedName,
        ]);

        activity()->causedBy(Auth::user())->performedOn($NewlyCreated)->createdAt(now())->log('added a new ' . $NewlyCreated->Option_Name . '.');

        return redirect()->route('adminControlPanelSurvey.survey', ['currentRoute' => 'All'])->with('success', $NewlyCreated->Name . ' ' . $NewlyCreated->Option_Name . ' ' . 'Successfully Added');
    }

    public function surveyQuestionsDestroy(Option $option): RedirectResponse {
        $option = $option;
        $option_name = $option->Option_Name;
        $option->delete();

        activity()->causedBy(Auth::user())->performedOn($option)->createdAt(now())->log('deleted a ' . $option_name . '.');

        return redirect()->route('adminControlPanelSurvey.survey', ['currentRoute' => 'All'])->with('success', $option_name . ' ' . 'Successfully Deleted');
    }

    // Season Page
    public function seasonDistrubutionIndex(): view {
        return view('admin.adminpanel.season.index', ['seasons' => Season::latest()->paginate(5)]);
    }

    public function seasonDistrubutionStore(Request $request): RedirectResponse {
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

        $newly_added_season = Season::create([
            'Season' => $validated_data['Season'],
            'Quantity_of_Seeds' => $current_total_seeds,
            'Year' => now()->year,
        ]);

        activity()->causedBy(Auth::user())->performedOn($newly_added_season)->createdAt(now())->log($newly_added_season->Year . '-' . $newly_added_season->Season . ' ' . 'Succesfully Added');

        return redirect()->route('adminControlPanelSeason.season')->with('success', $newly_added_season->Year . '-' . $newly_added_season->Season . ' ' . 'Succesfully Added');
    }

    public function seasonDistrubutionEnd(Season $season): RedirectResponse {
        $Season = $season->Season;
        $Year = $season->Year;
        $season->Status = 'Inactive';
        $season->save();

        PersonalInformation::where('is_claimed', 1)->update([
            'is_claimed' => 0,
        ]);

        activity()->causedBy(Auth::user())->performedOn($season)->createdAt(now())->log($Year . '-' . $Season . ' ' . 'Has Ended!');

        return redirect()->route('adminControlPanelSeason.season')->with('success', $Year . '-' . $Season . ' ' . 'Has Ended!');
    }

    public function seasonDistrubutionEdit(Request $request): RedirectResponse {
        $validation_rules = [
            'Season' => 'required|string|max:24',
        ];
        $validated_data = $request->validate($validation_rules);
        $findSeason = Season::find($request->id);
        $findSeason->Season = $validated_data['Season'];
        $findSeason->save();

        activity()->causedBy(Auth::user())->performedOn($findSeason)->createdAt(now())->log('edited a season.');

        return redirect()->route('adminControlPanelSeason.season')->with('success', 'Succesfully Edited!');
    }
}
