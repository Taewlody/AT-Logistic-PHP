<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
       
        // Allowed roles
        $allowedRoles = ['Admin', 'Shipping Officer', 'Account']; // Add all roles that can access the route

        // Check if the user is authenticated and their role matches
        if (Auth::check() && in_array(Auth::user()->UserType->userTypeName, $allowedRoles)) {
            return $next($request); // Allow access
        }

        // Deny access
        abort(403, 'Unauthorized access');
    }
}
