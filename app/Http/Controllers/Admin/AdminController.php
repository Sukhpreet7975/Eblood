<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Models\BloodRequest;
use App\Models\User;
use App\Services\AnalyticsService;
use App\Services\RequestService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use MongoDB\BSON\Regex;

class AdminController extends Controller
{
    public function __construct(
        protected AnalyticsService $analyticsService,
        protected RequestService $requestService,
    ) {
        $this->middleware(['auth', 'admin']);
    }

    public function dashboard()
    {
        return view('admin.dashboard', $this->analyticsService->getAdminDashboardData());
    }

    public function home()
    {
        return view('admin.home', $this->analyticsService->getAdminHomeData());
    }

    public function analytics()
    {
        return view('admin.analytics', $this->analyticsService->getAdminDashboardData());
    }

    public function notifications()
    {
        $service = new \App\Services\NotificationService();
        $notifications = $service->roleNotifications('admin');

        return view('admin.notifications', compact('notifications'));
    }

    public function manageDonors(Request $request)
    {
        $search = trim((string) $request->input('search', ''));
        $perPage = (int) $request->input('per_page', 12);
        $perPage = in_array($perPage, [12, 25, 50, 100], true) ? $perPage : 12;
        $filter = $request->input('filter', 'all');

        $query = User::donors();

        if ($filter === 'available') {
            $query->where('available', 'yes');
        } elseif ($filter === 'unavailable') {
            $query->where('available', '!=', 'yes');
        }

        if ($search !== '') {
            $query->where(function ($subQuery) use ($search) {
                $regex = new Regex(preg_quote($search), 'i');
                $subQuery->where('name', 'regex', $regex)
                    ->orWhere('email', 'regex', $regex)
                    ->orWhere('city', 'regex', $regex);
            });
        }

        $donors = $query->latest()->paginate($perPage)->withQueryString();

        return view('admin.manage-donors', compact('donors', 'search', 'perPage', 'filter'));
    }

    public function manageRequesters(Request $request)
    {
        $search = trim((string) $request->input('search', ''));
        $perPage = (int) $request->input('per_page', 25);
        $perPage = in_array($perPage, [12, 25, 50, 100], true) ? $perPage : 25;

        $query = User::requesters();

        if ($search !== '') {
            $query->where(function ($subQuery) use ($search) {
                $regex = new Regex(preg_quote($search), 'i');
                $subQuery->where('name', 'regex', $regex)
                    ->orWhere('email', 'regex', $regex)
                    ->orWhere('city', 'regex', $regex);
            });
        }

        $requesters = $query->latest()->paginate($perPage)->withQueryString();

        return view('admin.manage-requesters', compact('requesters', 'search', 'perPage'));
    }

    public function requests(Request $request)
    {
        $statusOptions = ['Pending', 'Approved', 'Completed', 'Rejected'];
        $bloodGroups = ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'];

        $query = $this->requestService->buildRequestQuery($request);
        $requests = $query->orderByDesc('_id')
            ->paginate(12)
            ->withQueryString();

        return view('admin.requests', compact('requests', 'statusOptions', 'bloodGroups'));
    }

    public function showRequest($id)
    {
        $request = $this->requestService->getRequestDetail($id);

        if (! $request) {
            return redirect(route('admin.requests.index'))->with('error', 'Request not found.');
        }

        $statusOptions = ['Pending', 'Approved', 'Completed', 'Rejected'];

        return view('admin.request-detail', compact('request', 'statusOptions'));
    }

    public function updateRequestStatus(Request $request, $id)
    {
        $requestData = $request->validate([
            'status' => 'required|in:Pending,Approved,Completed,Rejected',
            'admin_message' => 'nullable|string|max:1000',
        ]);

        if ($requestData['status'] === 'Rejected' && ! trim($requestData['admin_message'])) {
            return back()->withErrors(['admin_message' => 'Rejection reason is required.'])->withInput();
        }

        $bloodRequest = BloodRequest::find($id);

        if (! $bloodRequest) {
            return redirect(route('admin.requests.index'))->with('error', 'Request not found.');
        }

        $adminMessage = trim($requestData['admin_message']);

        if (! $adminMessage && $requestData['status'] === 'Approved') {
            $adminMessage = 'Your emergency blood request has been approved successfully.';
        }

        if (! $adminMessage && $requestData['status'] === 'Rejected') {
            $adminMessage = 'Your request was rejected by the admin.';
        }

        $bloodRequest->update([
            'status' => $requestData['status'],
            'admin_message' => $adminMessage,
            'status_updated_at' => Carbon::now(),
        ]);

        return redirect(route('admin.requests.show', $bloodRequest->_id))->with('success', 'Request status updated successfully.');
    }

    public function deleteUser($id)
    {
        $user = User::find($id);

        if (! $user) {
            return redirect('/admin')->with('error', 'User not found.');
        }

        if ($user->role === 'admin') {
            return redirect('/admin')->with('error', 'Admin users cannot be deleted.');
        }

        $user->delete();

        return redirect('/admin')->with('success', 'User deleted successfully!');
    }

    public function manageUsers(Request $request)
    {
        $search = trim((string) $request->input('search', ''));
        $perPage = (int) $request->input('per_page', 25);
        $perPage = in_array($perPage, [12, 25, 50, 100], true) ? $perPage : 25;
        $filter = $request->input('filter', 'all'); // all | donors | non-donors

        $query = User::where(function ($q) {
            $q->where('role', '!=', 'admin')->orWhereNull('role');
        });

        if ($filter === 'donors') {
            $query->where(function ($q) {
                $q->where('is_donor', true)->orWhere('role', 'donor');
            });
        } elseif ($filter === 'non-donors') {
            $query->where(function ($q) {
                $q->where(function ($q2) {
                    $q2->where('role', 'user')->orWhereNull('role');
                })->where(function ($q3) {
                    $q3->where('is_donor', '!=', true)->orWhereNull('is_donor');
                });
            });
        }

        if ($search !== '') {
            $query->where(function ($subQuery) use ($search) {
                $regex = new \MongoDB\BSON\Regex(preg_quote($search), 'i');
                $subQuery->where('name', 'regex', $regex)
                    ->orWhere('email', 'regex', $regex)
                    ->orWhere('city', 'regex', $regex);
            });
        }

        $users = $query->latest()->paginate($perPage)->withQueryString();

        return view('admin.manage-users', compact('users', 'search', 'perPage', 'filter'));
    }

    public function suspendUser($id)
    {
        $user = User::find($id);

        if (! $user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        if ($user->role === 'admin') {
            return redirect()->back()->with('error', 'Cannot suspend an admin.');
        }

        $user->suspended = ! ($user->suspended ?? false);
        $user->save();

        return redirect()->back()->with('success', 'User suspension toggled.');
    }

    public function toggleDonorMode($id)
    {
        $user = User::find($id);

        if (! $user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        $user->is_donor = ! ($user->is_donor ?? false);
        $user->save();

        return redirect()->back()->with('success', 'Donor mode updated.');
    }

    public function exportExcel()
    {
        return Excel::download(new UsersExport, 'donors.xlsx');
    }

    public function exportPdf()
    {
        $users = User::donors()->get();
        $pdf = Pdf::loadView('admin.users-pdf', compact('users'));

        return $pdf->download('donors.pdf');
    }
}
