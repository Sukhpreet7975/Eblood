<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BloodRequest;

use App\Exports\UsersExport;

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

        $totalDonors =
            User::count();

        $availableDonors =
            User::where(
                'available',
                'yes'
            )->count();

        $bloodRequests =
            BloodRequest::count();

        /*
        |--------------------------------------------------------------------------
        | Recent Requests
        |--------------------------------------------------------------------------
        */

        $recentRequests =
            BloodRequest::latest()
                ->take(5)
                ->get();

        /*
        |--------------------------------------------------------------------------
        | Blood Group Analytics
        |--------------------------------------------------------------------------
        */

        $bloodGroupData = [

            User::where(
                'blood_group',
                'A+'
            )->count(),

            User::where(
                'blood_group',
                'A-'
            )->count(),

            User::where(
                'blood_group',
                'B+'
            )->count(),

            User::where(
                'blood_group',
                'B-'
            )->count(),

            User::where(
                'blood_group',
                'O+'
            )->count(),

            User::where(
                'blood_group',
                'O-'
            )->count(),

            User::where(
                'blood_group',
                'AB+'
            )->count(),

            User::where(
                'blood_group',
                'AB-'
            )->count(),

        ];

        /*
        |--------------------------------------------------------------------------
        | City Analytics
        |--------------------------------------------------------------------------
        */

        $cityLabels = User::whereNotNull('city')
            ->pluck('city')
            ->unique()
            ->values();

        $cityData = [];

        foreach($cityLabels as $city)
        {
            $cityData[] = User::where(
                'city',
                $city
            )->count();
        }

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        $query = User::query();

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

                'cityData'

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

        User::find($id)?->delete();

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

        $users = User::all();

        $pdf = Pdf::loadView(
            'admin.users-pdf',
            compact('users')
        );

        return $pdf->download(
            'donors.pdf'
        );
    }
}