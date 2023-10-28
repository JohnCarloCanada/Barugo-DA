<?php

namespace App\Http\Middleware;

use App\Events\HandleUser;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check()){
            if((int)Auth::user()->appaccess->app_id != 8) {
                HandleUser::dispatch($request);
                return redirect()->route('login.index')->with('status', "You are not allowed to access this page!");
            }
            
            if(Str::lower(Auth::user()->status) != 'active') {
                HandleUser::dispatch($request);
                return redirect()->route('login.index')->with('status', "Your account has been deactivated!");;
            }

            if(Str::lower(Auth::user()->user_role) == 'admin'){
                return $next($request);
            } else {
                return redirect()->route('user.dashboard');
            }

        } else 
        {
            return redirect()->route('login.index');
        }
        
    }
}
