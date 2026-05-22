<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BloodRequest;

use App\Exports\UsersExport;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use Maatwebsite\Excel\Facades\Excel;

use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /*
    |--------------------------------------------------------------------------
    | Admin Dashboard
    |--------------------------------------------------------------------------
    */

    public function dashboard()
    {
        if(!auth()->user()->isAdmin())
        {
            return redirect('/');
        }

        $totalDonors = User::donors()->count();

        $availableDonors = User::donors()
            ->where('available', 'yes')
            ->count();

        $bloodRequests = BloodRequest::count();

        $pendingRequests = BloodRequest::where('status', 'Pending')->count();
        $approvedRequests = BloodRequest::where('status', 'Approved')->count();
        $completedRequests = BloodRequest::where('status', 'Completed')->count();
        $rejectedRequests = BloodRequest::where('status', 'Rejected')->count();

        $recentDonors = User::donors()
            ->latest()
            ->take(5)
            ->get();

        // Prepare chart data: blood group distribution and top cities
        $bloodGroups = ['A+','A-','B+','B-','O+','O-','AB+','AB-'];
        $donorList = User::donors()->get(['blood_group', 'city']);

        $bloodGroupCounts = array_fill(0, count($bloodGroups), 0);
        foreach ($donorList as $donor) {
            $bg = $donor->blood_group ?? null;
            $idx = array_search($bg, $bloodGroups, true);
            if ($idx !== false) {
                $bloodGroupCounts[$idx]++;
            }
        }

        // City counts (top 8)
        $cityCounts = [];
        foreach ($donorList as $donor) {
            $city = $donor->city ?? 'Unknown';
            if (!isset($cityCounts[$city])) $cityCounts[$city] = 0;
            $cityCounts[$city]++;
        }
        arsort($cityCounts);
        $cityLabels = array_slice(array_keys($cityCounts), 0, 8);
        $cityData = array_values(array_slice($cityCounts, 0, 8));

        return view('admin.dashboard', [
            'totalDonors' => $totalDonors,
            'availableDonors' => $availableDonors,
            'bloodRequests' => $bloodRequests,
            'recentDonors' => $recentDonors,
            'pendingRequests' => $pendingRequests,
            'approvedRequests' => $approvedRequests,
            'completedRequests' => $completedRequests,
            'rejectedRequests' => $rejectedRequests,
            'bloodGroupData' => $bloodGroupCounts,
            'cityLabels' => $cityLabels,
            'cityData' => $cityData,
        ]);
    }

    /**
     * Admin Home Overview
     */
    public function home()
    {
        if(!auth()->user()->isAdmin())
        {
            return redirect('/');
        }

        $admin = auth()->user();

        $totalDonors = User::donors()->count();
        $availableDonors = User::donors()
            ->where('available', 'yes')
            ->count();

        $totalRequests = BloodRequest::count();
        $pendingRequests = BloodRequest::where('status', 'Pending')->count();

        $latestDonors = User::donors()
            ->latest()
            ->take(5)
            ->get();

        $latestRequests = BloodRequest::latest()
            ->take(5)
            ->get();

        $recentActivities = BloodRequest::latest()
            ->take(5)
            ->get();

        return view('admin.home', compact(
            'admin',
            'totalDonors',
            'availableDonors',
            'totalRequests',
            'pendingRequests',
            'latestDonors',
            'latestRequests',
            'recentActivities'
        ));
    }

    /**
     * Build request query with search and filter support.
     */
    protected function buildRequestQuery($request)
    {
        $query = BloodRequest::with('user');

        if ($request->filled('patient_name')) {
            $regex = new \MongoDB\BSON\Regex(preg_quote($request->patient_name), 'i');
            $query->where('patient_name', 'regex', $regex);
        }

        if ($request->filled('donor_email')) {
            $regex = new \MongoDB\BSON\Regex(preg_quote($request->donor_email), 'i');
            $donorIds = User::where('email', 'regex', $regex)
                ->pluck('_id')
                ->toArray();

            if (!empty($donorIds)) {
                $query->whereIn('user_id', $donorIds);
            } else {
                $query->where('user_id', null);
            }
        }

        if ($request->filled('blood_group')) {
            $query->where('blood_group', $request->blood_group);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return $query;
    }

    /**
     * Admin request management list.
     */
    public function requests(Request $request)
    {
        if(!auth()->user()->isAdmin())
        {
            return redirect('/');
        }

        $statusOptions = ['Pending', 'Approved', 'Completed', 'Rejected'];
        $bloodGroups = ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'];

        $query = $this->buildRequestQuery($request);

        $requests = $query->orderByDesc('_id')
            ->paginate(12)
            ->withQueryString();

        return view('admin.requests', compact(
            'requests',
            'statusOptions',
            'bloodGroups'
        ));
    }

    /**
     * Admin request detail page.
     */
    public function showRequest($id)
    {
        if(!auth()->user()->isAdmin())
        {
            return redirect('/');
        }

        $request = BloodRequest::with('user')->find($id);

        if (!$request) {
            return redirect(route('admin.requests.index'))->with('error', 'Request not found.');
        }

        $statusOptions = ['Pending', 'Approved', 'Completed', 'Rejected'];

        return view('admin.request-detail', compact('request', 'statusOptions'));
    }

    /**
     * Update request status from admin.
     */
    public function updateRequestStatus(Request $request, $id)
    {
        if(!auth()->user()->isAdmin())
        {
            return redirect('/');
        }

        $requestData = $request->validate([
            'status' => 'required|in:Pending,Approved,Completed,Rejected',
            'admin_message' => 'nullable|string|max:1000',
        ]);

        if ($requestData['status'] === 'Rejected' && !trim($requestData['admin_message'])) {
            return back()->withErrors(['admin_message' => 'Rejection reason is required.'])->withInput();
        }

        $bloodRequest = BloodRequest::find($id);

        if (!$bloodRequest) {
            return redirect(route('admin.requests.index'))->with('error', 'Request not found.');
        }

        $adminMessage = trim($requestData['admin_message']);

        if (!$adminMessage && $requestData['status'] === 'Approved') {
            $adminMessage = 'Your emergency blood request has been approved successfully.';
        }

        if (!$adminMessage && $requestData['status'] === 'Rejected') {
            $adminMessage = 'Your request was rejected by the admin.';
        }

        $bloodRequest->update([
            'status' => $requestData['status'],
            'admin_message' => $adminMessage,
            'status_updated_at' => Carbon::now(),
        ]);

        return redirect(route('admin.requests.show', $bloodRequest->_id))
            ->with('success', 'Request status updated successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | Delete User
    |--------------------------------------------------------------------------
    */

    public function deleteUser($id)
    {
        if(!auth()->user()->isAdmin())
        {
            return redirect('/');
        }

        $user = User::find($id);

        if (!$user) {
            return redirect('/admin')->with('error', 'User not found.');
        }

        if ($user->isAdmin()) {
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
        if(!auth()->user()->isAdmin())
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
        if(!auth()->user()->isAdmin())
        {
            return redirect('/');
        }

        $users = User::donors()
            ->get();

        $pdf = Pdf::loadView(
            'admin.users-pdf',
            compact('users')
        );

        return $pdf->download(
            'donors.pdf'
        );
    }

}