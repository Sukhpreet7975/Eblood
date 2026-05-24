<?php

namespace App\Http\Controllers\Requester;

use App\Http\Controllers\Controller;
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
        if (! Auth::check()) {
            return redirect('/login');
        }

        if (Auth::user()->role !== 'requester') {
            return redirect(Auth::user()->role === 'admin' ? route('admin.home') : route('donor.home'))
                ->with('error', 'Only requesters can create emergency requests.');
        }

        return view('blood-request');
    }

    public function store(Request $request): RedirectResponse
    {
        if (! Auth::check()) {
            return redirect('/login');
        }

        if (Auth::user()->role !== 'requester') {
            return redirect(Auth::user()->role === 'admin' ? route('admin.home') : route('donor.home'))
                ->with('error', 'Only requesters can submit emergency requests.');
        }

        $request->validate([
            'patient_name' => 'required',
            'blood_group' => 'required',
            'hospital' => 'required',
            'city' => 'required',
            'phone' => 'required',
        ]);

        $this->requestService->createEmergencyRequest(array_merge($request->all(), [
            'user_id' => Auth::id(),
        ]));

        return redirect('/my-requests')->with('success', 'Emergency blood request submitted!');
    }

    public function myRequests(Request $request)
    {
        if (! Auth::check()) {
            return redirect('/login');
        }

        if (Auth::user()->role !== 'requester') {
            return redirect(Auth::user()->role === 'admin' ? route('admin.home') : route('donor.home'))
                ->with('error', 'Only requesters can view their requests.');
        }

        $requests = $this->requestService->getRequesterRequests(Auth::user(), $request);

        return view('my-requests', compact('requests'));
    }

    public function requesterHome()
    {
        if (! Auth::check()) {
            return redirect('/login');
        }

        if (Auth::user()->role !== 'requester') {
            return redirect(Auth::user()->role === 'admin' ? route('admin.home') : route('donor.home'))
                ->with('error', 'Only requesters can access the requester dashboard.');
        }

        return view('requester.home', $this->requestService->getRequesterHomeData(Auth::user()));
    }

    public function show($id)
    {
        $req = $this->requestService->getRequestDetail($id);

        if (! $req) {
            return redirect(route('requester.home'))->with('error', 'Request not found');
        }

        if (Auth::user()->role !== 'admin' && $req->user_id !== Auth::id()) {
            return redirect(route('requester.home'))->with('error', 'You do not have permission to view this request');
        }

        return view('request-detail', compact('req'));
    }

    public function cancel($id)
    {
        if (! Auth::check()) {
            return redirect('/login');
        }

        $req = $this->requestService->getRequestDetail($id);

        if (! $req) {
            return redirect(route('requester.home'))->with('error', 'Request not found');
        }

        if ($req->user_id !== Auth::id()) {
            return redirect(route('requester.home'))->with('error', 'You cannot cancel this request');
        }

        $this->requestService->cancelRequest($req, Auth::user());

        return redirect(route('requester.home'))->with('success', 'Request canceled');
    }
}
