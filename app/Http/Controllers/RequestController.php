<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmergencyRequestMail;

use Illuminate\Http\Request;
use App\Models\BloodRequest;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\RedirectResponse;

class RequestController extends Controller
{
    public function create()
    {
        if (! Auth::check()) {
            return redirect('/login');
        }

        if (! Auth::user()->isRequester()) {
            return redirect(Auth::user()->isAdmin() ? route('admin.home') : route('donor.home'))
                ->with('error', 'Only requesters can create emergency requests.');
        }

        return view('blood-request');
    }

    public function store(Request $request): RedirectResponse
    {
        if (! Auth::check()) {
            return redirect('/login');
        }

        if (! Auth::user()->isRequester()) {
            return redirect(Auth::user()->isAdmin() ? route('admin.home') : route('donor.home'))
                ->with('error', 'Only requesters can submit emergency requests.');
        }

        $request->validate([
            'patient_name' => 'required',
            'blood_group' => 'required',
            'hospital' => 'required',
            'city' => 'required',
            'phone' => 'required',
        ]);
        $data = array_merge($request->all(), [
            'status' => 'Pending',
            'user_id' => Auth::id(),
        ]);

        BloodRequest::create($data);
        Mail::to('admin@eblood.com')
            ->send(new EmergencyRequestMail($request->all()));

        return redirect('/my-requests')
            ->with('success', 'Emergency blood request submitted!');
    }

    /**
     * Show current user's requests
     */
    public function myRequests()
    {
        if (! Auth::check()) {
            return redirect('/login');
        }

        if (! Auth::user()->isRequester()) {
            return redirect(Auth::user()->isAdmin() ? route('admin.home') : route('donor.home'))
                ->with('error', 'Only requesters can view their requests.');
        }

        $requests = BloodRequest::where('user_id', Auth::id())->latest()->paginate(10);

        return view('my-requests', compact('requests'));
    }

    /**
     * Show requester dashboard
     */
    public function requesterHome()
    {
        if (! Auth::check()) {
            return redirect('/login');
        }

        if (! Auth::user()->isRequester()) {
            return redirect(Auth::user()->isAdmin() ? route('admin.home') : route('donor.home'))
                ->with('error', 'Only requesters can access the requester dashboard.');
        }

        $user = Auth::user();
        $totalRequests = BloodRequest::where('user_id', $user->id)->count();
        $pendingRequests = BloodRequest::where('user_id', $user->id)->where('status', 'Pending')->count();
        $approvedRequests = BloodRequest::where('user_id', $user->id)->where('status', 'Approved')->count();
        $completedRequests = BloodRequest::where('user_id', $user->id)->where('status', 'Completed')->count();
        $rejectedRequests = BloodRequest::where('user_id', $user->id)->where('status', 'Rejected')->count();
        $recentRequests = BloodRequest::where('user_id', $user->id)->latest()->take(5)->get();

        return view('requester.home', compact(
            'user',
            'totalRequests',
            'pendingRequests',
            'approvedRequests',
            'completedRequests',
            'rejectedRequests',
            'recentRequests'
        ));
    }

    /**
     * Show request details (owner or admin)
     */
    public function show($id)
    {
        $req = BloodRequest::find($id);

        if (! $req) {
            return redirect(route('requester.home'))->with('error', 'Request not found');
        }

        if (! Auth::user()->isAdmin() && $req->user_id !== Auth::id()) {
            return redirect(route('requester.home'))->with('error', 'You do not have permission to view this request');
        }

        return view('request-detail', compact('req'));
    }

    /**
     * Cancel a user's request (owner only)
     */
    public function cancel($id)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $req = BloodRequest::find($id);

        if (! $req) {
            return redirect(route('requester.home'))->with('error', 'Request not found');
        }

        if ($req->user_id !== Auth::id()) {
            return redirect(route('requester.home'))->with('error', 'You cannot cancel this request');
        }

        $req->delete();

        return redirect(route('requester.home'))->with('success', 'Request canceled');
    }
}