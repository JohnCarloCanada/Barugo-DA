<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\PersonalInformation;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

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

            // Get Middle Initial if there is
            $initial = '';
            if($area->personalinformation->Middle_Name) {
                $initial = Str::upper(Str::substr($area->personalinformation->Middle_Name, 0, 1)) . '.';
            } else {
                $initial = '';
            }

            $areasArray[] = [
                "RSBSA_No" => $area->personalinformation->RSBSA_No ?? null,
                "Lot_No" => $area->Lot_No,
                "Area_Type" => $area->Area_Type,
                "Lat" => $area->Lat,
                "Lon" => $area->Lon,
                "Name" => $area->personalinformation->First_Name . ' ' . $initial . ' ' . $area->personalinformation->Surname,
            ];
        }

        return view('user.location.index', ['locations' => collect($areasArray), 'farmers' => $paginatedResearchResult, 'currentFarmer' => NULL]);
    }

    public function userShowSpecificFarmerMap(PersonalInformation $personalInformation): View {
        $SpecificFarmerArea = $personalInformation->area()->get();

        $areasArray = [];

        foreach ($SpecificFarmerArea as $area) {
            // Get Middle Initial if there is
            $initial = '';
            if($area->personalinformation->Middle_Name) {
                $initial = Str::upper(Str::substr($area->personalinformation->Middle_Name, 0, 1)) . '.';
            } else {
                $initial = '';
            }
            
            $areasArray[] = [
                "RSBSA_No" => $area->personalinformation->RSBSA_No ?? null,
                "Lot_No" => $area->Lot_No,
                "Area_Type" => $area->Area_Type,
                "Lat" => $area->Lat,
                "Lon" => $area->Lon,
                "Name" => $area->personalinformation->First_Name . ' ' . $initial . ' ' . $area->personalinformation->Surname,
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

            // Get Middle Initial if there is
            $initial = '';
            if($area->personalinformation->Middle_Name) {
                $initial = Str::upper(Str::substr($area->personalinformation->Middle_Name, 0, 1)) . '.';
            } else {
                $initial = '';
            }

            $areasArray[] = [
                "RSBSA_No" => $area->personalinformation->RSBSA_No ?? null,
                "Lot_No" => $area->Lot_No,
                "Area_Type" => $area->Area_Type,
                "Lat" => $area->Lat,
                "Lon" => $area->Lon,
                "Name" => $area->personalinformation->First_Name . ' ' . $initial . ' ' . $area->personalinformation->Surname,
            ];
        }

        return view('admin.location.index', ['locations' => collect($areasArray), 'farmers' => $paginatedResearchResult, 'currentFarmer' => NULL]);
    }

    public function adminShowSpecificFarmerMap(PersonalInformation $personalInformation): View {
        $SpecificFarmerArea = $personalInformation->area()->get();

        $areasArray = [];

        foreach ($SpecificFarmerArea as $area) {

            // Get Middle Initial if there is
            $initial = '';
            if($area->personalinformation->Middle_Name) {
                $initial = Str::upper(Str::substr($area->personalinformation->Middle_Name, 0, 1)) . '.';
            } else {
                $initial = '';
            }

            $areasArray[] = [
                "RSBSA_No" => $area->personalinformation->RSBSA_No ?? null,
                "Lot_No" => $area->Lot_No,
                "Area_Type" => $area->Area_Type,
                "Lat" => $area->Lat,
                "Lon" => $area->Lon,
                "Name" => $area->personalinformation->First_Name . ' ' . $initial . ' ' . $area->personalinformation->Surname,
            ];
        }
        
        return view('admin.location.index', ['locations' => collect($areasArray), 'farmers' => PersonalInformation::where('is_approved', true)->paginate(5), 'currentFarmer' => $personalInformation, 'search' => '']);
    }
}
