<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\Models\PersonalInformation;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserPersonalInformationController extends Controller
{
    public function index(): View
    {
        return view('user.managed.managed', ['PersonalInformations' => PersonalInformation::where('is_approved', true)->paginate(5)]);
    }

    public function create()
    {
        return view('user.managed.create', ['Religions' => Option::where('Option_Name', 'Religion')->get(), 'Livelihood' => Option::where('Option_Name', 'Livelihood')->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validation_rules = [
            'RSBSA_No' => 'required|numeric|unique:personal_informations,RSBSA_No',
            'Surname' => 'required|string',
            'First_Name' => 'required|string',
            'Middle_Name' => 'nullable|string',
            'Extension' => 'nullable|string',
            'Address' => 'required|string',
            'Mobile_No' => 'required|string',
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

        return redirect()->route('userPersonalInformation.index')->with('success', 'Farmer Successfully Added');
    }

    public function show(PersonalInformation $personalInformation)
    {

    }

    public function edit(PersonalInformation $personalInformation): View
    {
        return view('user.managed.edit', ['PersonalInformations' => $personalInformation]);
    }

    public function update(Request $request, PersonalInformation $personalInformation)
    {
        $validation_rules = [
            'RSBSA_No' => 'required|numeric|unique:personal_informations,RSBSA_No',
            'Surname' => 'required|string',
            'First_Name' => 'required|string',
            'Middle_Name' => 'nullable|string',
            'Extension' => 'nullable|string',
            'Address' => 'required|string',
            'Mobile_No' => 'required|string',
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

        $personalInformation->update($validated_data->validated());

        return redirect()->route('personalInformation.index')->with('success', 'Farmer Successfully Edited');
    }

    public function destroy(PersonalInformation $personalInformation): RedirectResponse
    {
        $personalInformation->delete();
        return redirect()->route('personalInformation.index')->with('success', 'Farmer Successfully Deleted');
    }
}
