<?php

namespace App\Http\Middleware;

use Closure;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

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
                activity()->causedBy(Auth::user())->createdAt(now())->log('- Logged In');

                // HRMS Users Logs
                $todayDate = new DateTime();
                $user_id = Auth::user()->id;
                $activityLog = ['user_id'=> $user_id, 'description' => 'Has log in', 'date_time' => $todayDate->format('D, M j, Y g:i A'), 'created_at' => now(), 'updated_at' => now()];
                DB::connection('secondary')->table('user_logs')->insert($activityLog);
                return $next($request);
            } else {
                return $next($request);
            }
        } else {
            return $next($request);
        }
    }
}
