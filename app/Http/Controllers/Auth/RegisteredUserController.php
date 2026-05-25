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
    public function create()
    {
        $adminExists = User::admins()->exists();

        return view('auth.register', compact('adminExists'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users', 'email')],
            'password' => ['required', 'confirmed', Rules\Password::defaults()->min(8)],
            'role' => ['required', 'in:user,admin'],
            'is_donor' => ['nullable', 'boolean'],
        ]);

        $adminExists = User::admins()->exists();

        if ($request->role === 'admin' && $adminExists) {
            return back()->withErrors(['role' => 'An admin account already exists.'])->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_donor' => $request->boolean('is_donor'),
        ]);

        event(new Registered($user));

        Auth::login($user);

        if ($user->isAdmin()) {
            return redirect()->route('admin.home');
        }

        return redirect()->route('dashboard');
    }
}