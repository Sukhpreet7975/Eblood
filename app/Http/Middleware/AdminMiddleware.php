<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->check() && auth()->user()->isAdmin())
        {
            return $next($request);
        }

        if(!auth()->check()){
            return redirect('/login')->with('error', 'Please login as admin to access this page.');
        }

        return redirect('/')->with('error', 'Unauthorized admin access.');
    }
}