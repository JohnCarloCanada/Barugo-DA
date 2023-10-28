<?php

namespace App\Http\Controllers;

use App\Models\Area;
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

    public function showMap(): View {
        return view('admin.location.index', ['locations' => Area::get()]);
    }

    public function farmerDetails(PersonalInformation $personalInformation, string $currentRoute): View {
        if ($currentRoute == "area") {
            return view('admin.farmerDetails', ['currentRoute' => $currentRoute, 'personalInformation' => $personalInformation, 'properties' => $personalInformation->area()->paginate(5)]);
        }
        elseif ($currentRoute == "livestock") {
            return view('admin.farmerDetails', ['currentRoute' => $currentRoute, 'personalInformation' => $personalInformation, 'properties' => $personalInformation->livestock()->paginate(5)]);
        }
        elseif ($currentRoute == "poultry") {
            return view('admin.farmerDetails', ['currentRoute' => $currentRoute, 'personalInformation' => $personalInformation, 'properties' => $personalInformation->poultry()->paginate(5)]);
        } 
        else {
            return view('admin.farmerDetails', ['currentRoute' => $currentRoute, 'personalInformation' => $personalInformation, 'properties' => $personalInformation->machinery()->paginate(5)]);
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
