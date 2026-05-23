<?php

namespace App\Services;

class NotificationService
{
    public function roleNotifications(string $role): array
    {
        return match ($role) {
            'admin' => [
                [
                    'id' => 'admin-platform-summary',
                    'title' => 'Admin summary',
                    'message' => 'Platform health checks are running and system-wide alerts are ready for review.',
                    'type' => 'announcement',
                    'read' => false,
                    'role' => 'admin',
                ],
                [
                    'id' => 'admin-queue-review',
                    'title' => 'Emergency queue review',
                    'message' => 'Review pending requests to keep response times fast and transparent.',
                    'type' => 'reminder',
                    'read' => false,
                    'role' => 'admin',
                ],
            ],
            'donor' => [
                [
                    'id' => 'donor-availability-reminder',
                    'title' => 'Availability reminder',
                    'message' => 'Keep your donor status updated so patients in your city can contact you faster.',
                    'type' => 'reminder',
                    'read' => false,
                    'role' => 'donor',
                ],
                [
                    'id' => 'donor-profile-check',
                    'title' => 'Profile check',
                    'message' => 'Refresh your profile and availability so requesters get the latest information.',
                    'type' => 'announcement',
                    'read' => false,
                    'role' => 'donor',
                ],
            ],
            'requester' => [
                [
                    'id' => 'requester-search-tip',
                    'title' => 'Search tip',
                    'message' => 'Use city and blood group filters to find the most compatible donors quickly.',
                    'type' => 'announcement',
                    'read' => false,
                    'role' => 'requester',
                ],
                [
                    'id' => 'requester-follow-up',
                    'title' => 'Follow-up reminder',
                    'message' => 'Keep your request details current so donors and admins can respond effectively.',
                    'type' => 'reminder',
                    'read' => false,
                    'role' => 'requester',
                ],
            ],
            default => [],
        };
    }
}
