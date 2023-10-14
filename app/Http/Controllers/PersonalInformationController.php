<?php

namespace App\Http\Controllers;

use App\Models\PersonalInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PersonalInformationController extends Controller
{

    var $validation_rules = [
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
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        //
        return view('user.managed.managed', ['PersonalInformations' => PersonalInformation::where('is_approved', '=', true)->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('user.managed.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
        $validation_rules = [
            'RSBSA_No' => 'required',
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

        return redirect()->route('personalInformation.index')->with('success', 'Farmer Successfully Added');
    }

    /**
     * Display the specified resource.
     */
    public function show(PersonalInformation $personalInformation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PersonalInformation $personalInformation): View
    {
        //

        return view('user.managed.edit', ['PersonalInformations' => $personalInformation]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PersonalInformation $personalInformation)
    {
        //
        //
        $validation_rules = [
            'RSBSA_No' => 'required',
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PersonalInformation $personalInformation): RedirectResponse
    {
        //
        $personalInformation->delete();
        return redirect()->route('personalInformation.index')->with('success', 'Farmer Successfully Deleted');
    }
}
