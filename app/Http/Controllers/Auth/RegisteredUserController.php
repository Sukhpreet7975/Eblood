<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create()
    {
        $adminExists = User::admins()->exists();

        return view('auth.register', compact('adminExists'));
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users', 'email')],
            'password' => ['required', 'confirmed', Rules\Password::defaults()->min(8)],
            'role' => ['required', 'in:donor,requester,admin'],
        ]);

        // Prevent duplicate admin creation
        $adminExists = User::admins()->exists();

        if ($request->role === 'admin' && $adminExists) {
            return back()->withErrors(['role' => 'An admin account already exists.'])->withInput();
        }

        $role = $request->role;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $role,
        ]);

        event(new Registered($user));

        Auth::login($user);

        // ✅ ROLE BASED REDIRECT
        if ($user->isAdmin()) {
            return redirect()->route('admin.home');
        }

        return $user->isRequester() ? redirect()->route('requester.home') : redirect()->route('donor.home');
    }
}