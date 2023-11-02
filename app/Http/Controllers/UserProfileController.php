<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    //
    public function index(): View {
        return view('user.profile.index');
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse {
        $request->user()->fill($request->validated());
        $request->user()->save();
        return redirect()->route('userProfile.index')->with('success', 'Profile updated successful');
    }
}
