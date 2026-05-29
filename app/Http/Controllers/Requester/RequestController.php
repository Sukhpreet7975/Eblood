<?php

namespace App\Http\Controllers\Requester;

use App\Http\Controllers\Controller;
use App\Models\BloodRequest;
use App\Services\RequestService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    public function __construct(protected RequestService $requestService)
    {
    }

    public function create()
    {
        $user = Auth::user();

        if (! $user) {
            return redirect('/login');
        }

        if ($user->isAdmin()) {
            return redirect()->route('admin.home')
                ->with('error', 'Admins do not create emergency requests from this view.');
        }

        return view('blood-request');
    }

    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if (! $user) {
            return redirect('/login');
        }

        if ($user->isAdmin()) {
            return redirect()->route('admin.home')
                ->with('error', 'Admins cannot submit emergency requests.');
        }

        $request->validate([
            'patient_name' => 'required',
            'blood_group' => 'required',
            'hospital' => 'required',
            'city' => 'required',
            'phone' => 'required',
        ]);

        $this->requestService->createEmergencyRequest(array_merge($request->all(), [
            'user_id' => $user->id,
        ]));

        return redirect()->route('requests.index')->with('success', 'Emergency blood request submitted!');
    }

    public function myRequests(Request $request)
    {
        $user = Auth::user();

        if (! $user) {
            return redirect('/login');
        }

        if ($user->isAdmin()) {
            return redirect()->route('admin.home')
                ->with('error', 'Admins do not manage personal request lists.');
        }

        $requests = $this->requestService->getRequesterRequests($user, $request);

        return view('my-requests', compact('requests'));
    }

    public function dashboard(Request $request)
    {
        $user = Auth::user();

        if (! $user) {
            return redirect('/login');
        }

        if ($user->isAdmin()) {
            return redirect()->route('admin.home');
        }

        $requests = BloodRequest::where('user_id', $user->id)
            ->latest()
            ->paginate(5);

        $recentActivity = BloodRequest::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', [
            'user' => $user,
            'requests' => $requests,
            'recentActivity' => $recentActivity,
            'totalRequests' => $requests->total(),
            'approvedRequests' => BloodRequest::where('user_id', $user->id)->where('status', 'Approved')->count(),
            'completedRequests' => BloodRequest::where('user_id', $user->id)->where('status', 'Completed')->count(),
        ]);
    }

    public function requesterHome(Request $request)
    {
        $user = Auth::user();

        if (! $user) {
            return redirect('/login');
        }

        if ($user->isAdmin()) {
            return redirect()->route('admin.home');
        }

        $data = $this->requestService->getRequesterHomeData($user, $request->status);
        $data['activeFilterStatus'] = $request->status ?? 'Pending';

        return view('requester.home', $data);
    }

    public function show($id)
    {
        $req = $this->requestService->getRequestDetail($id);

        if (! $req) {
            return redirect()->route('dashboard')->with('error', 'Request not found');
        }

        if (! Auth::user()?->isAdmin() && $req->user_id !== Auth::id()) {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to view this request');
        }

        return view('request-detail', compact('req'));
    }

    public function cancel($id)
    {
        $user = Auth::user();

        if (! $user) {
            return redirect('/login');
        }

        $req = $this->requestService->getRequestDetail($id);

        if (! $req) {
            return redirect()->route('dashboard')->with('error', 'Request not found');
        }

        if ($req->user_id !== $user->id) {
            return redirect()->route('dashboard')->with('error', 'You cannot cancel this request');
        }

        $this->requestService->cancelRequest($req, $user);

        return redirect()->route('dashboard')->with('success', 'Request canceled');
    }
}
