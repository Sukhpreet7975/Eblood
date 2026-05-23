<?php

namespace App\Services;

use App\Models\BloodRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class DonorRecommendationService
{
    public function getDonorHomeData(User $user): array
    {
        $city = trim((string) ($user->city ?? ''));
        $bloodGroup = trim((string) ($user->blood_group ?? ''));

        $donorBase = User::donors()
            ->select(['_id', 'name', 'city', 'blood_group', 'available', 'profile_image', 'updated_at', 'created_at']);

        $activeDonors = (clone $donorBase)
            ->where('available', 'yes')
            ->latest('updated_at')
            ->take(5)
            ->get();

        $requests = BloodRequest::query()
            ->select(['_id', 'status', 'blood_group', 'city', 'created_at'])
            ->whereIn('status', ['Pending', 'Approved'])
            ->get();

        $nearbyRequests = $city
            ? $requests->where('city', $city)->count()
            : 0;

        $cityDemand = $city && $bloodGroup
            ? $requests->where('city', $city)->where('blood_group', $bloodGroup)->count()
            : 0;

        $profileCompletion = min(100, collect([
            ! empty($user->name),
            ! empty($user->phone),
            ! empty($user->blood_group),
            ! empty($user->city),
            ! empty($user->address),
            ! empty($user->profile_image),
        ])->filter()->count() * 16);

        $activityStatus = $user->available === 'yes'
            ? 'Available for urgent contact'
            : (optional($user->updated_at)->diffInMinutes(now()) < 60 ? 'Profile updated recently' : 'Currently unavailable');

        $badges = collect([]);

        if (optional($user->created_at)->diffInDays(now()) <= 7) {
            $badges->push('New Donor');
        }

        if ($user->available === 'yes') {
            $badges->push('Active Donor');
        }

        if ($nearbyRequests > 0) {
            $badges->push('Emergency Hero');
        }

        if ($cityDemand > 0) {
            $badges->push('Life Saver');
        }

        if ($profileCompletion >= 80) {
            $badges->push('Profile Ready');
        }

        $leaderboard = $city
            ? (clone $donorBase)
                ->where('city', $city)
                ->where('available', 'yes')
                ->latest('updated_at')
                ->take(5)
                ->get()
            : $activeDonors;

        $recommendations = collect([
            'Refresh your profile details so patients can contact you confidently.',
            $nearbyRequests > 0
                ? 'A nearby request is waiting for a compatible donor match.'
                : 'Keep your availability updated so you stay visible to patients in need.',
            $cityDemand > 0
                ? 'Your blood group is in strong demand in your city right now.'
                : 'Stay online and watch for new emergency requests in your area.',
        ])->take(3);

        return compact(
            'user',
            'profileCompletion',
            'nearbyRequests',
            'cityDemand',
            'activityStatus',
            'badges',
            'leaderboard',
            'activeDonors',
            'recommendations'
        );
    }

    public function getDonorSearchQuery(Request $request)
    {
        $query = User::donors()
            ->where('available', 'yes')
            ->select(['name', 'city', 'blood_group', 'available', 'profile_image', 'updated_at']);

        if ($request->filled('blood_group')) {
            $query->where('blood_group', trim((string) $request->blood_group));
        }

        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . trim((string) $request->city) . '%');
        }

        return $query;
    }

    public function getDonorSearchResults(Request $request)
    {
        return $this->getDonorSearchQuery($request)
            ->orderBy('updated_at', 'desc')
            ->paginate(6);
    }

    public function getLiveSearchResults(Request $request): array
    {
        return $this->getDonorSearchQuery($request)
            ->orderBy('updated_at', 'desc')
            ->get()
            ->map(function ($donor) {
                return [
                    'name' => $donor->name,
                    'city' => $donor->city,
                    'blood_group' => $donor->blood_group,
                    'available' => $donor->available,
                    'profile_image' => $donor->profile_image,
                    'updated_at' => $donor->updated_at,
                ];
            })
            ->all();
    }
}
