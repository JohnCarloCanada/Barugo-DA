<?php

namespace App\Http\Controllers;

use App\Models\PersonalInformation;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminPersonalInformationController extends Controller
{
    public function farmer(): View {
        return view('admin.farmer.farmer', ['PersonalInformations' => PersonalInformation::where('is_approved', true)->paginate(5)]);
    }

    public function needApproval(): View {
        return view('admin.farmer.approval', ['PersonalInformations' => PersonalInformation::where('is_approved', false)->paginate(5)]);
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
}
