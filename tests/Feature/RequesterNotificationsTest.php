<?php

use Illuminate\Pagination\LengthAwarePaginator;

test('requester notifications seed includes completed request updates', function () {
    $completedRequest = (object) [
        '_id' => 'req_completed',
        'patient_name' => 'Amina Khan',
        'blood_group' => 'O+',
        'hospital' => 'City Hospital',
        'city' => 'Dhaka',
        'phone' => '01700000003',
        'message' => 'Blood needed for emergency surgery.',
        'status' => 'Completed',
        'admin_message' => 'Request fulfilled successfully.',
        'created_at' => now(),
        'status_updated_at' => now(),
    ];

    $requests = new LengthAwarePaginator([$completedRequest], 1, 10, 1, [
        'path' => route('requester.requests.index'),
    ]);

    $html = view('my-requests', [
        'requests' => $requests,
    ])->render();

    expect($html)->toContain('title: \'Request completed\'');
    expect($html)->toContain('Your completed requests are now marked as fulfilled and ready for review.');
});
