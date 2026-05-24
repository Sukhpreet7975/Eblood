<?php

use Illuminate\Support\Collection;

test('requester home renders a responsive recent requests header and list wrapper', function () {
    $user = (object) [
        'name' => 'Ava Brown',
        'profile_image' => null,
    ];

    $request = (object) [
        'patient_name' => 'Mia Turner',
        'blood_group' => 'O+',
        'hospital' => 'City Hospital',
        'city' => 'Dhaka',
        'status' => 'Pending',
        'admin_message' => null,
        'created_at' => now()->subHours(2),
    ];

    $html = view('requester.home', [
        'user' => $user,
        'totalRequests' => 1,
        'pendingRequests' => 1,
        'approvedRequests' => 0,
        'completedRequests' => 0,
        'rejectedRequests' => 0,
        'recentRequests' => new Collection([$request]),
        'requesterPriorityData' => [],
    ])->render();

    expect($html)->toContain('recent-requests-header');
    expect($html)->toContain('recent-requests-list');
    expect($html)->toContain('sm:flex-row');
});
