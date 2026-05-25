<?php

use App\Http\Controllers\Requester\RequestController;
use App\Services\RequestService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

test('requester home renders a dashboard analytics panel with status metrics and insights', function () {
    $user = (object) [
        'name' => 'Ava Brown',
        'profile_image' => null,
    ];

    $recentRequests = collect([
        (object) [
            '_id' => 'pending-1',
            'patient_name' => 'Maya',
            'blood_group' => 'O+',
            'hospital' => 'City Hospital',
            'city' => 'Lahore',
            'status' => 'Pending',
            'admin_message' => null,
            'created_at' => Carbon::parse('2026-05-18 09:00:00'),
        ],
        (object) [
            'patient_name' => 'Noor',
            'blood_group' => 'A+',
            'hospital' => 'General Care',
            'city' => 'Karachi',
            'status' => 'Approved',
            'admin_message' => null,
            'created_at' => Carbon::parse('2026-05-19 11:30:00'),
        ],
        (object) [
            'patient_name' => 'Ali',
            'blood_group' => 'B+',
            'hospital' => 'North Clinic',
            'city' => 'Islamabad',
            'status' => 'Completed',
            'admin_message' => null,
            'created_at' => Carbon::parse('2026-05-20 14:15:00'),
        ],
    ]);

    $html = view('requester.home', [
        'user' => $user,
        'totalRequests' => 8,
        'pendingRequests' => 2,
        'approvedRequests' => 3,
        'completedRequests' => 3,
        'rejectedRequests' => 0,
        'recentRequests' => $recentRequests,
        'requesterPriorityData' => [],
        'activeFilterStatus' => 'Pending',
    ])->render();

    expect($html)->toContain('dashboard-analytics');
    expect($html)->toContain('activity-chart');
    expect($html)->toContain('trend-line');
    expect($html)->toContain('trend-point');
    expect($html)->toContain('trend-area');
    expect($html)->toContain('trend-grid');
    expect($html)->toContain('Trend summary');
    expect($html)->toContain('Improving by 2 milestones');
    expect($html)->toContain('Recent activity');
    expect($html)->toContain('Newest update');
    expect($html)->toContain('Current focus');
    expect($html)->toContain('Momentum');
    expect($html)->toContain('Improving');
    expect($html)->toContain('Suggested next step');
    expect($html)->toContain('Review pending requests');
    expect($html)->toContain('Status breakdown');
    expect($html)->toContain('Oldest pending');
    expect($html)->toContain('Days waiting');
    expect($html)->toContain('Priority');
    expect($html)->toContain('High priority');
    expect($html)->toContain('Suggested action');
    expect($html)->toContain('Review now');
    expect($html)->toContain('request/pending-1');
    expect($html)->toContain('Maya');
    expect($html)->toContain('Blood group');
    expect($html)->toContain('O+');
    expect($html)->toContain('City Hospital');
    expect($html)->toContain('View details');
    expect($html)->toContain('25%');
    expect($html)->toContain('Approval rate');
    expect($html)->toContain('Completion rate');
    expect($html)->toContain('Average wait');
    expect($html)->toContain('Queue health');
    expect($html)->toContain('Critical');
    expect($html)->toContain('Urgent actions');
    expect($html)->toContain('Review oldest pending request');
    expect($html)->toContain('Quick filters');
    expect($html)->toContain('Pending (2)');
    expect($html)->toContain('Approved (3)');
    expect($html)->toContain('Completed (3)');
    expect($html)->toContain('Rejected (0)');
    expect($html)->toContain('status=Pending');
    expect($html)->toContain('status=Approved');
    expect($html)->toContain('status=Completed');
    expect($html)->toContain('status=Rejected');
    expect($html)->toContain('Current filter');
    expect($html)->toContain('Pending');
    expect($html)->toContain('Clear filter');
    expect($html)->toContain('bg-amber-200');
    expect($html)->toContain('text-amber-900');
    expect($html)->toContain('font-bold');
    expect($html)->toContain('grid-cols-2');
    expect($html)->toContain('sm:grid-cols-4');
    expect($html)->toContain('xl:grid-cols-4');
    expect($html)->toContain('w-full');
    expect($html)->toContain('sm:w-auto');
    expect($html)->toContain('sm:flex-row');
    expect($html)->toContain('sm:items-start');
    expect($html)->toContain('gap-3');
    expect($html)->toContain('2 pending');
    expect($html)->toContain('3 approved');
});

test('requester home forwards the active status filter to the request service', function () {
    $requester = new \App\Models\User();
    $requester->id = 'requester-1';
    $requester->role = 'requester';
    $requester->name = 'Filter Tester';

    Auth::shouldReceive('guard')->andReturnSelf();
    Auth::shouldReceive('check')->andReturn(true);
    Auth::shouldReceive('guest')->andReturn(false);
    Auth::shouldReceive('user')->andReturn($requester);

    $service = \Mockery::mock(RequestService::class);
    $service->shouldReceive('getRequesterHomeData')
        ->once()
        ->withArgs(function ($user, $status = null) use ($requester) {
            return $user === $requester && $status === 'Pending';
        })
        ->andReturn([
            'user' => $requester,
            'totalRequests' => 2,
            'pendingRequests' => 2,
            'approvedRequests' => 0,
            'completedRequests' => 0,
            'rejectedRequests' => 0,
            'recentRequests' => collect(),
            'requesterPriorityData' => [],
        ]);

    $this->app->instance(RequestService::class, $service);

    $controller = app(RequestController::class);
    $html = $controller->requesterHome(new Request(['status' => 'Pending']))->render();

    expect($html)->toContain('Current filter');
    expect($html)->toContain('Pending');
    expect($html)->toContain('2 total');
    expect($html)->toContain('0 approved');
});
