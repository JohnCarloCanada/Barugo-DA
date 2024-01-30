<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Livestock;
use App\Models\Machinery;
use App\Models\PersonalInformation;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;

class UserController extends Controller
{
    //
    public function index(): View {
        $count  = PersonalInformation::where('is_approved', true)->count();
        $latestEntries = PersonalInformation::orderBy('created_at', 'desc')->take(4)->get();
        $allLivestock = Livestock::get();
        $allMachineries = Machinery::get();

        $totalHectares = Area::sum('Hectares');

        return view('user.dashboard', ['count' => $count, 'latestEntries' => $latestEntries, 'livestocks' => $allLivestock, 'machineries' => $allMachineries, 'totalHectares' => (float)$totalHectares]);
    }

    public function managedFarmerDetails(PersonalInformation $personalInformation, string $currentRoute): View {
        if ($currentRoute == "area") {
            return view('user.managed.managedFarmersDetails', ['currentRoute' => $currentRoute, 'personalInformation' => $personalInformation, 'Farmers' => PersonalInformation::get(), 'properties' => $personalInformation->area()->paginate(5)]);
        }
        elseif ($currentRoute == "livestock") {
            return view('user.managed.managedFarmersDetails', ['currentRoute' => $currentRoute, 'personalInformation' => $personalInformation, 'Farmers' => PersonalInformation::get(), 'properties' => $personalInformation->livestock()->paginate(5)]);
        }
        elseif ($currentRoute == "poultry") {
            return view('user.managed.managedFarmersDetails', ['currentRoute' => $currentRoute, 'personalInformation' => $personalInformation, 'Farmers' => PersonalInformation::get(), 'properties' => $personalInformation->poultry()->paginate(5)]);
        } 
        else {
            return view('user.managed.managedFarmersDetails', ['currentRoute' => $currentRoute, 'personalInformation' => $personalInformation, 'Farmers' => PersonalInformation::get(), 'properties' => $personalInformation->machinery()->paginate(5)]);
        }
    }
}
