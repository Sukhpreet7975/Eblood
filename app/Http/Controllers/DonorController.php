<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\BloodRequest;

class DonorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'donor'])->except(['home', 'search', 'liveSearch']);
    }

    /*
    |--------------------------------------------------------------------------
    | Home Page
    |--------------------------------------------------------------------------
    */

    public function home()
    {
        // Public-facing home previously pointed here; keep backward compatibility
        $donors = User::donors()->where('available', 'yes')->paginate(6);

        return view('home', compact('donors'));
    }

    /**
     * Donor Home (separate from dashboard)
     */
    public function donorHome()
    {
        if(auth()->check() && auth()->user()->isAdmin())
        {
            return redirect('/admin');
        }

        $user = auth()->user();

        if (! $user) {
            return redirect('/login');
        }

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
            !empty($user->name),
            !empty($user->phone),
            !empty($user->blood_group),
            !empty($user->city),
            !empty($user->address),
            !empty($user->profile_image),
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

        return view('donor.home', compact(
            'user',
            'profileCompletion',
            'nearbyRequests',
            'cityDemand',
            'activityStatus',
            'badges',
            'leaderboard',
            'activeDonors',
            'recommendations'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    public function profile()
    {
          // Prevent admins from accessing user profile
          if(auth()->check() && auth()->user()->isAdmin())
          {
              return redirect('/admin');
          }

        $user = auth()->user();

        return view('profile', compact('user'));
    }

    /*
    |--------------------------------------------------------------------------
    | Edit Profile
    |--------------------------------------------------------------------------
    */

    public function edit()
    {
          // Prevent admins from accessing user profile edit
          if(auth()->check() && auth()->user()->isAdmin())
          {
              return redirect('/admin');
          }

        $user = auth()->user();

        return view('edit-profile', compact('user'));
    }

    /*
    |--------------------------------------------------------------------------
    | Update Profile
    |--------------------------------------------------------------------------
    */

    public function update(Request $request)
    {
          // Prevent admins from updating user profile
          if(auth()->check() && auth()->user()->isAdmin())
          {
              return redirect('/admin');
          }

        $request->validate([

            'phone' => 'required|min:10|max:15',

            'blood_group' => 'required',

            'city' => 'required',

            'address' => 'required|min:5',

        ]);

        $user = auth()->user();

        $user->phone = $request->phone;

        $user->blood_group = trim($request->blood_group);

        $user->city = trim($request->city);

        $user->address = trim($request->address);

        $user->save();

        return redirect('/profile')
            ->with(
                'success',
                'Profile updated successfully!'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Become Donor Form
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('donor-form');
    }

    /*
    |--------------------------------------------------------------------------
    | Save Donor
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
          // Prevent admins from becoming donors
          if(auth()->check() && auth()->user()->isAdmin())
          {
              return redirect('/admin');
          }

        $request->validate([

            'phone' => 'required|min:10|max:15',

            'blood_group' => 'required',

            'city' => 'required',

            'address' => 'required|min:5',

        ]);

        $user = User::find(auth()->user()->id);

        $user->phone = $request->phone;

        $user->blood_group =
            trim($request->blood_group);

        $user->city =
            trim($request->city);

        $user->address =
            trim($request->address);

        $user->available = 'yes';

        $user->save();

        return redirect('/')
            ->with(
                'success',
                'Donor profile created successfully!'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    */

    public function search(Request $request)
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

        $donors = $query->orderBy('updated_at', 'desc')->paginate(6);

        return view('search', compact('donors'));
    }

    /*
    |--------------------------------------------------------------------------
    | Upload Profile Image
    |--------------------------------------------------------------------------
    */

    public function uploadImage(Request $request)
    {
          // Prevent admins from uploading profile images
          if(auth()->check() && auth()->user()->isAdmin())
          {
              return redirect('/admin');
          }

        $request->validate([

            'profile_image' =>
                'required|image|mimes:jpg,jpeg,png|max:2048'

        ]);

        $user = auth()->user();

        if($request->hasFile('profile_image'))
        {
            $image =
                $request->file('profile_image');

            $imageName =
                time() . '.' .
                $image->getClientOriginalExtension();

            $image->storeAs(
                'profile_images',
                $imageName,
                'public'
            );

            $user->profile_image =
                $imageName;

            $user->save();
        }

        return redirect('/profile')
            ->with(
                'success',
                'Profile image uploaded!'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Toggle Donor Availability
    |--------------------------------------------------------------------------
    */

    public function toggleStatus()
    {
          // Prevent admins from toggling donor status
          if(auth()->check() && auth()->user()->isAdmin())
          {
              return redirect('/admin');
          }

        $user = auth()->user();

        if($user->available == 'yes')
        {
            $user->available = 'no';
        }
        else
        {
            $user->available = 'yes';
        }

        $user->save();

        return redirect('/profile')
            ->with(
                'success',
                'Availability status updated!'
            );
    }

    /**
     * Toggle availability via AJAX (returns JSON)
     */
    public function toggleAvailability(Request $request)
    {
        if(!auth()->check()){
            return response()->json(['success' => false, 'message' => 'Unauthenticated'], 401);
        }

          if(auth()->user()->isAdmin()){
              return response()->json(['success' => false, 'message' => 'Admins cannot change availability'], 403);
          }

        $user = auth()->user();

        try {
            $user->available = $user->available === 'yes' ? 'no' : 'yes';
            $user->save();

            return response()->json([
                'success' => true,
                'available' => $user->available,
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Could not update availability'], 500);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Live Search
    |--------------------------------------------------------------------------
    */

    public function liveSearch(Request $request)
    {
        $query = User::donors()
            ->where('available', 'yes')
            ->select(['name', 'city', 'blood_group', 'available', 'profile_image', 'updated_at'])
            ->orderBy('updated_at', 'desc');

        if ($request->filled('blood_group')) {
            $query->where('blood_group', trim((string) $request->blood_group));
        }

        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . trim((string) $request->city) . '%');
        }

        $donors = $query->get()->map(function ($donor) {
            return [
                'name' => $donor->name,
                'city' => $donor->city,
                'blood_group' => $donor->blood_group,
                'available' => $donor->available,
                'profile_image' => $donor->profile_image,
                'updated_at' => $donor->updated_at,
            ];
        });

        return response()->json($donors);
    }

}