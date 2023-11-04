<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\Models\PersonalInformation;
use App\Rules\PhilippineNumberFormat;
use App\Rules\RSBSANoFormat;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminPersonalInformationController extends Controller
{
    public function farmer(Request $request): View {
        $approvedFarmers = PersonalInformation::where(function($query) use ($request) {
            $query->where('RSBSA_No', 'LIKE', '%' . $request->search . '%');
        });

        $approvedFarmers = $approvedFarmers->latest()->where('is_approved', true)->paginate(5);
        $notApprovedFarmersCount = PersonalInformation::where('is_approved', false)->count();
        $needUpdateFarmersCount = PersonalInformation::where('update_status', true)->count();
        
        return view('admin.farmer.farmer', ['PersonalInformations' => $approvedFarmers, 'notApprovedCount' => $notApprovedFarmersCount, 'needUpdateFarmersCount' => $needUpdateFarmersCount, 'search' => $request->search]);
    }

    public function needApproval(Request $request): View {
        $notApprovedFarmers = PersonalInformation::where(function($query) use ($request) {
            $query->where('RSBSA_No', 'LIKE', '%' . $request->search . '%');
        });

        $notApprovedFarmers = $notApprovedFarmers->latest()->where('is_approved', false)->paginate(5);
        $notApprovedFarmersCount = PersonalInformation::where('is_approved', false)->count();
        $needUpdateFarmersCount = PersonalInformation::where('update_status', true)->count();
        return view('admin.farmer.approval', ['PersonalInformations' => $notApprovedFarmers, 'notApprovedCount' => $notApprovedFarmersCount, 'needUpdateFarmersCount' => $needUpdateFarmersCount, 'search' => $request->search]);
    }

    public function needUpdate(Request $request): View {
        $needUpdateFarmers = PersonalInformation::where(function($query) use ($request) {
            $query->where('RSBSA_No', 'LIKE', '%' . $request->search . '%');
        });

        $needUpdateFarmers = $needUpdateFarmers->latest()->where('is_approved', true)->where('update_status', true)->paginate(5);
        $notApprovedFarmersCount = PersonalInformation::where('is_approved', false)->count();
        $needUpdateFarmersCount = PersonalInformation::where('update_status', true)->count();
        return view('admin.farmer.update', ['PersonalInformations' => $needUpdateFarmers, 'notApprovedCount' => $notApprovedFarmersCount, 'needUpdateFarmersCount' => $needUpdateFarmersCount, 'search' => $request->search]);
    }

    public function approved(PersonalInformation $personalInformation): RedirectResponse {
        $personalInformation->is_approved = true;
        $personalInformation->save();
        return redirect()->route('adminPersonalInformation.needApproval')->with('success', 'Farmer Successfully Approved');
    }

    public function delete(PersonalInformation $personalInformation): RedirectResponse {
        $personalInformation->delete();
        return redirect()->route('adminPersonalInformation.index')->with('success', 'Farmer Successfully Deleted');
    }

    public function acceptUpdate(PersonalInformation $personalInformation): RedirectResponse {
        $personalInformation->update([
            'Surname' => $personalInformation->Updated_Surname,
            'First_Name' => $personalInformation->Updated_First_Name,
            'Middle_Name' => $personalInformation->Updated_Middle_Name,
            'Extension' => $personalInformation->Updated_Extension,
            'Address' => $personalInformation->Updated_Address,
            'Mobile_No' => $personalInformation->Updated_Mobile_No,
            'Sex' => $personalInformation->Updated_Sex,
            'Date_of_birth' => $personalInformation->Updated_Date_of_birth,
            'Religion' => $personalInformation->Updated_Religion,
            'Civil_Status' => $personalInformation->Updated_Civil_Status,
            'Name_of_Spouse' => $personalInformation->Updated_Name_of_Spouse,
            'Highest_education_qualification' => $personalInformation->Updated_Highest_education_qualification,
            'Main_livelihood' => $personalInformation->Updated_Main_livelihood,
            'update_status' => false,
        ]);

        return redirect()->route('adminPersonalInformation.needUpdate')->with('success', 'Edit Approved');
    }

    public function create(): view {
        return view('admin.farmer.create', ['Religions' => Option::where('Option_Name', 'Religion')->get(), 'Livelihood' => Option::where('Option_Name', 'Livelihood')->get()]);
    }


    public function store(Request $request): RedirectResponse {
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
        
        PersonalInformation::create([
            'RSBSA_No' => $validated_data->validated()['RSBSA_No'],
            'Surname' => $validated_data->validated()['Surname'],
            'First_Name' => $validated_data->validated()['First_Name'],
            'Middle_Name' => $validated_data->validated()['Middle_Name'] ?? NULL,
            'Extension' => $validated_data->validated()['Extension'] ?? NULL,
            'Address' => $validated_data->validated()['Address'],
            'Mobile_No' => $validated_data->validated()['Mobile_No'],
            'Sex' => $validated_data->validated()['Sex'],
            'Date_of_birth' => $validated_data->validated()['Date_of_birth'],
            'Religion' => $validated_data->validated()['Religion'],
            'Civil_Status' => $validated_data->validated()['Civil_Status'],
            'Name_of_Spouse' => $validated_data->validated()['Name_of_Spouse'] ?? NULL,
            'Highest_education_qualification' => $validated_data->validated()['Highest_education_qualification'],
            'Main_livelihood' => $validated_data->validated()['Main_livelihood'],
            'is_approved' => 1,
        ]);

        return redirect()->route('adminPersonalInformation.index')->with('success', 'Farmer Successfully Added');
    }

    public function edit(PersonalInformation $personalInformation): View
    {
        return view('admin.farmer.edit', ['PersonalInformations' => $personalInformation, 'Religions' => Option::where('Option_Name', 'Religion')->get(), 'Livelihood' => Option::where('Option_Name', 'Livelihood')->get()]);
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
            'Surname' => $validated_data->validated()['Updated_Surname'],
            'First_Name' => $validated_data->validated()['Updated_First_Name'],
            'Middle_Name' => $validated_data->validated()['Updated_Middle_Name'] ?? NULL,
            'Extension' => $validated_data->validated()['Updated_Extension'] ?? NULL,
            'Address' => $validated_data->validated()['Updated_Address'],
            'Mobile_No' => $validated_data->validated()['Updated_Mobile_No'],
            'Sex' => $validated_data->validated()['Updated_Sex'],
            'Date_of_birth' => $validated_data->validated()['Updated_Date_of_birth'],
            'Religion' => $validated_data->validated()['Updated_Religion'],
            'Civil_Status' => $validated_data->validated()['Updated_Civil_Status'],
            'Name_of_Spouse' => $validated_data->validated()['Updated_Name_of_Spouse'] ?? NULL,
            'Highest_education_qualification' => $validated_data->validated()['Updated_Highest_education_qualification'],
            'Main_livelihood' => $validated_data->validated()['Updated_Main_livelihood'],
            'update_status' => false,
        ]);

        return redirect()->route('adminPersonalInformation.index')->with('success', 'Farmer Successfully Edited');
    }
}
