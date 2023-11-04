<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminProfileController extends Controller
{
    //
    public function index(): View {
        return view('admin.profile.index', ['user' => Auth::user()]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse {
        $request->user()->fill($request->validated());
        $request->user()->save();
        return redirect()->route('adminProfile.index')->with('success', 'Profile updated successful');
    }
}
