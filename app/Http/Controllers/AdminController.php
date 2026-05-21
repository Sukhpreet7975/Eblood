<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BloodRequest;

use App\Exports\UsersExport;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;

use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Admin Dashboard
    |--------------------------------------------------------------------------
    */

    public function dashboard()
    {
        /*
        |--------------------------------------------------------------------------
        | Admin Protection
        |--------------------------------------------------------------------------
        */

        if(!auth()->user()->is_admin)
        {
            return redirect('/');
        }

        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        $donorQuery = User::where(
            'is_admin',
            '!=',
            true
        );

        $totalDonors =
            $donorQuery->count();

        $availableDonors =
            User::where(
                'is_admin',
                '!=',
                true
            )
            ->where(
                'available',
                'yes'
            )
            ->count();

        $bloodRequests =
            BloodRequest::count();

        // Total requests count (can be filtered later)
        $totalRequests = BloodRequest::count();

        /*
        |--------------------------------------------------------------------------
        | Recent Requests
        |--------------------------------------------------------------------------
        */

        $recentRequests =
            BloodRequest::latest()
                ->take(5)
                ->get();

        // Requests table with optional status filter
        $requestQuery = BloodRequest::query();

        if (request('status')) {
            $requestQuery->where('status', request('status'));
        }

        $requests = $requestQuery->latest()->paginate(10);

        // Recent donor registrations
        $recentDonors = User::where('is_admin', '!=', true)
            ->latest()
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Blood Group Analytics
        |--------------------------------------------------------------------------
        */

        $bloodGroupData = [

            User::where(
                'is_admin',
                '!=',
                true
            )->where(
                'blood_group',
                'A+'
            )->count(),

            User::where(
                'is_admin',
                '!=',
                true
            )->where(
                'blood_group',
                'A-'
            )->count(),

            User::where(
                'is_admin',
                '!=',
                true
            )->where(
                'blood_group',
                'B+'
            )->count(),

            User::where(
                'is_admin',
                '!=',
                true
            )->where(
                'blood_group',
                'B-'
            )->count(),

            User::where(
                'is_admin',
                '!=',
                true
            )->where(
                'blood_group',
                'O+'
            )->count(),

            User::where(
                'is_admin',
                '!=',
                true
            )->where(
                'blood_group',
                'O-'
            )->count(),

            User::where(
                'is_admin',
                '!=',
                true
            )->where(
                'blood_group',
                'AB+'
            )->count(),

            User::where(
                'is_admin',
                '!=',
                true
            )->where(
                'blood_group',
                'AB-'
            )->count(),

        ];

        /*
        |--------------------------------------------------------------------------
        | City Analytics
        |--------------------------------------------------------------------------
        */

        $cityLabels = User::where(
                'is_admin',
                '!=',
                true
            )
            ->whereNotNull('city')
            ->pluck('city')
            ->unique()
            ->values();

        $cityData = [];

        foreach($cityLabels as $city)
        {
            $cityData[] = User::where(
                'is_admin',
                '!=',
                true
            )->where(
                'city',
                $city
            )->count();
        }

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        $query = User::where(
            'is_admin',
            '!=',
            true
        );

        if(request('search'))
        {
            $search =
                trim(request('search'));

            $query->where(function($q) use ($search) {

                $q->where(
                    'name',
                    'like',
                    '%' . $search . '%'
                )

                ->orWhere(
                    'city',
                    'like',
                    '%' . $search . '%'
                )

                ->orWhere(
                    'blood_group',
                    'like',
                    '%' . $search . '%'
                );

            });
        }

        $users =
            $query->paginate(10);

        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.dashboard',

            compact(

                'totalDonors',

                'availableDonors',

                'bloodRequests',

                'users',

                'recentRequests',

                'bloodGroupData',

                'cityLabels',

                'cityData',

                'recentDonors',

                'totalRequests',
                'requests'

            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Delete User
    |--------------------------------------------------------------------------
    */

    public function deleteUser($id)
    {
        if(!auth()->user()->is_admin)
        {
            return redirect('/');
        }

        $user = User::find($id);

        if (!$user) {
            return redirect('/admin')->with('error', 'User not found.');
        }

        if ($user->is_admin) {
            return redirect('/admin')->with('error', 'Admin users cannot be deleted.');
        }

        $user->delete();

        return redirect('/admin')
            ->with(
                'success',
                'User deleted successfully!'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Export Excel
    |--------------------------------------------------------------------------
    */

    public function exportExcel()
    {
        if(!auth()->user()->is_admin)
        {
            return redirect('/');
        }

        return Excel::download(
            new UsersExport,
            'donors.xlsx'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Export PDF
    |--------------------------------------------------------------------------
    */

    public function exportPdf()
    {
        if(!auth()->user()->is_admin)
        {
            return redirect('/');
        }

        $users = User::where(
                'is_admin',
                '!=',
                true
            )
            ->get();

        $pdf = Pdf::loadView(
            'admin.users-pdf',
            compact('users')
        );

        return $pdf->download(
            'donors.pdf'
        );
    }

    /**
     * Update the status of a blood request
     */
    public function updateRequestStatus($id, Request $request)
    {
        if(!auth()->user()->is_admin)
        {
            return redirect('/');
        }

        $status = $request->input('status');

        if (!in_array($status, ['Pending','Approved','Completed','Rejected'])) {
            return redirect('/admin')->with('error', 'Invalid status');
        }

        $req = BloodRequest::find($id);

        if (!$req) {
            return redirect('/admin')->with('error', 'Request not found');
        }

        $req->status = $status;
        $req->save();

        return redirect('/admin')->with('success', 'Request status updated');
    }
}