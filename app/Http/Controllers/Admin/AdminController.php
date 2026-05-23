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

    public function manageDonors()
    {
        $donors = User::where('role', 'donor')->latest()->paginate(12);

        return view('admin.manage-donors', compact('donors'));
    }

    public function manageRequesters()
    {
        $requesters = User::where('role', 'requester')->latest()->paginate(12);

        return view('admin.manage-requesters', compact('requesters'));
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
