<?php

namespace App\Http\Controllers;

use App\Models\PersonalInformation;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminPersonalInformationController extends Controller
{
    public function farmer(): View {
        $approvedFarmers = PersonalInformation::where('is_approved', true)->paginate(5);
        $notApprovedFarmersCount = PersonalInformation::where('is_approved', false)->count();
        $needUpdateFarmersCount = PersonalInformation::where('update_status', true)->count();
        return view('admin.farmer.farmer', ['PersonalInformations' => $approvedFarmers, 'notApprovedCount' => $notApprovedFarmersCount, 'needUpdateFarmersCount' => $needUpdateFarmersCount]);
    }

    public function needApproval(): View {
        $notApprovedFarmers = PersonalInformation::where('is_approved', false)->paginate(5);
        $notApprovedFarmersCount = PersonalInformation::where('is_approved', false)->count();
        $needUpdateFarmersCount = PersonalInformation::where('update_status', true)->count();
        return view('admin.farmer.approval', ['PersonalInformations' => $notApprovedFarmers, 'notApprovedCount' => $notApprovedFarmersCount, 'needUpdateFarmersCount' => $needUpdateFarmersCount]);
    }

    public function needUpdate(): View {
        $needUpdateFarmers = PersonalInformation::where('is_approved', true)->where('update_status', true)->paginate(5);
        $notApprovedFarmersCount = PersonalInformation::where('is_approved', false)->count();
        $needUpdateFarmersCount = PersonalInformation::where('update_status', true)->count();
        return view('admin.farmer.update', ['PersonalInformations' => $needUpdateFarmers, 'notApprovedCount' => $notApprovedFarmersCount, 'needUpdateFarmersCount' => $needUpdateFarmersCount]);
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
}
