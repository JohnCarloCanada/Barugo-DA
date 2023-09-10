<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
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

        /* $validation_rules = [
            'email' => 'required|string|email',
            'password' => 'required|string'
        ];

        $custom_msg = [
            'email' => ':attribute is not a valid email address',
            'password' => ':attribute is not a valid',
        ];

        $custom_attribute = [
            'email' => 'Email Address',
            'password' => 'Password',
        ];

        $credentials = Validator::make($request->all(), $validation_rules, $custom_msg, $custom_attribute);

        if(Auth::attempt($credentials->validated())) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email'); */
    }

    public function destroy(Request $request): RedirectResponse {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.index');
    }
}
