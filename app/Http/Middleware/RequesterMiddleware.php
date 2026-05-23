<?php

namespace App\Http\Middleware;

class RequesterMiddleware extends RoleMiddleware
{
    protected function requiredRole(): string
    {
        return 'requester';
    }

    protected function guestMessage(): string
    {
        return 'Please login as a requester to access this page.';
    }

    protected function unauthorizedMessage(): string
    {
        return 'Only requesters can access this section.';
    }
}
