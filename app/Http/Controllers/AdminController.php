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

    public function farmer(): View {
        return view('admin.farmer',['PersonalInformations' => PersonalInformation::get()]);
    }

    public function location(): View {
        return view('admin.location');
    }

    public function mapLocation(): View {
        return view('admin.map');
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
