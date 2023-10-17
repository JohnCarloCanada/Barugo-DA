<?php

namespace App\Http\Controllers;

use App\Models\Machinery;
use App\Models\PersonalInformation;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class MachineryInformationController extends Controller
{
    //
    public function index(PersonalInformation $personalInformation): View {
        return view('user.managed.machinery.create', ['personalInformation' => $personalInformation]);
    }

    public function store(Request $request, PersonalInformation $personalInformation): RedirectResponse {
        $validation_rules = [
            'MachineName' => 'required|string|max:99',
            'Price' => 'required|decimal:0,2',
            'Mode_Acqusition' => 'required|string|max:99',
            'Use_of_Machinery' => 'required|string|max:9',
        ];

        $validated_data = $request->validate($validation_rules);

        Machinery::create([
            'MachineName' => $validated_data['MachineName'],
            'Price' => $validated_data['Price'],
            'Mode_Acqusition' => $validated_data['Mode_Acqusition'],
            'Use_of_Machinery' => $validated_data['Use_of_Machinery'],
            'RSBSA_No' => $personalInformation->RSBSA_No,
        ]);

        return redirect()->route('user.managedFarmersDetails', ['currentRoute' => 'machinery', 'personalInformation' => $personalInformation, 'properties' => $personalInformation->machinery])->with('success', 'Machinery Successfully Added');
    }

    public function destroy(Machinery $machinery): RedirectResponse {
        $personalinformation = $machinery->personalinformation;
        $machinery->delete();
        return redirect()->route('admin.farmerDetails', ['currentRoute' => 'machinery', 'personalInformation' => $personalinformation, 'properties' => $personalinformation->machinery])->with('success', 'Machinery Successfully Deleted');
    }
}