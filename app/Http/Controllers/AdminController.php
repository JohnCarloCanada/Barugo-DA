<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\PersonalInformation;
use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminController extends Controller
{
    //
    public function index(): View {
        $farmerCounts = PersonalInformation::where('is_approved', true)->count();
        $totalLocations = Area::count();

        return view('admin.dashboard', ['farmersCount' => $farmerCounts, 'locationsCount' => $totalLocations]);
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
}
