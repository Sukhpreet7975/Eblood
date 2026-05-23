<?php

namespace App\Http\Controllers\Donor;

use App\Http\Controllers\Controller;
use App\Models\BloodRequest;
use App\Models\User;
use App\Services\DonorRecommendationService;
use Illuminate\Http\Request;

class DonorController extends Controller
{
    public function __construct(protected DonorRecommendationService $donorRecommendationService)
    {
        $this->middleware(['auth', 'donor'])->except(['home', 'search', 'liveSearch']);
    }

    public function home()
    {
        $donors = User::donors()->where('available', 'yes')->paginate(6);

        return view('home', compact('donors'));
    }

    public function donorHome()
    {
        $user = auth()->user();

        if (! $user) {
            return redirect('/login');
        }

        if ($user->role === 'admin') {
            return redirect('/admin');
        }

        return view('donor.home', $this->donorRecommendationService->getDonorHomeData($user));
    }

    public function profile()
    {
        $user = auth()->user();

        if ($user && $user->role === 'admin') {
            return redirect('/admin');
        }

        return view('profile', compact('user'));
    }

    public function edit()
    {
        $user = auth()->user();

        if ($user && $user->role === 'admin') {
            return redirect('/admin');
        }

        return view('edit-profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        if ($user && $user->role === 'admin') {
            return redirect('/admin');
        }

        $request->validate([
            'phone' => 'required|min:10|max:15',
            'blood_group' => 'required',
            'city' => 'required',
            'address' => 'required|min:5',
        ]);

        $user->phone = $request->phone;
        $user->blood_group = trim($request->blood_group);
        $user->city = trim($request->city);
        $user->address = trim($request->address);
        $user->save();

        return redirect('/profile')->with('success', 'Profile updated successfully!');
    }

    public function create()
    {
        return view('donor-form');
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if ($user && $user->role === 'admin') {
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
        $user->blood_group = trim($request->blood_group);
        $user->city = trim($request->city);
        $user->address = trim($request->address);
        $user->available = 'yes';
        $user->save();

        return redirect('/')->with('success', 'Donor profile created successfully!');
    }

    public function search(Request $request)
    {
        $donors = $this->donorRecommendationService->getDonorSearchResults($request);

        return view('search', compact('donors'));
    }

    public function uploadImage(Request $request)
    {
        $user = auth()->user();

        if ($user && $user->role === 'admin') {
            return redirect('/admin');
        }

        $request->validate([
            'profile_image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('profile_images', $imageName, 'public');
            $user->profile_image = $imageName;
            $user->save();
        }

        return redirect('/profile')->with('success', 'Profile image uploaded!');
    }

    public function toggleStatus()
    {
        $user = auth()->user();

        if ($user && $user->role === 'admin') {
            return redirect('/admin');
        }

        $user->available = $user->available === 'yes' ? 'no' : 'yes';
        $user->save();

        return redirect('/profile')->with('success', 'Availability status updated!');
    }

    public function toggleAvailability(Request $request)
    {
        if (! auth()->check()) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated'], 401);
        }

        if (auth()->user()->role === 'admin') {
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

    public function liveSearch(Request $request)
    {
        return response()->json($this->donorRecommendationService->getLiveSearchResults($request));
    }
}
