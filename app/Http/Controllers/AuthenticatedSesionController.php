<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
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

    public function loginPost(LoginRequest $request): RedirectResponse {
        $request->authenticate();
        $request->session();
        return redirect()->route('admin.dashboard');
        /* $request->validate([
            'employee_id' => 'required|string',
            'password' => 'required|string'
        ]);

        $password = $request->password;
        $employee_id = $request->employee_id;
        $user = User::Where('employee_id', $employee_id)->first();

        if($user && sha1($password) === $user->password) {
            Auth::login($user, $request->remember);
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('login.index'); */
    }

    public function destroy(Request $request): RedirectResponse {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.index');
    }
}
