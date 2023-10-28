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
        $count  = PersonalInformation::count();
        $latestEntries = PersonalInformation::orderBy('created_at', 'desc')->take(4)->get();
        $allLivestock = Livestock::get();
        $allMachineries = Machinery::get();

        $totalHectares = Area::sum('Hectares');

        return view('user.dashboard', ['count' => $count, 'latestEntries' => $latestEntries, 'livestocks' => $allLivestock, 'machineries' => $allMachineries, 'totalHectares' => (float)$totalHectares]);
    }

    public function managedFarmerDetails(PersonalInformation $personalInformation, string $currentRoute): View {
        if ($currentRoute == "area") {
            return view('user.managed.managedFarmersDetails', ['currentRoute' => $currentRoute, 'personalInformation' => $personalInformation, 'properties' => $personalInformation->area()->paginate(5)]);
        }
        elseif ($currentRoute == "livestock") {
            return view('user.managed.managedFarmersDetails', ['currentRoute' => $currentRoute, 'personalInformation' => $personalInformation, 'properties' => $personalInformation->livestock()->paginate(5)]);
        }
        elseif ($currentRoute == "poultry") {
            return view('user.managed.managedFarmersDetails', ['currentRoute' => $currentRoute, 'personalInformation' => $personalInformation, 'properties' => $personalInformation->poultry()->paginate(5)]);
        } 
        else {
            return view('user.managed.managedFarmersDetails', ['currentRoute' => $currentRoute, 'personalInformation' => $personalInformation, 'properties' => $personalInformation->machinery()->paginate(5)]);
        }
    }

    public function showMap(Request $request): View {
        $users = PersonalInformation::where(function($query) use ($request) {
            $query->where('RSBSA_No', 'LIKE', '%' . $request->search . '%')->orWhere('Surname', 'LIKE', '%' . $request->search . '%');
        })->get()->filter(function($user) {
            return $user->is_approved == true;
        });

        $perPage = 5;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $paginatedResearchResult = new LengthAwarePaginator(
            $users->forPage($currentPage, $perPage),
            $users->count(),
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath()],
        );

        return view('user.location.index', ['locations' => Area::get(), 'farmers' => $paginatedResearchResult, 'currentFarmer' => NULL]);
    }

    
}
