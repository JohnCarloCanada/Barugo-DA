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
        $areas = Area::distinct()->get(['Lot_No']);
        return view('user.managed.area.create', ['personalInformation' => $personalInformation, 'areas' => $areas]);
    }

    public function userStore(Request $request, PersonalInformation $personalInformation): RedirectResponse {
        $validation_rules = [
            'Lot_No' => 'nullable|string|max:32',
            'customValue' => 'nullable|string|max:32',
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
        $firstAreaCreatedExist = Area::where('Lot_No', $validated_data['Lot_No'])->first();
        $areas = Area::where('Lot_No', $validated_data['Lot_No'])->get();

        if($firstAreaCreatedExist) {
            foreach ($areas as $area) {
                if($area->Area_Type == $validated_data['Area_Type']) {
                    $isClaimed = false;
    
                    foreach ($areas as $area) {
                        if($area->is_claimed == true) {
                            $isClaimed = true;
                        } else {
                            $isClaimed = false;
                        }
                    }
                    $Lot_No = $validated_data['Lot_No'] === 'custom' ? $validated_data['customValue'] : $validated_data['Lot_No'];
    
                    $newlyaddedarea = Area::create([
                        'Lot_No' => $Lot_No,
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
                        'personal_information_id' => $personalInformation->id,
                        'is_claimed' => $isClaimed,
                    ]);
                    activity('Activity Logs')->causedBy(Auth::user())->performedOn($newlyaddedarea)->createdAt(now())->log('- Added a new area.');
                    return redirect()->route('user.managedFarmersDetails', ['currentRoute' => 'area', 'personalInformation' => $personalInformation, 'properties' => $personalInformation->area])->with('success', 'Area Successfully Added');
                } else {
                    return redirect()->route('user.managedFarmersDetails', ['currentRoute' => 'area', 'personalInformation' => $personalInformation, 'properties' => $personalInformation->area])->with('error', 'Similar Lot No. Must Have The Same Area Type!');
                }
            }
        }

        $isClaimed = false;
    
        foreach ($areas as $area) {
            if($area->is_claimed == true) {
                $isClaimed = true;
            } else {
                $isClaimed = false;
            }
        }
        $Lot_No = $validated_data['Lot_No'] === 'custom' ? $validated_data['customValue'] : $validated_data['Lot_No'];

        $newlyaddedarea = Area::create([
            'Lot_No' => $Lot_No,
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
            'personal_information_id' => $personalInformation->id,
            'is_claimed' => $isClaimed,
        ]);

        activity('Activity Logs')->causedBy(Auth::user())->performedOn($newlyaddedarea)->createdAt(now())->log('- Added a new area.');
        return redirect()->route('user.managedFarmersDetails', ['currentRoute' => 'area', 'personalInformation' => $personalInformation, 'properties' => $personalInformation->area])->with('success', 'Area Successfully Added');
    } 

    public function userDestroy(Area $area): RedirectResponse {
        $area = $area;
        $personalinformation = $area->personalinformation;
        $area->delete();

        activity('Activity Logs')->causedBy(Auth::user())->performedOn($area)->createdAt(now())->log('- Deleted an area.');
        return redirect()->route('user.managedFarmersDetails', ['currentRoute' => 'area', 'personalInformation' => $personalinformation, 'properties' => $personalinformation->area])->with('success', 'Area Successfully Deleted');
    }

    public function adminIndex(PersonalInformation $personalInformation): View {
        $areas = Area::distinct()->get(['Lot_No']);
        return view('admin.farmer.area.create', ['personalInformation' => $personalInformation, 'areas' => $areas]);
    }

    public function adminStore(Request $request, PersonalInformation $personalInformation): RedirectResponse {
        $validation_rules = [
            'Lot_No' => 'nullable|string|max:32',
            'customValue' => 'nullable|string|max:32',
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
        $firstAreaCreatedExist = Area::where('Lot_No', $validated_data['Lot_No'])->first();
        $areas = Area::where('Lot_No', $validated_data['Lot_No'])->get();

        if($firstAreaCreatedExist) {
            foreach ($areas as $area) {
                if($area->Area_Type == $validated_data['Area_Type']) {
                    $isClaimed = false;
    
                    foreach ($areas as $area) {
                        if($area->is_claimed == true) {
                            $isClaimed = true;
                        } else {
                            $isClaimed = false;
                        }
                    }
                    $Lot_No = $validated_data['Lot_No'] === 'custom' ? $validated_data['customValue'] : $validated_data['Lot_No'];
    
                    $newlyaddedarea = Area::create([
                        'Lot_No' => $Lot_No,
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
                        'personal_information_id' => $personalInformation->id,
                        'is_claimed' => $isClaimed,
                    ]);
                    activity('Activity Logs')->causedBy(Auth::user())->performedOn($newlyaddedarea)->createdAt(now())->log('- Added a new area.');
                    return redirect()->route('admin.farmerDetails', ['currentRoute' => 'area', 'personalInformation' => $personalInformation, 'properties' => $personalInformation->area])->with('success', 'Area Successfully Added');
                } else {
                    return redirect()->route('admin.farmerDetails', ['currentRoute' => 'area', 'personalInformation' => $personalInformation, 'properties' => $personalInformation->area])->with('error', 'Similar Lot No. Must Have The Same Area Type!');
                }
            }
        }

        $isClaimed = false;
    
            foreach ($areas as $area) {
                if($area->is_claimed == true) {
                    $isClaimed = true;
                } else {
                    $isClaimed = false;
                }
            }
            $Lot_No = $validated_data['Lot_No'] === 'custom' ? $validated_data['customValue'] : $validated_data['Lot_No'];

            $newlyaddedarea = Area::create([
                'Lot_No' => $Lot_No,
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
                'personal_information_id' => $personalInformation->id,
                'is_claimed' => $isClaimed,
            ]);
            
            activity('Activity Logs')->causedBy(Auth::user())->performedOn($newlyaddedarea)->createdAt(now())->log('- Added a new area.');
            return redirect()->route('admin.farmerDetails', ['currentRoute' => 'area', 'personalInformation' => $personalInformation, 'properties' => $personalInformation->area])->with('success', 'Area Successfully Added');
    } 

    public function adminDestroy(Area $area): RedirectResponse {
        $area = $area;
        $personalinformation = $area->personalinformation;
        $area->delete();
        
        activity('Activity Logs')->causedBy(Auth::user())->performedOn($area)->createdAt(now())->log('- Deleted an area.');
        return redirect()->route('admin.farmerDetails', ['currentRoute' => 'area', 'personalInformation' => $personalinformation, 'properties' => $personalinformation->area])->with('success', 'Area Successfully Deleted');
    }
}
