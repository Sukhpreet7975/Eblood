<?php

namespace App\Http\Middleware;

class AdminMiddleware extends RoleMiddleware
{
    protected function requiredRole(): string
    {
        return 'admin';
    }

    protected function guestMessage(): string
    {
        return 'Please login as an admin to access this page.';
    }

    protected function unauthorizedMessage(): string
    {
        return 'Only admins can access this section.';
    }
}