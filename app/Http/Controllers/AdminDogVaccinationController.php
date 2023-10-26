<?php

namespace App\Http\Controllers;

use App\Models\DogInformation;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AdminDogVaccinationController extends Controller
{
    //
    public function index(): View {
        return view('admin.vaccination.index', ['DogInformations' => DogInformation::get()]);
    }
}
