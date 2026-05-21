<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmergencyRequestMail;

use Illuminate\Http\Request;
use App\Models\BloodRequest;

class RequestController extends Controller
{
    public function create(){
        return view('blood-request');
    }

    public function store(Request $request){
        $request->validate([
            'patient_name' => 'required',
            'blood_group' => 'required',
            'hospital' => 'required',
            'city' => 'required',
            'phone' => 'required',
        ]);

        $data = array_merge($request->all(), ['status' => 'Pending']);

        BloodRequest::create($data);
        Mail::to('admin@eblood.com')
            ->send(new EmergencyRequestMail($request->all()));

        return redirect('/')
            ->with('success', 'Emergency blood request submitted!');
    }
}