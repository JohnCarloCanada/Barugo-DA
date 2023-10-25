<?php

namespace App\Http\Controllers;

use App\Models\DogInformation;
use App\Models\PersonalInformation;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DogVaccinationinformationController extends Controller
{
    //
    public function index(): View {
        return view('user.vaccination.index', ['DogInformations' => DogInformation::get()]);
    }

    public function create(): View {
        return view('user.vaccination.create', ['personalInformation' => PersonalInformation::where('is_approved', true)->get()]);
    }

    public function store(Request $request): RedirectResponse {
        $validation_rules = [
            'RSBSA_No' => 'required|numeric',
            'Dog_Name' => 'required|string|max:99',
            'Species' => 'required|string|max:99',
            'Sex' => 'required|string|max:9',
            'Age' => 'required|numeric',
            'Neutering' => 'required|string|max:9',
            'Color' => 'required|string|max:19',
            'Date_of_Registration' => 'required|date',
            'Last_Vac_Month' => 'nullable|date',
            'Remarks' => 'nullable|string|max:255',
        ];

        $validated_data = $request->validate($validation_rules);
        $Owner = PersonalInformation::find($validated_data['RSBSA_No']);
        $OwnerName = $Owner->First_Name . ' ' . $Owner->Middle_Name . " " . $Owner->Surname;

        DogInformation::create([
            'RSBSA_No' => $Owner->RSBSA_No,
            'Owner_Name' => $OwnerName,
            'Dog_Name' => $validated_data['Dog_Name'],
            'Species' => $validated_data['Species'],
            'Sex' => $validated_data['Sex'],
            'Age' => $validated_data['Age'],
            'Neutering' => $validated_data['Neutering'],
            'Color' => $validated_data['Color'],
            'Date_of_Registration' => $validated_data['Date_of_Registration'],
            'Last_Vac_Month' => $validated_data['Last_Vac_Month'] ?? NULL,
            'Remarks' => $validated_data['Remarks'] ?? NULL,
        ]);

        return redirect()->route('dogVaccinationInformation.index')->with('Success', 'Added New Record');
    }
}
