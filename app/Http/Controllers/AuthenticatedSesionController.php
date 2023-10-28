<?php

namespace App\Http\Controllers;

use App\Events\HandleUser;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

    public function loginPost(LoginRequest $request): RedirectResponse {
        $request->authenticate();
        $request->session();
        return redirect()->route('admin.dashboard');
    }

    public function destroy(Request $request): RedirectResponse {
        HandleUser::dispatch($request);
        return redirect()->route('login.index');
    }
}
