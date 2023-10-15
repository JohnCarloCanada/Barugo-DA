<?php

namespace App\Http\Controllers;

use App\Models\PersonalInformation;
use Database\Seeders\all;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    //
    public function index(): View {
        return view('user.dashboard', ['count' => PersonalInformation::count(), 
                    'latestEntries' => PersonalInformation::orderBy('created_at', 'desc')->take(4)->get()]);
    }

    public function managedFarmerDetails(PersonalInformation $personalInformation, string $currentRoute): View {
        if ($currentRoute == "personal") {
            return view('user.managed.managedFarmersDetails', ['currentRoute' => $currentRoute, 'personalInformation' => $personalInformation, 'properties' => $personalInformation->livestock]);
        }
        elseif ($currentRoute == "live-stack") {
            return view('user.managed.managedFarmersDetails', ['currentRoute' => $currentRoute, 'personalInformation' => $personalInformation, 'properties' => $personalInformation->livestock]);
        }
        elseif ($currentRoute == "poultry") {
            return view('user.managed.managedFarmersDetails', ['currentRoute' => $currentRoute, 'personalInformation' => $personalInformation, 'properties' => $personalInformation->livestock]);
        } 
        else {
            return view('user.managed.managedFarmersDetails', ['currentRoute' => $currentRoute, 'personalInformation' => $personalInformation, 'properties' => $personalInformation->livestock]);
        }
    }
}
