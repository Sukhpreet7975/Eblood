<?php

namespace App\Http\Middleware;

class DonorMiddleware extends RoleMiddleware
{
    protected function requiredRole(): string
    {
        return 'donor';
    }

    protected function guestMessage(): string
    {
        return 'Please login to access donor features.';
    }

    protected function unauthorizedMessage(): string
    {
        return 'Only donors can access this section.';
    }
}
