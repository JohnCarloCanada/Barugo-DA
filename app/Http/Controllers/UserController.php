<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    //
    public function index(): View {
        return view('user.dashboard');
    }
}