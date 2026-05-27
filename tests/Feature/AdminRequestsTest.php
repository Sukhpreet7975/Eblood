<?php

use Illuminate\Pagination\LengthAwarePaginator;

test('admin emergency requests page shows requester wording and hides the message until view', function () {
    $request = (object) [
        '_id' => 'req_1',
        'patient_name' => 'John Doe',
        'blood_group' => 'O+',
        'hospital' => 'City Hospital',
        'city' => 'Dhaka',
        'phone' => '01700000000',
        'message' => 'Urgent blood needed for surgery.',
        'status' => 'Pending',
        'created_at' => now(),
        'user' => (object) [
            'email' => 'requester@example.com',
        ],
    ];

    $requests = new LengthAwarePaginator([$request], 1, 12, 1, [
        'path' => route('admin.requests.index'),
    ]);

    $html = view('admin.requests', [
        'requests' => $requests,
        'bloodGroups' => ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'],
        'statusOptions' => ['Pending', 'Approved', 'Completed', 'Rejected'],
        'pendingRequests' => 1,
        'approvedRequests' => 0,
    ])->render();

    expect($html)->toContain('Requesting user: requester@example.com');
    expect($html)->not->toContain('Donor Email');
    expect($html)->not->toContain('Urgent blood needed for surgery.');
    expect($html)->toContain('Message available on View');
    expect($html)->toContain(route('admin.requests.show', 'req_1'));
});
