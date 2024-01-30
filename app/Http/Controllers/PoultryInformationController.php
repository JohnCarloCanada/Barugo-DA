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

        $poultries = $personalInformation->poultry()->latest()->get();

        // Create when certain poultry and gender exist
        foreach ($poultries as $poultry) {
            if($poultry->Poultry_Type === $validated_data['Poultry_Type']) {
                $poultry->increment('Quantity', $validated_data['Quantity']);

                activity('Activity Logs')->causedBy(Auth::user())->performedOn($poultry)->createdAt(now())->log('- Added a new livestock.');
                return redirect()->route('user.managedFarmersDetails', ['currentRoute' => 'poultry', 'personalInformation' => $personalInformation, 'properties' => $personalInformation->poultry])->with('success', 'Poultry Successfully Added');
            }
        }

        $newlyaddedpoultry = Poultry::create([
            'Poultry_Type' => $validated_data['Poultry_Type'],
            'Quantity' => $validated_data['Quantity'],
            'personal_information_id' => $personalInformation->id,
        ]);

        activity('Activity Logs')->causedBy(Auth::user())->performedOn($newlyaddedpoultry)->createdAt(now())->log('- Added a new poultry.');
        return redirect()->route('user.managedFarmersDetails', ['currentRoute' => 'poultry', 'personalInformation' => $personalInformation, 'properties' => $personalInformation->poultry])->with('success', 'Poultry Successfully Added');
    }

    public function userDestroy(Poultry $poultry): RedirectResponse {
        $poultry = $poultry;
        $personalinformation = $poultry->personalinformation;
        $poultry->delete();

        activity('Activity Logs')->causedBy(Auth::user())->performedOn($poultry)->createdAt(now())->log('- Delete a poultry.');
        return redirect()->route('user.managedFarmersDetails', ['currentRoute' => 'poultry', 'personalInformation' => $personalinformation, 'properties' => $personalinformation->poultry])->with('success', 'Poultry Successfully Deleted');
    }

    public function userAction(Request $request): RedirectResponse {
        $findPoultries = Poultry::find($request->id);
        $personalinformation = $findPoultries->personalinformation;

        if($request->Action == 'Transfer') {
            $findFarmer = PersonalInformation::find($request->personal_information_id);
            $poultries = $findFarmer->poultry()->get();

            // Create when certain poultries and gender exist
            if($poultries) {
                foreach ($poultries as $poultry) {
                    if($poultry->Poultry_Type === $findPoultries->Poultry_Type) {
                        $poultry->increment('Quantity', $request->Quantity);

                        if($findPoultries->Quantity < $request->Quantity) {
                            $quantity = $findPoultries->Quantity;
                            $findPoultries->decrement('Quantity', $quantity);
                        } else {
                            $findPoultries->decrement('Quantity', $request->Quantity);
                        }

                        activity('Activity Logs')->causedBy(Auth::user())->createdAt(now())->log('- Poultries Removed Successfully.');
                        return redirect()->route('user.managedFarmersDetails', ['currentRoute' => 'poultry', 'personalInformation' => $personalinformation, 'properties' => $personalinformation->poultry])->with('success', 'Poultries Removed Successfully');
                    } 
                }
            } 

            Poultry::create([
                'Poultry_Type' => $findPoultries->Poultry_Type,
                'Quantity' => $request->Quantity,
                'personal_information_id' => $request->personal_information_id,
            ]);

            if($findPoultries->Quantity < $request->Quantity) {
                $quantity = $findPoultries->Quantity;
                $findPoultries->decrement('Quantity', $quantity);
            } else {
                $findPoultries->decrement('Quantity', $request->Quantity);
            }
        } else {
            if($findPoultries->Quantity < $request->Quantity) {
                $quantity = $findPoultries->Quantity;
                $findPoultries->decrement('Quantity', $quantity);
            } else {
                $findPoultries->decrement('Quantity', $request->Quantity);
            }
        }

        activity('Activity Logs')->causedBy(Auth::user())->createdAt(now())->log('- Poultries Removed Successfully.');
        return redirect()->route('user.managedFarmersDetails', ['currentRoute' => 'poultry', 'personalInformation' => $personalinformation, 'properties' => $personalinformation->poultry])->with('success', 'Poultries Removed Successfully');
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

        $poultries = $personalInformation->poultry()->latest()->get();
        // Create when certain poultry and gender exist
        foreach ($poultries as $poultry) {
            if($poultry->Poultry_Type === $validated_data['Poultry_Type']) {
                $poultry->increment('Quantity', $validated_data['Quantity']);

                activity('Activity Logs')->causedBy(Auth::user())->performedOn($poultry)->createdAt(now())->log('- Added a new livestock.');
                return redirect()->route('admin.farmerDetails', ['currentRoute' => 'poultry', 'personalInformation' => $personalInformation, 'properties' => $personalInformation->poultry])->with('success', 'Poultry Successfully Added');
            }
        }

        $newlyaddedpoultry = Poultry::create([
            'Poultry_Type' => $validated_data['Poultry_Type'],
            'Quantity' => $validated_data['Quantity'],
            'personal_information_id' => $personalInformation->id,
        ]);

        activity('Activity Logs')->causedBy(Auth::user())->performedOn($newlyaddedpoultry)->createdAt(now())->log('- Added a new poultry.');
        return redirect()->route('admin.farmerDetails', ['currentRoute' => 'poultry', 'personalInformation' => $personalInformation, 'properties' => $personalInformation->poultry])->with('success', 'Poultry Successfully Added');
    }

    public function adminDestroy(Poultry $poultry): RedirectResponse {
        $poultry = $poultry;
        $personalinformation = $poultry->personalinformation;
        $poultry->delete();

        activity('Activity Logs')->causedBy(Auth::user())->performedOn($poultry)->createdAt(now())->log('- Delete a poultry.');
        return redirect()->route('admin.farmerDetails', ['currentRoute' => 'poultry', 'personalInformation' => $personalinformation, 'properties' => $personalinformation->poultry])->with('success', 'Poultry Successfully Deleted');
    }

    public function adminAction(Request $request): RedirectResponse {
        $findPoultries = Poultry::find($request->id);
        $personalinformation = $findPoultries->personalinformation;

        if($request->Action == 'Transfer') {
            $findFarmer = PersonalInformation::find($request->personal_information_id);
            $poultries = $findFarmer->poultry()->get();

            // Create when certain poultries and gender exist
            if($poultries) {
                foreach ($poultries as $poultry) {
                    if($poultry->Poultry_Type === $findPoultries->Poultry_Type) {
                        $poultry->increment('Quantity', $request->Quantity);

                        if($findPoultries->Quantity < $request->Quantity) {
                            $quantity = $findPoultries->Quantity;
                            $findPoultries->decrement('Quantity', $quantity);
                        } else {
                            $findPoultries->decrement('Quantity', $request->Quantity);
                        }

                        activity('Activity Logs')->causedBy(Auth::user())->createdAt(now())->log('- Poultries Removed Successfully.');
                        return redirect()->route('admin.farmerDetails', ['currentRoute' => 'poultry', 'personalInformation' => $personalinformation, 'properties' => $personalinformation->poultry])->with('success', 'Poultries Removed Successfully');
                    } 
                }
            } 

            Poultry::create([
                'Poultry_Type' => $findPoultries->Poultry_Type,
                'Quantity' => $request->Quantity,
                'personal_information_id' => $request->personal_information_id,
            ]);

            if($findPoultries->Quantity < $request->Quantity) {
                $quantity = $findPoultries->Quantity;
                $findPoultries->decrement('Quantity', $quantity);
            } else {
                $findPoultries->decrement('Quantity', $request->Quantity);
            }
        } else {
            if($findPoultries->Quantity < $request->Quantity) {
                $quantity = $findPoultries->Quantity;
                $findPoultries->decrement('Quantity', $quantity);
            } else {
                $findPoultries->decrement('Quantity', $request->Quantity);
            }
        }

        activity('Activity Logs')->causedBy(Auth::user())->createdAt(now())->log('- Poultries Removed Successfully.');
        return redirect()->route('admin.farmerDetails', ['currentRoute' => 'poultry', 'personalInformation' => $personalinformation, 'properties' => $personalinformation->poultry])->with('success', 'Poultries Removed Successfully');
    }
}
