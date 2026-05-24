<?php

use Illuminate\Pagination\LengthAwarePaginator;

test('requester requests page renders search and filter controls', function () {
    $request = (object) [
        '_id' => 'req_1',
        'patient_name' => 'Maria Cruz',
        'blood_group' => 'A+',
        'hospital' => 'City Hospital',
        'city' => 'Dhaka',
        'phone' => '01700000001',
        'message' => 'Urgent blood needed for surgery.',
        'status' => 'Pending',
        'admin_message' => null,
        'created_at' => now(),
        'status_updated_at' => null,
    ];

    $requests = new LengthAwarePaginator([$request], 1, 10, 1, [
        'path' => route('requester.requests.index'),
    ]);

    $html = view('my-requests', [
        'requests' => $requests,
    ])->render();

    expect($html)->toContain('name="search"');
    expect($html)->toContain('name="status"');
    expect($html)->toContain('name="blood_group"');
    expect($html)->toContain('Reset');
});
