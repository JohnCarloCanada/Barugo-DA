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
            $query->where('RSBSA_No', 'LIKE', '%' . $request->search . '%')->orWhere('Surname', 'LIKE', '%' . $request->search . '%');;
        });
        return view('user.managed.managed', ['PersonalInformations' => $farmers->latest()->where('is_approved', true)->paginate(25), 'search' => $request->search]);
    }

    public function create()
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

        return view('user.managed.create', ['Religions' => Option::where('Option_Name', 'Religion')->get(), 'Livelihood' => Option::where('Option_Name', 'Livelihood')->get(), 'Address' => collect($barugo_brgy_list)]);
    }

    public function store(Request $request): RedirectResponse
    {
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

        $data = PersonalInformation::create($validated_data->validated());

        activity('Activity Logs')->causedBy(Auth::user())->performedOn($data)->createdAt(now())->log('- Added a new farmer waiting for approval.');

        return redirect()->route('userPersonalInformation.index')->with('success', 'Farmer Successfully Added');
    }

    public function show(PersonalInformation $personalInformation)
    {

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
        return redirect()->route('user.managedFarmersDetails', ['currentRoute' => $currentRoute, 'personalInformation' => $personalInformation])->with('success', 'Farmer RSBSA No. Succesfully Updated');
    }
}
