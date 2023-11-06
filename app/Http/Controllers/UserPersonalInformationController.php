<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\Models\PersonalInformation;
use App\Rules\PhilippineNumberFormat;
use App\Rules\RSBSANoFormat;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class UserPersonalInformationController extends Controller
{
    public function index(Request $request): View
    {
        $farmers = PersonalInformation::where(function($query) use ($request) {
            $query->where('RSBSA_No', 'LIKE', '%' . $request->search . '%');
        });
        return view('user.managed.managed', ['PersonalInformations' => $farmers->latest()->where('is_approved', true)->paginate(5), 'search' => $request->search]);
    }

    public function create()
    {
        return view('user.managed.create', ['Religions' => Option::where('Option_Name', 'Religion')->get(), 'Livelihood' => Option::where('Option_Name', 'Livelihood')->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validation_rules = [
            'RSBSA_No' => ['required', 'string', 'unique:personal_informations,RSBSA_No', new RSBSANoFormat],
            'Surname' => 'required|string',
            'First_Name' => 'required|string',
            'Middle_Name' => 'nullable|string',
            'Extension' => 'nullable|string',
            'Address' => 'required|string',
            'Mobile_No' => ['required', 'string', new PhilippineNumberFormat],
            'Sex' => 'required|string',
            'Date_of_birth' => 'required|date',
            'Religion' => 'required|string',
            'Civil_Status' => 'required|string',
            'Name_of_Spouse' => 'nullable|string',
            'Highest_education_qualification' => 'required|string',
            'Main_livelihood' => 'required|string',
    
        ];
        
        $validated_data = Validator::make($request->all(), $validation_rules);
    
        if($validated_data->fails()) {
            return back()->withErrors($validated_data)->withInput();
        }

        $data = PersonalInformation::create($validated_data->validated());

        activity()->causedBy(Auth::user())->performedOn($data)->createdAt(now())->log('- Added a new farmer waiting for approval.');

        return redirect()->route('userPersonalInformation.index')->with('success', 'Farmer Successfully Added');
    }

    public function show(PersonalInformation $personalInformation)
    {

    }

    public function edit(PersonalInformation $personalInformation): View
    {
        return view('user.managed.edit', ['PersonalInformations' => $personalInformation, 'Religions' => Option::where('Option_Name', 'Religion')->get(), 'Livelihood' => Option::where('Option_Name', 'Livelihood')->get()]);
    }

    public function update(Request $request, PersonalInformation $personalInformation)
    {
        $validation_rules = [
            'Updated_Surname' => 'required|string',
            'Updated_First_Name' => 'required|string',
            'Updated_Middle_Name' => 'nullable|string',
            'Updated_Extension' => 'nullable|string',
            'Updated_Address' => 'required|string',
            'Updated_Mobile_No' => ['required', 'string', new PhilippineNumberFormat],
            'Updated_Sex' => 'required|string',
            'Updated_Date_of_birth' => 'required|date',
            'Updated_Religion' => 'required|string',
            'Updated_Civil_Status' => 'required|string',
            'Updated_Name_of_Spouse' => 'nullable|string',
            'Updated_Highest_education_qualification' => 'required|string',
            'Updated_Main_livelihood' => 'required|string',
        ];

        $validated_data = Validator::make($request->all(), $validation_rules);
    
        if($validated_data->fails()) {
            return back()->withErrors($validated_data)->withInput();
        }

        $personalInformation->update([
            'Updated_Surname' => $validated_data->validated()['Updated_Surname'],
            'Updated_First_Name' => $validated_data->validated()['Updated_First_Name'],
            'Updated_Middle_Name' => $validated_data->validated()['Updated_Middle_Name'] ?? NULL,
            'Updated_Extension' => $validated_data->validated()['Updated_Extension'] ?? NULL,
            'Updated_Address' => $validated_data->validated()['Updated_Address'],
            'Updated_Mobile_No' => $validated_data->validated()['Updated_Mobile_No'],
            'Updated_Sex' => $validated_data->validated()['Updated_Sex'],
            'Updated_Date_of_birth' => $validated_data->validated()['Updated_Date_of_birth'],
            'Updated_Religion' => $validated_data->validated()['Updated_Religion'],
            'Updated_Civil_Status' => $validated_data->validated()['Updated_Civil_Status'],
            'Updated_Name_of_Spouse' => $validated_data->validated()['Updated_Name_of_Spouse'] ?? NULL,
            'Updated_Highest_education_qualification' => $validated_data->validated()['Updated_Highest_education_qualification'],
            'Updated_Main_livelihood' => $validated_data->validated()['Updated_Main_livelihood'],
            'update_status' => true,
        ]);

        activity()->causedBy(Auth::user())->performedOn($personalInformation)->createdAt(now())->log('- Edited a farmer waiting for approval.');

        return redirect()->route('userPersonalInformation.index')->with('success', 'Farmer Successfully Edited');
    }

    public function destroy(PersonalInformation $personalInformation): RedirectResponse
    {
        $personalInformation->delete();
        return redirect()->route('personalInformation.index')->with('success', 'Farmer Successfully Deleted');
    }
}
