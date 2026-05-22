<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
            'role' => ['required', 'in:donor,requester,admin'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();
        // Verify role selection matches stored user role (if user exists)
        $role = $this->string('role') ?? 'donor';
        $user = User::where('email', $this->string('email'))->first();

        if ($user) {
            if ($role === 'admin' && ! $user->isAdmin()) {
                RateLimiter::hit($this->throttleKey());

                throw ValidationException::withMessages([
                    'role' => 'The selected role does not match this account.',
                ]);
            }

            if ($role === 'donor' && $user->isAdmin()) {
                RateLimiter::hit($this->throttleKey());

                throw ValidationException::withMessages([
                    'role' => 'The selected role does not match this account.',
                ]);
            }
            if ($role === 'requester' && ! $user->isRequester()) {
                RateLimiter::hit($this->throttleKey());

                throw ValidationException::withMessages([
                    'role' => 'The selected role does not match this account.',
                ]);
            }
            if ($role !== 'requester' && $user->isRequester()) {
                RateLimiter::hit($this->throttleKey());

                throw ValidationException::withMessages([
                    'role' => 'The selected role does not match this account.',
                ]);
            }
        }

        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws ValidationException
     */
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

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}
