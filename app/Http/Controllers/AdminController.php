<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\DogInformation;
use App\Models\Livestock;
use App\Models\PersonalInformation;
use App\Models\Poultry;
use App\Models\SeedInventory;
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
        $totalSeeds = SeedInventory::sum('Quantity');
        $totalVaccinations = DogInformation::count();
        $totalAnimals = Livestock::count() + Poultry::sum('Quantity');

        return view('admin.dashboard', ['farmersCount' => $farmerCounts, 'locationsCount' => $totalLocations, 'totalSeeds' => $totalSeeds, 'totalVaccinations' => $totalVaccinations, 'totalAnimals' => $totalAnimals]);
    }

    public function farmerDetails(PersonalInformation $personalInformation, string $currentRoute): View {
        if ($currentRoute == "area") {
            return view('admin.farmer.farmerDetails', ['currentRoute' => $currentRoute, 'personalInformation' => $personalInformation, 'Farmers' => PersonalInformation::get(), 'properties' => $personalInformation->area()->paginate(5)]);
        }
        elseif ($currentRoute == "livestock") {
            return view('admin.farmer.farmerDetails', ['currentRoute' => $currentRoute, 'personalInformation' => $personalInformation, 'Farmers' => PersonalInformation::get(), 'properties' => $personalInformation->livestock()->paginate(5)]);
        }
        elseif ($currentRoute == "poultry") {
            return view('admin.farmer.farmerDetails', ['currentRoute' => $currentRoute, 'personalInformation' => $personalInformation, 'Farmers' => PersonalInformation::get(), 'properties' => $personalInformation->poultry()->paginate(5)]);
        } 
        else {
            return view('admin.farmer.farmerDetails', ['currentRoute' => $currentRoute, 'personalInformation' => $personalInformation, 'Farmers' => PersonalInformation::get(), 'properties' => $personalInformation->machinery()->paginate(5)]);
        }
    }
}
