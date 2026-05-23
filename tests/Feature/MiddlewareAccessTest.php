<?php

use App\Http\Middleware\DonorMiddleware;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

test('donor routes redirect non-donor authenticated users to their own dashboard', function () {
    $middleware = new DonorMiddleware();
    $requester = new User([
        'name' => 'Requester One',
        'email' => 'requester.middleware@example.com',
        'password' => 'password',
        'role' => 'requester',
        'city' => 'Lahore',
    ]);
    $requester->id = 'requester-1';

    Auth::guard()->setUser($requester);

    $response = $middleware->handle(Request::create('/donor/home'), function () {
        return response('ok');
    });

    expect($response->isRedirect())->toBeTrue();
    expect($response->headers->get('Location'))->toBe(route('requester.home'));
});

test('guest users are redirected to login when accessing donor routes', function () {
    $middleware = new DonorMiddleware();

    $response = $middleware->handle(Request::create('/profile'), function () {
        return response('ok');
    });

    expect($response->isRedirect())->toBeTrue();
    expect($response->headers->get('Location'))->toBe(url('/login'));
});
