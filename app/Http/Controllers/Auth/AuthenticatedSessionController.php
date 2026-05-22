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
        // Use LoginRequest authenticate flow (includes role checks)
        $request->authenticate();

        $request->session()->regenerate();

        $redirectPath = auth()->user()->isAdmin()
            ? route('admin.home')
            : (auth()->user()->isRequester() ? route('requester.home') : route('donor.home'));

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'redirect' => $redirectPath,
            ]);
        }

        return redirect($redirectPath);
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