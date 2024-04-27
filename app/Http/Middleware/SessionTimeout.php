<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class SessionTimeout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && ! $request->session()->has('lastActivityTime')) {
            $request->session()->put('lastActivityTime', time());
        }

        $maxIdleTime = config('session.lifetime') * 60;

        if (Auth::check() && $request->session()->has('lastActivityTime') && (time() - $request->session()->get('lastActivityTime') > $maxIdleTime)) {
            
            Auth::logout();

            return redirect()->route('login')->withErrors(['msg' => 'Session timeout. Please login again.']);
        }

        $request->session()->put('lastActivityTime', time());
        
        return $next($request);
    }
}
