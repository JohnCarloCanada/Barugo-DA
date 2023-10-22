<?php

namespace App\Http\Controllers;

use App\Models\PersonalInformation;
use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AdminController extends Controller
{
    //
    public function index(): View {
        return view('admin.dashboard', ['PersonalInformations' => PersonalInformation::get(), 'count' => PersonalInformation::count(), 'userCounts' => UserDetails::where('user_role', 'User')->count()]);
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

   
    

    public function farmerDetails(PersonalInformation $personalInformation, string $currentRoute): View{
        if ($currentRoute == "personal") {
            return view('admin.farmerDetails', ['currentRoute' => $currentRoute, 'personalInformation' => $personalInformation, 'properties' => $personalInformation->livestock]);
        }
        elseif ($currentRoute == "livestock") {
            return view('admin.farmerDetails', ['currentRoute' => $currentRoute, 'personalInformation' => $personalInformation, 'properties' => $personalInformation->livestock]);
        }
        elseif ($currentRoute == "poultry") {
            return view('admin.farmerDetails', ['currentRoute' => $currentRoute, 'personalInformation' => $personalInformation, 'properties' => $personalInformation->livestock]);
        } 
        else {
            return view('admin.farmerDetails', ['currentRoute' => $currentRoute, 'personalInformation' => $personalInformation, 'properties' => $personalInformation->machinery]);
        }
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
