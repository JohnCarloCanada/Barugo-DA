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
            'quantity' => 'required|numeric'
        ];

        $validated_data = $request->validate($validation_rules);

        $newlyaddedlivestock = Livestock::create([
            'LSAnimals' => $validated_data['LSAnimals'],
            'Sex_LS' => $validated_data['Sex_LS'],
            'quantity' => $validated_data['quantity'],
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
            'quantity' => 'required|numeric'
        ];

        $validated_data = $request->validate($validation_rules);

        $livestocks = $personalInformation->livestock()->latest()->get();

        // Create when certain livestock and gender exist
        foreach ($livestocks as $livestock) {
            if($livestock->LSAnimals === $validated_data['LSAnimals'] && $livestock->Sex_LS === $validated_data['Sex_LS']) {
                $livestock->increment('quantity', $validated_data['quantity']);

                activity('Activity Logs')->causedBy(Auth::user())->performedOn($livestock)->createdAt(now())->log('- Added a new livestock.');
                return redirect()->route('admin.farmerDetails', ['currentRoute' => 'livestock', 'personalInformation' => $personalInformation, 'properties' => $personalInformation->livestock])->with('success', 'Livestock Successfully Added');
            }
        }

        // Create when certain livestock and gender dont exist
        $newlyaddedlivestock = Livestock::create([
            'LSAnimals' => $validated_data['LSAnimals'],
            'Sex_LS' => $validated_data['Sex_LS'],
            'quantity' => $validated_data['quantity'],
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

    public function adminAction(Request $request): RedirectResponse {
        $findLivestock = Livestock::find($request->id);
        $personalinformation = $findLivestock->personalinformation;

        if($request->Action == 'Transfer') {
            $findFarmer = PersonalInformation::find($request->personal_information_id);
            $livestocks = $findFarmer->livestock()->get();

            // Create when certain livestock and gender exist
            if($livestocks) {
                foreach ($livestocks as $livestock) {
                    if($livestock->LSAnimals === $findLivestock->LSAnimals && $livestock->Sex_LS === $findLivestock->Sex_LS) {
                        $livestock->increment('quantity', $request->Quantity);
                        
                        if($findLivestock->quantity < $request->Quantity) {
                            $quantity = $findLivestock->quantity;
                            $findLivestock->decrement('quantity', $quantity);
                        } else {
                            $findLivestock->decrement('quantity', $request->Quantity);
                        }
                        
                        activity('Activity Logs')->causedBy(Auth::user())->createdAt(now())->log('- Livestock Removed Successfully.');
                        return redirect()->route('admin.farmerDetails', ['currentRoute' => 'livestock', 'personalInformation' => $personalinformation, 'properties' => $personalinformation->livestock])->with('success', 'Livestock Removed Successfully');
                    } 
                }
            } 

            Livestock::create([
                'LSAnimals' => $findLivestock->LSAnimals,
                'Sex_LS' => $findLivestock->Sex_LS,
                'quantity' => $request->Quantity,
                'personal_information_id' => $request->personal_information_id,
            ]);

            if($findLivestock->quantity < $request->Quantity) {
                $quantity = $findLivestock->quantity;
                $findLivestock->decrement('quantity', $quantity);
            } else {
                $findLivestock->decrement('quantity', $request->Quantity);
            }
            
        } else {
            if($findLivestock->quantity < $request->Quantity) {
                $quantity = $findLivestock->quantity;
                $findLivestock->decrement('quantity', $quantity);
            } else {
                $findLivestock->decrement('quantity', $request->Quantity);
            }
        }

        activity('Activity Logs')->causedBy(Auth::user())->createdAt(now())->log('- Livestock Removed Successfully.');
        return redirect()->route('admin.farmerDetails', ['currentRoute' => 'livestock', 'personalInformation' => $personalinformation, 'properties' => $personalinformation->livestock])->with('success', 'Livestock Removed Successfully');
    }
}
