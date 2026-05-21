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
    public function create(){
        // Prevent guests (routes moved to auth) and admins from creating requests
        if (!Auth::check()) {
            return redirect('/login');
        }

        if (Auth::user()->is_admin) {
            return redirect('/')->with('error', 'Admins cannot create emergency requests.');
        }

        return view('blood-request');
    }

    public function store(Request $request): RedirectResponse
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        if (Auth::user()->is_admin) {
            return redirect('/')->with('error', 'Admins cannot create emergency requests.');
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
        if (!Auth::check()) {
            return redirect('/login');
        }

        $requests = BloodRequest::where('user_id', Auth::id())->latest()->paginate(10);

        return view('my-requests', compact('requests'));
    }

    /**
     * Show request details (owner or admin)
     */
    public function show($id)
    {
        $req = BloodRequest::find($id);

        if (!$req) {
            return redirect('/')->with('error', 'Request not found');
        }

        if (!Auth::user()->is_admin && $req->user_id !== Auth::id()) {
            return redirect('/')->with('error', 'You do not have permission to view this request');
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

        if (!$req) {
            return redirect('/my-requests')->with('error', 'Request not found');
        }

        if ($req->user_id !== Auth::id()) {
            return redirect('/my-requests')->with('error', 'You cannot cancel this request');
        }

        $req->delete();

        return redirect('/my-requests')->with('success', 'Request canceled');
    }
}