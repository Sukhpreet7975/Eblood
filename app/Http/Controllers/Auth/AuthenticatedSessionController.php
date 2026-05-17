<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Http\Requests\Auth\LoginRequest;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Show Login Page
    |--------------------------------------------------------------------------
    */

    public function create(): View
    {
        return view('auth.login');
    }

    /*
    |--------------------------------------------------------------------------
    | Login User
    |--------------------------------------------------------------------------
    */

    public function store(
        LoginRequest $request
    ): RedirectResponse|JsonResponse
    {
        $credentials = $request->only(

            'email',

            'password'

        );

        /*
        |--------------------------------------------------------------------------
        | Attempt Login
        |--------------------------------------------------------------------------
        */

        if(
            Auth::attempt(
                $credentials,
                $request->remember
            )
        )
        {
            $request->session()
                ->regenerate();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'redirect' => auth()->user()->is_admin ? '/admin' : '/dashboard',
                ]);
            }

            if (auth()->user()->is_admin) {
                return redirect('/admin');
            }

            return redirect('/dashboard');
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials. Please try again.',
            ], 422);
        }

        return back()
            ->with(
                'error',
                'Invalid credentials. Please try again.'
            )
            ->withInput(
                $request->only('email')
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Logout User
    |--------------------------------------------------------------------------
    */

    public function destroy(
        Request $request
    ): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()
            ->invalidate();

        $request->session()
            ->regenerateToken();

        return redirect('/');
    }
}