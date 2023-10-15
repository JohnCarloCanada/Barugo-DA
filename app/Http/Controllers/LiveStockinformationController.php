<?php

namespace App\Http\Controllers;

use App\Models\Livestock;
use App\Models\PersonalInformation;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LiveStockInformationController extends Controller
{
    //

    public function index(PersonalInformation $personalInformation): View {
        return view('user.managed.livestock.create', ['personalInformation' => $personalInformation]);
    }

    public function store(Request $request, PersonalInformation $personalInformation): RedirectResponse {
        $validation_rules = [
            'LSAnimals' => 'required|string',
            'Sex_LS' => 'required|string',
        ];

        $validated_data = $request->validate($validation_rules);

        Livestock::create([
            'LSAnimals' => $validated_data['LSAnimals'],
            'Sex_LS' => $validated_data['Sex_LS'],
            'RSBSA_No' => $personalInformation->RSBSA_No
        ]);

        

        return redirect()->route('user.managedFarmersDetails', ['currentRoute' => 'livestock', 'personalInformation' => $personalInformation, 'properties' => $personalInformation->livestock])->with('success', 'Livestock Successfully Added');
    }

    public function destroy(Livestock $livestock): RedirectResponse {
        $personalinformation = $livestock->personalinformation;
        $livestock->delete();
        return redirect()->route('admin.farmerDetails', ['currentRoute' => 'livestock', 'personalInformation' => $personalinformation, 'properties' => $personalinformation->livestock])->with('success', 'Livestock Successfully Added');
    }
}
