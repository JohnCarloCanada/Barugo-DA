<?php

namespace App\Http\Controllers;

use App\Models\DogInformation;
use App\Models\PersonalInformation;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DogVaccinationinformationController extends Controller
{
    //
    public function index(Request $request): View {
        $dogs = DogInformation::where(function($query) use ($request) {
            $query->where('Owner_Name', 'LIKE', '%' . $request->search . '%')->orWhere('Dog_Name', 'LIKE', '%' . $request->search . '%');
        });

        return view('user.vaccination.index', ['DogInformations' => $dogs->paginate(10), 'search' => $request->search]);
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
            'Last_Vac_Month' => 'nullable|date',
            'Remarks' => 'nullable|string|max:255',
        ];

        $validated_data = $request->validate($validation_rules);
        $Owner = PersonalInformation::find($validated_data['RSBSA_No']);

        $Initial = Str::upper(Str::substr($Owner->Middle_Name, 0, 1));

        $OwnerName = $Owner->Middle_Name == NULL ? $Owner->First_Name . ' ' . $Owner->Surname : $Owner->First_Name . ' '. $Initial . '.' . ' ' . $Owner->Surname;

        $new_dog = DogInformation::create([
            'RSBSA_No' => $Owner->RSBSA_No,
            'Owner_Name' => $OwnerName,
            'Dog_Name' => $validated_data['Dog_Name'],
            'Species' => $validated_data['Species'],
            'Sex' => $validated_data['Sex'],
            'Age' => $validated_data['Age'],
            'Neutering' => $validated_data['Neutering'],
            'Color' => $validated_data['Color'],
            'Date_of_Registration' => now(),
            'Last_Vac_Month' => $validated_data['Last_Vac_Month'] ?? NULL,
            'Remarks' => $validated_data['Remarks'] ?? NULL,
        ]);

        return redirect()->route('dogVaccinationInformation.index')->with('success', $new_dog->Dog_Name . ' ' . 'Succesfully been added to the record!');
    }


    public function vaccination(DogInformation $dogInformation): RedirectResponse {
        $dogInformation->Last_Vac_Month = now();
        $dogInformation->save();
        return redirect()->route('dogVaccinationInformation.index')->with('success', $dogInformation->Dog_Name . ' ' . 'latest Vaccination Month Added');
    }

    public function destroy(DogInformation $dogInformation): RedirectResponse {
        $Dog_Name = $dogInformation->Dog_Name;
        $dogInformation->delete();
        return redirect()->route('dogVaccinationInformation.index')->with('success', $Dog_Name . ' ' . 'has successfully been deleted from the records!');
    }
}
