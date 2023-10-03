<?php

namespace App\Http\Controllers;

use App\Models\PersonalInformation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AdminController extends Controller
{
    //
    public function index(): View {
        return view('admin.dashboard', ['PersonalInformations' => PersonalInformation::get(), 'count' => PersonalInformation::count(),'userCount'=>User::count()]);
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

    public function personnel(Request $request) :View {
        return view('admin.personnel',['users'=>User::get()->skip($request->skip)->take(10),'userCount'=>User::count()]);
    }
    

    public function farmerDetails(PersonalInformation $personalInformation, string $currentRoute) :View{
        return view('admin.farmerDetails',['currentRoute' => $currentRoute, 'personalInformation' => $personalInformation]);
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
