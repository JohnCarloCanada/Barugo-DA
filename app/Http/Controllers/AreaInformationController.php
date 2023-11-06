<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\PersonalInformation;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class AreaInformationController extends Controller
{
    //
    public function userIndex(PersonalInformation $personalInformation): View {
        return view('user.managed.area.create', ['personalInformation' => $personalInformation]);
    }

    public function userStore(Request $request, PersonalInformation $personalInformation): RedirectResponse {
        $validation_rules = [
            'Lot_No' => 'required|string|max:32|unique:areas,Lot_No',
            'Hectares' => 'required|decimal:0,2',
            'Area_Type' => 'required|string|max:99',
            'Commodity_planted' => 'nullable|string|max:99',
            'Address' => 'required|string|max:255',
            'Lat' => 'required|string',
            'Lon' => 'required|string',
            'Ownership_Type' => 'required|string|max:10',
            'Tenant_Name' => 'nullable|string|max:99',
            'Owner_Address' => 'required|string|max:255',
            'Farm_Type' => 'required|string|max:24'
        ];

        $validated_data = $request->validate($validation_rules);

        $newlyaddedarea = Area::create([
            'Lot_No' => $validated_data['Lot_No'],
            'Hectares' => $validated_data['Hectares'],
            'Area_Type' => $validated_data['Area_Type'],
            'Commodity_planted' => $validated_data['Commodity_planted'] ?? 'None',
            'Address' => $validated_data['Address'],
            'Ownership_Type' => $validated_data['Ownership_Type'],
            'Tenant_Name' => $validated_data['Tenant_Name'] ?? 'None',
            'Owner_Address' => $validated_data['Owner_Address'],
            'Lat' => $validated_data['Lat'],
            'Lon' => $validated_data['Lon'],
            'Farm_Type' => $validated_data['Farm_Type'],
            'RSBSA_No' => $personalInformation->RSBSA_No,
        ]);

        activity()->causedBy(Auth::user())->performedOn($newlyaddedarea)->createdAt(now())->log('- Added a new area.');

        return redirect()->route('user.managedFarmersDetails', ['currentRoute' => 'area', 'personalInformation' => $personalInformation, 'properties' => $personalInformation->area])->with('success', 'Area Successfully Added');
    } 

    public function userDestroy(Area $area): RedirectResponse {
        $area = $area;
        $personalinformation = $area->personalinformation;
        $area->delete();

        activity()->causedBy(Auth::user())->performedOn($area)->createdAt(now())->log('- Deleted an area.');
        return redirect()->route('user.managedFarmersDetails', ['currentRoute' => 'area', 'personalInformation' => $personalinformation, 'properties' => $personalinformation->area])->with('success', 'Area Successfully Deleted');
    }

    public function adminIndex(PersonalInformation $personalInformation): View {
        return view('admin.farmer.area.create', ['personalInformation' => $personalInformation]);
    }

    public function adminStore(Request $request, PersonalInformation $personalInformation): RedirectResponse {
        $validation_rules = [
            'Lot_No' => 'required|string|max:32|unique:areas,Lot_No',
            'Hectares' => 'required|decimal:0,2',
            'Area_Type' => 'required|string|max:99',
            'Commodity_planted' => 'nullable|string|max:99',
            'Address' => 'required|string|max:255',
            'Lat' => 'required|string',
            'Lon' => 'required|string',
            'Ownership_Type' => 'required|string|max:10',
            'Tenant_Name' => 'nullable|string|max:99',
            'Owner_Address' => 'required|string|max:255',
            'Farm_Type' => 'required|string|max:24'
        ];

        $validated_data = $request->validate($validation_rules);

        $newlyaddedarea = Area::create([
            'Lot_No' => $validated_data['Lot_No'],
            'Hectares' => $validated_data['Hectares'],
            'Area_Type' => $validated_data['Area_Type'],
            'Commodity_planted' => $validated_data['Commodity_planted'] ?? 'None',
            'Address' => $validated_data['Address'],
            'Ownership_Type' => $validated_data['Ownership_Type'],
            'Tenant_Name' => $validated_data['Tenant_Name'] ?? 'None',
            'Owner_Address' => $validated_data['Owner_Address'],
            'Lat' => $validated_data['Lat'],
            'Lon' => $validated_data['Lon'],
            'Farm_Type' => $validated_data['Farm_Type'],
            'RSBSA_No' => $personalInformation->RSBSA_No,
        ]);

        activity()->causedBy(Auth::user())->performedOn($newlyaddedarea)->createdAt(now())->log('- Added a new area.');

        return redirect()->route('admin.farmerDetails', ['currentRoute' => 'area', 'personalInformation' => $personalInformation, 'properties' => $personalInformation->area])->with('success', 'Area Successfully Added');
    } 

    public function adminDestroy(Area $area): RedirectResponse {
        $area = $area;
        $personalinformation = $area->personalinformation;
        $area->delete();

        activity()->causedBy(Auth::user())->performedOn($area)->createdAt(now())->log('- Deleted an area.');
        return redirect()->route('admin.farmerDetails', ['currentRoute' => 'area', 'personalInformation' => $personalinformation, 'properties' => $personalinformation->area])->with('success', 'Area Successfully Deleted');
    }
}
