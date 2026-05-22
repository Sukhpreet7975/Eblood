<?php

namespace App\Http\Controllers;

use App\Models\BloodRequest;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            if (auth()->user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }

            return auth()->user()->isRequester()
                ? redirect()->route('requester.home')
                : redirect()->route('donor.home');
        }

        $donorQuery = User::donors();

        $totalDonors = (clone $donorQuery)
            ->whereNotNull('blood_group')
            ->count();

        $availableDonors = (clone $donorQuery)
            ->where('available', 'yes')
            ->count();

        $emergencyRequests = BloodRequest::count();

        $citiesCovered = collect(
            (clone $donorQuery)
                ->whereNotNull('city')
                ->pluck('city')
                ->filter()
                ->unique()
        )->count();

        $recentDonors = (clone $donorQuery)
            ->where('available', 'yes')
            ->latest('updated_at')
            ->take(6)
            ->get();

        return view('home', compact(
            'totalDonors',
            'availableDonors',
            'emergencyRequests',
            'citiesCovered',
            'recentDonors'
        ));
    }
}
