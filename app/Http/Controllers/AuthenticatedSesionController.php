<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSesionController extends Controller
{
    public function index(): View {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse {
        $request->authenticate();
        $request->session()->regenerate();
        return redirect()->route('admin.dashboard');
    }

    public function destroy(Request $request): RedirectResponse {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.index');
    }
}
