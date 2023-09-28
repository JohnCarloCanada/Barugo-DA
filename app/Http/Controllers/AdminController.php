<?php

namespace App\Http\Controllers;

use App\Models\PersonalInformation;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AdminController extends Controller
{
    //
    public function index(): View {
        return view('admin.dashboard', ['PersonalInformations' => PersonalInformation::get(), 'count' => PersonalInformation::count()]);
    }

    public function indexFarmer(): View {
        return view('admin.farmer',['PersonalInformations' => PersonalInformation::get()]);
    }


    public function approved(PersonalInformation $personalInformation) {
        $personalInformation->is_approved = true;
        $personalInformation->save();

        return redirect()->route('admin.farmer')->with('success', 'Farmer Successfully Approved');
    }

    public function delete(PersonalInformation $personalInformation) {
        $personalInformation->delete();
        return redirect()->route('admin.farmer')->with('success', 'Farmer Successfully Deleted');
    }

}
