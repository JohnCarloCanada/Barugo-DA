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
use Illuminate\Support\Facades\Validator;

class AdminPersonalInformationController extends Controller
{
    public function farmer(Request $request): View {
        $approvedFarmers = PersonalInformation::where(function($query) use ($request) {
            $query->where('RSBSA_No', 'LIKE', '%' . $request->search . '%')->orWhere('Surname', 'LIKE', '%' . $request->search . '%');
        });

        $approvedFarmers = $approvedFarmers->latest()->where('is_approved', true)->paginate(25);
        $notApprovedFarmersCount = PersonalInformation::where('is_approved', false)->count();
        /* $needUpdateFarmersCount = PersonalInformation::where('update_status', true)->count(); */
        
        return view('admin.farmer.farmer', ['PersonalInformations' => $approvedFarmers, 'notApprovedCount' => $notApprovedFarmersCount, 'search' => $request->search]);
    }

    public function needApproval(Request $request): View {
        $notApprovedFarmers = PersonalInformation::where(function($query) use ($request) {
            $query->where('RSBSA_No', 'LIKE', '%' . $request->search . '%')->orWhere('Surname', 'LIKE', '%' . $request->search . '%');
        });

        $notApprovedFarmers = $notApprovedFarmers->latest()->where('is_approved', false)->paginate(25);
        $notApprovedFarmersCount = PersonalInformation::where('is_approved', false)->count();
        $needUpdateFarmersCount = PersonalInformation::where('update_status', true)->count();
        return view('admin.farmer.approval', ['PersonalInformations' => $notApprovedFarmers, 'notApprovedCount' => $notApprovedFarmersCount, 'needUpdateFarmersCount' => $needUpdateFarmersCount, 'search' => $request->search]);
    }

    public function approved(PersonalInformation $personalInformation): RedirectResponse {
        $personalInformation->is_approved = true;
        $personalInformation->save();
        activity('Activity Logs')->causedBy(Auth::user())->performedOn($personalInformation)->createdAt(now())->log('- Approved a farmer.');
        return redirect()->route('adminPersonalInformation.needApproval')->with('success', 'Farmer Successfully Approved');
    }

    public function delete(PersonalInformation $personalInformation): RedirectResponse {
        $farmer = $personalInformation;
        $personalInformation->delete();

        activity('Activity Logs')->causedBy(Auth::user())->performedOn($farmer)->createdAt(now())->log('- Deleted a farmer.');
        return redirect()->route('adminPersonalInformation.index')->with('success', 'Farmer Successfully Deleted');
    }


    public function create(): view {
        $barugo_brgy_list = [
            'Abango',
            'Amahit',
            'Balire',
            'Balud',
            'Bukid',
            'Bulod',
            'Busay',
            'Cabarasan',
            'Cabolo-an',
            'Calingcaguing',
            'Can-isag',
            'Canomantag',
            'Cuta',
            'Domogdog',
            'Duka',
            'Guindaohan',
            'Hiagsam',
            'Hilaba',
            'Hinugayan',
            'Ibag',
            'Minuhang',
            'Minuswang',
            'Pikas',
            'Pitogo',
            'Poblacion-Dist.-I',
            'Poblacion-Dist.-II',
            'Poblacion-Dist.-III',
            'Poblacion-Dist.-IV',
            'Poblacion-Dist.-V',
            'Poblacion-Dist.-VI-(New-Road)',
            'Pongso',
            'Roosevelt',
            'San-Isidro',
            'San-Roque',
            'Santa-Rosa',
            'Santarin',
            'Tutug-an',
        ];

        return view('admin.farmer.create', ['Religions' => Option::where('Option_Name', 'Religion')->get(), 'Livelihood' => Option::where('Option_Name', 'Livelihood')->get(), 'Address' => collect($barugo_brgy_list)]);
    }


    public function store(Request $request): RedirectResponse {
        $validation_rules = [
            'RSBSA_No' => ['nullable', 'string', 'max:24', 'unique:personal_informations,RSBSA_No', new RSBSANoFormat],
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
        
        $newlyaddedfarmer = PersonalInformation::create([
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

        activity('Activity Logs')->causedBy(Auth::user())->performedOn($newlyaddedfarmer)->createdAt(now())->log('- Added a new farmer.');

        return redirect()->route('adminPersonalInformation.index')->with('success', 'Farmer Successfully Added');
    }

    public function edit(PersonalInformation $personalInformation): View
    {
        $barugo_brgy_list = [
            'Abango',
            'Amahit',
            'Balire',
            'Balud',
            'Bukid',
            'Bulod',
            'Busay',
            'Cabarasan',
            'Cabolo-an',
            'Calingcaguing',
            'Can-isag',
            'Canomantag',
            'Cuta',
            'Domogdog',
            'Duka',
            'Guindaohan',
            'Hiagsam',
            'Hilaba',
            'Hinugayan',
            'Ibag',
            'Minuhang',
            'Minuswang',
            'Pikas',
            'Pitogo',
            'Poblacion-Dist.-I',
            'Poblacion-Dist.-II',
            'Poblacion-Dist.-III',
            'Poblacion-Dist.-IV',
            'Poblacion-Dist.-V',
            'Poblacion-Dist.-VI-(New-Road)',
            'Pongso',
            'Roosevelt',
            'San-Isidro',
            'San-Roque',
            'Santa-Rosa',
            'Santarin',
            'Tutug-an',
        ];
        return view('admin.farmer.edit', ['PersonalInformations' => $personalInformation, 'Religions' => Option::where('Option_Name', 'Religion')->get(), 'Livelihood' => Option::where('Option_Name', 'Livelihood')->get(), 'Address' => collect($barugo_brgy_list)]);
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

        activity('Activity Logs')->causedBy(Auth::user())->performedOn($personalInformation)->createdAt(now())->log("- Updated a farmers information.");

        return redirect()->route('adminPersonalInformation.index')->with('success', 'Farmer Successfully Edited');
    }

    public function updateRSBSANumber(Request $request, string $currentRoute): RedirectResponse {
        $validation_rules = [
            'RSBSA_No' => ['nullable', 'string', 'max:24', 'unique:personal_informations,RSBSA_No' , new RSBSANoFormat],
        ];

        $validated_data = $request->validate($validation_rules);

        $personalInformation = PersonalInformation::find($request->id);
        $personalInformation->update([
            'RSBSA_No' => $validated_data['RSBSA_No'],
        ]);


        activity('Activity Logs')->causedBy(Auth::user())->performedOn($personalInformation)->createdAt(now())->log("- Updated a farmers rsbsa number.");
        return redirect()->route('admin.farmerDetails', ['currentRoute' => $currentRoute, 'personalInformation' => $personalInformation])->with('success', 'Farmer RSBSA No. Succesfully Updated');
    }
}
