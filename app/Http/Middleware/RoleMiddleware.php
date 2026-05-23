<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class RoleMiddleware
{
    abstract protected function requiredRole(): string;

    abstract protected function guestMessage(): string;

    abstract protected function unauthorizedMessage(): string;

    protected function redirectForRole(?string $role): string
    {
        return match ($role) {
            'admin' => route('admin.home'),
            'requester' => route('requester.home'),
            'donor' => route('donor.home'),
            default => '/',
        };
    }

    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check()) {
            return redirect('/login')->with('error', $this->guestMessage());
        }

        $user = auth()->user();
        $role = $user->role ?? null;

        if ($role === $this->requiredRole()) {
            return $next($request);
        }

        return redirect($this->redirectForRole($role))
            ->with('error', $this->unauthorizedMessage());
    }
}
