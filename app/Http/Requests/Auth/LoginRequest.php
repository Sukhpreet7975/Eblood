<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
            'role' => ['required', 'in:user,admin'],
        ];
    }

    public function authenticate(): User
    {
        $this->ensureIsNotRateLimited();

        $email = strtolower(trim((string) $this->input('email')));
        $password = (string) $this->input('password');
        $selectedRole = (string) $this->input('role');
        $remember = $this->boolean('remember');

        $user = User::where('email', $email)->first();

        if (! $user) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        if (! Hash::check($password, $user->password)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'password' => trans('auth.failed'),
            ]);
        }

        if (! $this->roleMatches($user, $selectedRole)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'role' => 'The selected role does not match this account.',
            ]);
        }

        Auth::login($user, $remember);
        RateLimiter::clear($this->throttleKey());

        return $user;
    }

    protected function roleMatches(User $user, string $selectedRole): bool
    {
        return match ($selectedRole) {
            'admin' => $user->isAdmin(),
            'user' => $user->isUser(),
            default => false,
        };
    }

    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower((string) $this->input('email')).'|'.$this->ip());
    }
}
