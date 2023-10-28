<?php

namespace App\Http\Controllers;

use App\Models\PersonalInformation;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class GeoMappingController extends Controller
{
    //
    public function userShowSpecificFarmerMap(PersonalInformation $personalInformation): View {
        $SpecificFarmerArea = $personalInformation->area()->get();
        return view('user.location.index', ['locations' => $SpecificFarmerArea, 'farmers' => PersonalInformation::where('is_approved', true)->paginate(5), 'currentFarmer' => $personalInformation, 'search' => '']);
    }
}
