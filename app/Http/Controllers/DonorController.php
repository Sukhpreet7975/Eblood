<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DonorController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Home Page
    |--------------------------------------------------------------------------
    */

    public function home()
    {
        $donors = User::where('available', 'yes')
            ->paginate(6);

        return view('home', compact('donors'));
    }

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    public function dashboard()
    {
        // Prevent admins from accessing user dashboard
        if(auth()->check() && auth()->user()->is_admin)
        {
            return redirect('/admin');
        }
        return view('dashboard');
    }

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    public function profile()
    {
        // Prevent admins from accessing user profile
        if(auth()->check() && auth()->user()->is_admin)
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
        if(auth()->check() && auth()->user()->is_admin)
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
        if(auth()->check() && auth()->user()->is_admin)
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
        if(auth()->check() && auth()->user()->is_admin)
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
        $query = User::where(
            'available',
            'yes'
        );

        if($request->blood_group)
        {
            $query->where(
                'blood_group',
                trim($request->blood_group)
            );
        }

        if($request->city)
        {
            $query->where(
                'city',
                'like',
                '%' . trim($request->city) . '%'
            );
        }

        $donors = $query->paginate(6);

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
        if(auth()->check() && auth()->user()->is_admin)
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
        if(auth()->check() && auth()->user()->is_admin)
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

    /*
    |--------------------------------------------------------------------------
    | Live Search
    |--------------------------------------------------------------------------
    */

    public function liveSearch(Request $request)
    {
        $query = User::where(
            'available',
            'yes'
        );

        if($request->blood_group)
        {
            $query->where(
                'blood_group',
                trim($request->blood_group)
            );
        }

        if($request->city)
        {
            $query->where(
                'city',
                'like',
                '%' . trim($request->city) . '%'
            );
        }

        $donors = $query->get();

        return response()->json($donors);
    }

}