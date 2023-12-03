<?php

namespace App\Http\Controllers;

use App\Models\Area;
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
            $temp_options = Option::withTrashed()->paginate(5);
        } elseif($currentRoute == 'Religion') {
            $temp_options = Option::withTrashed()->where('Option_Name', 'Religion')->paginate(5);
        } else {
            $temp_options = Option::withTrashed()->where('Option_Name', 'Livelihood')->paginate(5);
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

        activity('Activity Logs')->causedBy(Auth::user())->performedOn($NewlyCreated)->createdAt(now())->log('- Added a new ' . $NewlyCreated->Option_Name . '.');

        return redirect()->route('adminControlPanelSurvey.survey', ['currentRoute' => 'All'])->with('success', $NewlyCreated->Name . ' ' . $NewlyCreated->Option_Name . ' ' . 'Successfully Added');
    }


    // Buttons
    public function surveyQuestionsDestroy(string $id): RedirectResponse {
        $option = Option::withTrashed()->findOrFail($id);
        $option_name = $option->Option_Name;
        $option->forceDelete();

        activity('Activity Logs')->causedBy(Auth::user())->performedOn($option)->createdAt(now())->log('- Deleted a ' . $option_name . '.');

        return redirect()->route('adminControlPanelSurvey.survey', ['currentRoute' => 'All'])->with('success', $option_name . ' ' . 'Successfully Deleted');
    }

    public function surveyQuestionsDisable(Option $option): RedirectResponse {
        $option = $option;
        $option_name = $option->Option_Name;
        $option->delete();

        activity('Activity Logs')->causedBy(Auth::user())->performedOn($option)->createdAt(now())->log('- Disabled a ' . $option_name . '.');

        return redirect()->route('adminControlPanelSurvey.survey', ['currentRoute' => 'All'])->with('success', $option_name . ' ' . 'Successfully Disabled');
    }

    public function surveyQuestionsRestore(string $id): RedirectResponse {
        $option = Option::withTrashed()->findOrFail($id);
        $option_name = $option->Option_Name;
        $option->restore();

        activity('Activity Logs')->causedBy(Auth::user())->performedOn($option)->createdAt(now())->log('- Restored a ' . $option_name . '.');

        return redirect()->route('adminControlPanelSurvey.survey', ['currentRoute' => 'All'])->with('success', $option_name . ' ' . 'Successfully Restored');
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
        
        $currentYear = now()->year;
        $season = new Season();

        /* This code block is responsible for adding a new season to the database. */
        if($season->checkIfRecordExists($currentYear, $validated_data['Season'])) {
            return redirect()->route('adminControlPanelSeason.season')->with('error', "Error Adding New Season - Season Already Exist or Can't Have 3 Seasons In A Single Year!");
        } else {
            $totalSeeds = SeedInventory::sum('Quantity');
            $lastSeason = Season::latest()->first();

            if($lastSeason && $lastSeason->Status == 'Active') {
                $lastSeason->update([
                    'Status' => 'Inactive',
                ]);
            }

            Area::where('is_claimed', 1)->update([
                'is_claimed' => 0,
            ]);

            $newly_added_season = Season::create([
                'Season' => $validated_data['Season'],
                'Quantity_of_Seeds' => $totalSeeds,
                'Year' => now()->year,
            ]);
            activity('Activity Logs')->causedBy(Auth::user())->performedOn($newly_added_season)->createdAt(now())->log('- ' . $newly_added_season->Year . '-' . $newly_added_season->Season . ' ' . 'Succesfully Added');
            return redirect()->route('adminControlPanelSeason.season')->with('success', $newly_added_season->Year . '-' . $newly_added_season->Season . ' ' . 'Succesfully Added');
        } 
    }

    public function seasonDistrubutionEnd(Season $season): RedirectResponse {
        $Season = $season->Season;
        $Year = $season->Year;
        $season->Status = 'Inactive';
        $season->save();

        Area::where('is_claimed', 1)->update([
            'is_claimed' => 0,
        ]);

        activity('Activity Logs')->causedBy(Auth::user())->performedOn($season)->createdAt(now())->log('- ' . $Year . '-' . $Season . ' ' . 'Has Ended!');

        return redirect()->route('adminControlPanelSeason.season')->with('success', $Year . '-' . $Season . ' ' . 'Has Ended!');
    }

    public function seasonDistributionReEnd(Season $season) {
        $Season = $season->Season;
        $Year = $season->Year;
        
        $areas = Area::get();
        foreach ($areas as $area) {
            if($area->is_claimed == 1) {
                continue;
            } else {
                foreach ($season->seedissuancehistory as $seedissuancehistory) {
                    Area::where('Lot_No', $seedissuancehistory->area->Lot_No)->update([
                        'is_claimed' => 1,
                    ]);
                }
            }
        }
        $season->Status = 'Active';
        $season->save();
        activity('Activity Logs')->causedBy(Auth::user())->performedOn($season)->createdAt(now())->log('- ' . $Year . '-' . $Season . ' ' . 'Cancelled the end of season!');
        return redirect()->route('adminControlPanelSeason.season')->with('success', $Year . '-' . $Season . ' ' . 'Cancelled the end of season!');
    }

    public function seasonDistrubutionEdit(Request $request): RedirectResponse {
        $validation_rules = [
            'Season' => 'required|string|max:24',
        ];
        $validated_data = $request->validate($validation_rules);

        $current_year_inactve_season = Season::where('Year', now()->year)->where('Status', 'Inactive')->first();
        $findSeason = Season::find($request->id);

        if($current_year_inactve_season) {
            if($validated_data['Season'] == $current_year_inactve_season->Season) {
                return redirect()->route('adminControlPanelSeason.season')->with('error', "Error Adding New Season - Season Already Exist or Can't Have 3 Seasons In A Single Year!");
            }

            $findSeason->Season = $validated_data['Season'];
            $findSeason->save();
            activity('Activity Logs')->causedBy(Auth::user())->performedOn($findSeason)->createdAt(now())->log('- Edited a season.');
            return redirect()->route('adminControlPanelSeason.season')->with('success', 'Succesfully Edited!');
        } else {
            $findSeason->Season = $validated_data['Season'];
            $findSeason->save();
            activity('Activity Logs')->causedBy(Auth::user())->performedOn($findSeason)->createdAt(now())->log('- Edited a season.');
            return redirect()->route('adminControlPanelSeason.season')->with('success', 'Succesfully Edited!');
        }
    }
}
