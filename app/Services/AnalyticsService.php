<?php

namespace App\Services;

use App\Models\BloodRequest;
use App\Models\User;
use Illuminate\Support\Collection;

class AnalyticsService
{
    public function getAdminDashboardData(): array
    {
        $totalDonors = User::where('role', 'donor')->count();
        $availableDonors = User::where('role', 'donor')->where('available', 'yes')->count();
        $totalRequesters = User::where('role', 'requester')->count();
        $activeRequesters = User::where('role', 'requester')->whereHas('requests')->count();

        $bloodRequests = BloodRequest::count();
        $pendingRequests = BloodRequest::where('status', 'Pending')->count();
        $approvedRequests = BloodRequest::where('status', 'Approved')->count();
        $completedRequests = BloodRequest::where('status', 'Completed')->count();
        $rejectedRequests = BloodRequest::where('status', 'Rejected')->count();

        $recentDonors = User::where('role', 'donor')->latest()->take(5)->get();
        $recentRequesters = User::where('role', 'requester')->latest()->take(5)->get();
        $latestRequests = BloodRequest::latest()->take(5)->get();

        $donorBloodGroups = ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'];
        $donorList = User::where('role', 'donor')->get(['blood_group', 'city']);
        $bloodGroupData = array_fill(0, count($donorBloodGroups), 0);
        $donorCityCounts = [];

        foreach ($donorList as $donor) {
            $bloodGroup = trim((string) ($donor->blood_group ?? ''));
            $city = trim((string) ($donor->city ?? 'Unknown')) ?: 'Unknown';

            $bgIndex = array_search($bloodGroup, $donorBloodGroups, true);
            if ($bgIndex !== false) {
                $bloodGroupData[$bgIndex]++;
            }

            $donorCityCounts[$city] = ($donorCityCounts[$city] ?? 0) + 1;
        }

        arsort($donorCityCounts);
        $donorCityLabels = array_slice(array_keys($donorCityCounts), 0, 8);
        $donorCityData = array_values(array_slice($donorCityCounts, 0, 8));

        $donorAvailabilityData = [
            $availableDonors,
            max($totalDonors - $availableDonors, 0),
        ];

        $requesterCityCounts = [];
        $requesterList = User::where('role', 'requester')->get(['city']);
        foreach ($requesterList as $requester) {
            $city = trim((string) ($requester->city ?? 'Unknown')) ?: 'Unknown';
            $requesterCityCounts[$city] = ($requesterCityCounts[$city] ?? 0) + 1;
        }

        arsort($requesterCityCounts);
        $requesterCityLabels = array_slice(array_keys($requesterCityCounts), 0, 8);
        $requesterCityData = array_values(array_slice($requesterCityCounts, 0, 8));

        $requestsByCityCounts = [];
        $requestCities = BloodRequest::whereNotNull('city')->get(['city']);
        foreach ($requestCities as $request) {
            $city = trim((string) ($request->city ?? 'Unknown')) ?: 'Unknown';
            $requestsByCityCounts[$city] = ($requestsByCityCounts[$city] ?? 0) + 1;
        }

        arsort($requestsByCityCounts);
        $requestsByCityLabels = array_slice(array_keys($requestsByCityCounts), 0, 8);
        $requestsByCityData = array_values(array_slice($requestsByCityCounts, 0, 8));

        $requestsPerRequester = $totalRequesters > 0 ? round($bloodRequests / $totalRequesters, 1) : 0;
        $activeRequesterSeries = [
            $activeRequesters,
            max($totalRequesters - $activeRequesters, 0),
        ];

        return compact(
            'totalDonors',
            'availableDonors',
            'totalRequesters',
            'activeRequesters',
            'bloodRequests',
            'pendingRequests',
            'approvedRequests',
            'completedRequests',
            'rejectedRequests',
            'recentDonors',
            'recentRequesters',
            'latestRequests',
            'bloodGroupData',
            'donorBloodGroups',
            'donorCityLabels',
            'donorCityData',
            'donorAvailabilityData',
            'requesterCityLabels',
            'requesterCityData',
            'requestsByCityLabels',
            'requestsByCityData',
            'requestsPerRequester',
            'activeRequesterSeries'
        );
    }

    public function getAdminHomeData(): array
    {
        $admin = auth()->user();

        $totalDonors = User::where('role', 'donor')->count();
        $availableDonors = User::where('role', 'donor')->where('available', 'yes')->count();
        $totalRequests = BloodRequest::count();
        $pendingRequests = BloodRequest::where('status', 'Pending')->count();
        $latestDonors = User::where('role', 'donor')->latest()->take(4)->get();
        $recentActivities = BloodRequest::with('user')->latest()->take(4)->get();
        $totalRequesters = User::where('role', 'requester')->count();

        return compact(
            'admin',
            'totalDonors',
            'availableDonors',
            'totalRequests',
            'pendingRequests',
            'latestDonors',
            'recentActivities',
            'totalRequesters'
        );
    }

    public function getGuestHomeData(): array
    {
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

        return compact(
            'totalDonors',
            'availableDonors',
            'emergencyRequests',
            'citiesCovered',
            'recentDonors'
        );
    }
}
