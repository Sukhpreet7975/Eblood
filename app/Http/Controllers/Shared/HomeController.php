<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Services\AnalyticsService;

class HomeController extends Controller
{
    public function __construct(protected AnalyticsService $analyticsService)
    {
    }

    public function index()
    {
        if (auth()->check()) {
            if (auth()->user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return auth()->user()->role === 'requester'
                ? redirect()->route('requester.home')
                : redirect()->route('donor.home');
        }

        return view('home', $this->analyticsService->getGuestHomeData());
    }
}
