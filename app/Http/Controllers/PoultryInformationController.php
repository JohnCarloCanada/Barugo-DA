<?php

namespace App\Http\Controllers;

use App\Models\PersonalInformation;
use App\Models\Poultry;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PoultryInformationController extends Controller
{
    //
    public function userIndex(PersonalInformation $personalInformation): View {
        return view('user.managed.poultry.create', ['personalInformation' => $personalInformation]);
    }

    public  function userStore(Request $request, PersonalInformation $personalInformation): RedirectResponse {
        $validation_rules = [
            'Poultry_Type' => 'required|string|max:99',
            'Quantity' => 'required|numeric',
        ];

        $validated_data = $request->validate($validation_rules);

        $newlyaddedpoultry = Poultry::create([
            'Poultry_Type' => $validated_data['Poultry_Type'],
            'Quantity' => $validated_data['Quantity'],
            'personal_information_id' => $personalInformation->id,
        ]);

        activity()->causedBy(Auth::user())->performedOn($newlyaddedpoultry)->createdAt(now())->log('- Added a new poultry.');
        return redirect()->route('user.managedFarmersDetails', ['currentRoute' => 'poultry', 'personalInformation' => $personalInformation, 'properties' => $personalInformation->poultry])->with('success', 'Poultry Successfully Added');
    }

    public function userDestroy(Poultry $poultry): RedirectResponse {
        $poultry = $poultry;
        $personalinformation = $poultry->personalinformation;
        $poultry->delete();

        activity()->causedBy(Auth::user())->performedOn($poultry)->createdAt(now())->log('- Delete a poultry.');
        return redirect()->route('user.managedFarmersDetails', ['currentRoute' => 'poultry', 'personalInformation' => $personalinformation, 'properties' => $personalinformation->poultry])->with('success', 'Poultry Successfully Deleted');
    }

    public function adminIndex(PersonalInformation $personalInformation): View {
        return view('admin.farmer.poultry.create', ['personalInformation' => $personalInformation]);
    }

    public  function adminStore(Request $request, PersonalInformation $personalInformation): RedirectResponse {
        $validation_rules = [
            'Poultry_Type' => 'required|string|max:99',
            'Quantity' => 'required|numeric',
        ];

        $validated_data = $request->validate($validation_rules);

        $newlyaddedpoultry = Poultry::create([
            'Poultry_Type' => $validated_data['Poultry_Type'],
            'Quantity' => $validated_data['Quantity'],
            'personal_information_id' => $personalInformation->id,
        ]);

        activity()->causedBy(Auth::user())->performedOn($newlyaddedpoultry)->createdAt(now())->log('- Added a new poultry.');

        return redirect()->route('admin.farmerDetails', ['currentRoute' => 'poultry', 'personalInformation' => $personalInformation, 'properties' => $personalInformation->poultry])->with('success', 'Poultry Successfully Added');
    }

    public function adminDestroy(Poultry $poultry): RedirectResponse {
        $poultry = $poultry;
        $personalinformation = $poultry->personalinformation;
        $poultry->delete();

        activity()->causedBy(Auth::user())->performedOn($poultry)->createdAt(now())->log('- Delete a poultry.');
        return redirect()->route('admin.farmerDetails', ['currentRoute' => 'poultry', 'personalInformation' => $personalinformation, 'properties' => $personalinformation->poultry])->with('success', 'Poultry Successfully Deleted');
    }
}
