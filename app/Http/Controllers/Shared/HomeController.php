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
            if (auth()->user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('dashboard');
        }

        return view('home', $this->analyticsService->getGuestHomeData());
    }
}
