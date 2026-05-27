<?php

namespace App\Services;

use App\Models\BloodRequest;
use App\Models\User;
// Collection not required here

class AnalyticsService
{
    public function getAdminDashboardData(): array
    {
        // Users
        $totalUsers = User::users()->count();
        $activeUsers = User::users()->whereHas('requests')->count();

        // Donor-specific counts (use scopeDonors which respects `is_donor`)
        $totalDonors = User::donors()->count();
        $availableDonors = User::donors()->where('available', 'yes')->count();

        // Requests
        $bloodRequests = BloodRequest::count();
        $pendingRequests = BloodRequest::where('status', 'Pending')->count();
        $approvedRequests = BloodRequest::where('status', 'Approved')->count();
        $completedRequests = BloodRequest::where('status', 'Completed')->count();
        $rejectedRequests = BloodRequest::where('status', 'Rejected')->count();
        $recentDonors = User::donors()->latest()->take(5)->get();
        $recentUsers = User::users()->latest()->take(5)->get();
        $latestRequests = BloodRequest::latest()->take(5)->get();

        $donorBloodGroups = ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'];
        $donorList = User::donors()->get(['blood_group', 'city']);
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

        // User (non-admin) city distribution for user analytics
        $userCityCounts = [];
        $userList = User::users()->get(['city']);
        foreach ($userList as $u) {
            $city = trim((string) ($u->city ?? 'Unknown')) ?: 'Unknown';
            $userCityCounts[$city] = ($userCityCounts[$city] ?? 0) + 1;
        }

        arsort($userCityCounts);
        $userCityLabels = array_slice(array_keys($userCityCounts), 0, 8);
        $userCityData = array_values(array_slice($userCityCounts, 0, 8));

        $requestsByCityCounts = [];
        $requestCities = BloodRequest::whereNotNull('city')->get(['city']);
        foreach ($requestCities as $request) {
            $city = trim((string) ($request->city ?? 'Unknown')) ?: 'Unknown';
            $requestsByCityCounts[$city] = ($requestsByCityCounts[$city] ?? 0) + 1;
        }

        arsort($requestsByCityCounts);
        $requestsByCityLabels = array_slice(array_keys($requestsByCityCounts), 0, 8);
        $requestsByCityData = array_values(array_slice($requestsByCityCounts, 0, 8));

        $requestsPerUser = $totalUsers > 0 ? round($bloodRequests / $totalUsers, 1) : 0;
        $activeUserSeries = [
            $activeUsers,
            max($totalUsers - $activeUsers, 0),
        ];
        // Return both new semantic keys and legacy keys for compatibility.
        $data = compact(
            'totalUsers',
            'totalDonors',
            'availableDonors',
            'bloodRequests',
            'pendingRequests',
            'approvedRequests',
            'completedRequests',
            'rejectedRequests',
            'recentDonors',
            'recentUsers',
            'latestRequests',
            'bloodGroupData',
            'donorBloodGroups',
            'donorCityLabels',
            'donorCityData',
            'donorAvailabilityData',
            'userCityLabels',
            'userCityData',
            'requestsByCityLabels',
            'requestsByCityData',
            'requestsPerUser',
            'activeUserSeries'
        );

        // Legacy aliases
        $data['totalRequesters'] = $totalUsers;
        $data['activeRequesters'] = $activeUsers;
        $data['requesterCityLabels'] = $userCityLabels;
        $data['requesterCityData'] = $userCityData;
        $data['requestsPerRequester'] = $requestsPerUser;
        $data['activeRequesterSeries'] = $activeUserSeries;

        return $data;
    }

    public function getAdminHomeData(): array
    {
        $admin = auth()->user();

        $totalDonors = User::donors()->count();
        $availableDonors = User::donors()->where('available', 'yes')->count();
        $totalRequests = BloodRequest::count();
        $pendingRequests = BloodRequest::where('status', 'Pending')->count();
        $latestDonors = User::donors()->latest()->take(4)->get();
        $recentActivities = BloodRequest::with('user')->latest()->take(4)->get();
        $totalUsers = User::users()->count();

        return compact(
            'admin',
            'totalUsers',
            'totalDonors',
            'availableDonors',
            'totalRequests',
            'pendingRequests',
            'latestDonors',
            'recentActivities'
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
