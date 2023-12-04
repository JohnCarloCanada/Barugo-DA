<?php

namespace App\Http\Controllers;

use App\Models\Livestock;
use App\Models\PersonalInformation;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LiveStockInformationController extends Controller
{
    //

    public function userIndex(PersonalInformation $personalInformation): View {
        return view('user.managed.livestock.create', ['personalInformation' => $personalInformation]);
    }

    public function userStore(Request $request, PersonalInformation $personalInformation): RedirectResponse {
        $validation_rules = [
            'LSAnimals' => 'required|string',
            'Sex_LS' => 'required|string',
            'Livestock_Name' => 'required|string|max:99'
        ];

        $validated_data = $request->validate($validation_rules);

        $newlyaddedlivestock = Livestock::create([
            'LSAnimals' => $validated_data['LSAnimals'],
            'Sex_LS' => $validated_data['Sex_LS'],
            'Livestock_Name' => $validated_data['Livestock_Name'],
            'personal_information_id' => $personalInformation->id,
        ]);

        activity('Activity Logs')->causedBy(Auth::user())->performedOn($newlyaddedlivestock)->createdAt(now())->log('- Added a new livestock.');

        return redirect()->route('user.managedFarmersDetails', ['currentRoute' => 'livestock', 'personalInformation' => $personalInformation, 'properties' => $personalInformation->livestock])->with('success', 'Livestock Successfully Added');
    }

    public function userDestroy(Livestock $livestock): RedirectResponse {
        $livestock = $livestock;
        $personalinformation = $livestock->personalinformation;
        $livestock->delete();

        activity('Activity Logs')->causedBy(Auth::user())->performedOn($livestock)->createdAt(now())->log('- Delete a livestock.');
        return redirect()->route('user.managedFarmersDetails', ['currentRoute' => 'livestock', 'personalInformation' => $personalinformation, 'properties' => $personalinformation->livestock])->with('success', 'Livestock Successfully Deleted');
    }

    public function adminIndex(PersonalInformation $personalInformation): View {
        return view('admin.farmer.livestock.create', ['personalInformation' => $personalInformation]);
    }

    public function adminStore(Request $request, PersonalInformation $personalInformation): RedirectResponse {
        $validation_rules = [
            'LSAnimals' => 'required|string',
            'Sex_LS' => 'required|string',
            'Livestock_Name' => 'required|string|max:99'
        ];

        $validated_data = $request->validate($validation_rules);

        $newlyaddedlivestock = Livestock::create([
            'LSAnimals' => $validated_data['LSAnimals'],
            'Sex_LS' => $validated_data['Sex_LS'],
            'Livestock_Name' => $validated_data['Livestock_Name'],
            'personal_information_id' => $personalInformation->id,
        ]);

        activity('Activity Logs')->causedBy(Auth::user())->performedOn($newlyaddedlivestock)->createdAt(now())->log('- Added a new livestock.');

        return redirect()->route('admin.farmerDetails', ['currentRoute' => 'livestock', 'personalInformation' => $personalInformation, 'properties' => $personalInformation->livestock])->with('success', 'Livestock Successfully Added');
    }

    public function adminDestroy(Livestock $livestock): RedirectResponse {
        $livestock = $livestock;
        $personalinformation = $livestock->personalinformation;
        $livestock->delete();

        activity('Activity Logs')->causedBy(Auth::user())->performedOn($livestock)->createdAt(now())->log('- Delete a livestock.');
        return redirect()->route('admin.farmerDetails', ['currentRoute' => 'livestock', 'personalInformation' => $personalinformation, 'properties' => $personalinformation->livestock])->with('success', 'Livestock Successfully Deleted');
    }
}
