<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Livestock;
use App\Models\Machinery;
use App\Models\PersonalInformation;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    //
    public function index(): View {
        $count  = PersonalInformation::count();
        $latestEntries = PersonalInformation::orderBy('created_at', 'desc')->take(4)->get();
        $allLivestock = Livestock::get();
        $allMachineries = Machinery::get();

        $totalHectares = Area::sum('Hectares');

        return view('user.dashboard', ['count' => $count, 'latestEntries' => $latestEntries, 'livestocks' => $allLivestock, 'machineries' => $allMachineries, 'totalHectares' => (int)$totalHectares]);
    }

    public function managedFarmerDetails(PersonalInformation $personalInformation, string $currentRoute): View {
        if ($currentRoute == "area") {
            return view('user.managed.managedFarmersDetails', ['currentRoute' => $currentRoute, 'personalInformation' => $personalInformation, 'properties' => $personalInformation->area]);
        }
        elseif ($currentRoute == "livestock") {
            return view('user.managed.managedFarmersDetails', ['currentRoute' => $currentRoute, 'personalInformation' => $personalInformation, 'properties' => $personalInformation->livestock]);
        }
        elseif ($currentRoute == "poultry") {
            return view('user.managed.managedFarmersDetails', ['currentRoute' => $currentRoute, 'personalInformation' => $personalInformation, 'properties' => $personalInformation->livestock]);
        } 
        else {
            return view('user.managed.managedFarmersDetails', ['currentRoute' => $currentRoute, 'personalInformation' => $personalInformation, 'properties' => $personalInformation->machinery]);
        }
    }

    public function showMap(): View {
        return view('user.location.index', ['locations' => Area::get()]);
    }
}
