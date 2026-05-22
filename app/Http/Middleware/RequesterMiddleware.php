<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequesterMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check()) {
            return redirect('/login')->with('error', 'Please login as a requester to access this page.');
        }

        if (auth()->user()->isAdmin()) {
            return redirect('/admin')->with('error', 'Admins cannot access requester pages.');
        }

        if (auth()->user()->role !== 'requester') {
            return redirect('/donor/home')->with('error', 'Only requesters can access this section.');
        }

        return $next($request);
    }
}
