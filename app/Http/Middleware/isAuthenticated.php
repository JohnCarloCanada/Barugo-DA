<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class isAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $lastRouteName = Session::get('last_route_name') ?? $request->route()->getName();
        if(Auth::check()) {
            if($lastRouteName === 'login.index') {
                activity()->causedBy(Auth::user())->createdAt(now())->log('logged In');
                return $next($request);
            } else {
                return $next($request);
            }
        } else {
            return $next($request);
        }
    }
}
