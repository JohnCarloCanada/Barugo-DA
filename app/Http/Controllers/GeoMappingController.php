<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\PersonalInformation;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class GeoMappingController extends Controller
{
    //
    // Employee/Users

    public function userShowMap(Request $request): View {
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

    public function userShowSpecificFarmerMap(PersonalInformation $personalInformation): View {
        $SpecificFarmerArea = $personalInformation->area()->get();
        return view('user.location.index', ['locations' => $SpecificFarmerArea, 'farmers' => PersonalInformation::where('is_approved', true)->paginate(5), 'currentFarmer' => $personalInformation, 'search' => '']);
    }

    //Admin

    public function adminShowMap(Request $request): View {
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

        return view('admin.location.index', ['locations' => Area::get(), 'farmers' => $paginatedResearchResult, 'currentFarmer' => NULL]);
    }

    public function adminShowSpecificFarmerMap(PersonalInformation $personalInformation): View {
        $SpecificFarmerArea = $personalInformation->area()->get();
        return view('admin.location.index', ['locations' => $SpecificFarmerArea, 'farmers' => PersonalInformation::where('is_approved', true)->paginate(5), 'currentFarmer' => $personalInformation, 'search' => '']);
    }
}
