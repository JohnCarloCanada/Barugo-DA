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

        $areas = Area::get();
        $areasArray = [];

        foreach ($areas as $area) {
            $areasArray[] = [
                "RSBSA_No" => $area->personalinformation->RSBSA_No ?? null,
                "Lot_No" => $area->Lot_No,
                "Area_Type" => $area->Area_Type,
                "Lat" => $area->Lat,
                "Lon" => $area->Lon,
            ];
        }

        return view('user.location.index', ['locations' => collect($areasArray), 'farmers' => $paginatedResearchResult, 'currentFarmer' => NULL]);
    }

    public function userShowSpecificFarmerMap(PersonalInformation $personalInformation): View {
        $SpecificFarmerArea = $personalInformation->area()->get();

        $areasArray = [];

        foreach ($SpecificFarmerArea as $area) {
            $areasArray[] = [
                "RSBSA_No" => $area->personalinformation->RSBSA_No ?? null,
                "Lot_No" => $area->Lot_No,
                "Area_Type" => $area->Area_Type,
                "Lat" => $area->Lat,
                "Lon" => $area->Lon,
            ];
        }
        
        return view('user.location.index', ['locations' => collect($areasArray), 'farmers' => PersonalInformation::where('is_approved', true)->paginate(5), 'currentFarmer' => $personalInformation, 'search' => '']);
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

        $areas = Area::get();
        $areasArray = [];

        foreach ($areas as $area) {
            $areasArray[] = [
                "RSBSA_No" => $area->personalinformation->RSBSA_No ?? null,
                "Lot_No" => $area->Lot_No,
                "Area_Type" => $area->Area_Type,
                "Lat" => $area->Lat,
                "Lon" => $area->Lon,
            ];
        }

        return view('admin.location.index', ['locations' => collect($areasArray), 'farmers' => $paginatedResearchResult, 'currentFarmer' => NULL]);
    }

    public function adminShowSpecificFarmerMap(PersonalInformation $personalInformation): View {
        $SpecificFarmerArea = $personalInformation->area()->get();

        $areasArray = [];

        foreach ($SpecificFarmerArea as $area) {
            $areasArray[] = [
                "RSBSA_No" => $area->personalinformation->RSBSA_No ?? null,
                "Lot_No" => $area->Lot_No,
                "Area_Type" => $area->Area_Type,
                "Lat" => $area->Lat,
                "Lon" => $area->Lon,
            ];
        }
        
        return view('admin.location.index', ['locations' => collect($areasArray), 'farmers' => PersonalInformation::where('is_approved', true)->paginate(5), 'currentFarmer' => $personalInformation, 'search' => '']);
    }
}
