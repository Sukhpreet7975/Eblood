<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DonorMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // guest -> redirect to login with message
        if(!auth()->check()){
            return redirect('/login')->with('error', 'Please login to access donor features.');
        }

        // admins cannot access donor routes
        if(auth()->user()->isAdmin()){
            return redirect('/admin')->with('error', 'Admins cannot access donor pages.');
        }

        return $next($request);
    }
}
