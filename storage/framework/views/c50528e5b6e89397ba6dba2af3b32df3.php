

<?php $__env->startSection('content'); ?>

<div class="space-y-8">

    <section class="rounded-2xl bg-gradient-to-r from-red-600 to-rose-500 text-white p-6 sm:p-8 shadow-lg">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="flex-1 min-w-0">
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold break-words">Hello <?php echo e($user->name); ?>,</h1>
                <p class="mt-2 text-sm opacity-90">Your requester dashboard gives you fast access to emergency requests and status updates.</p>
                <p class="mt-3 text-xs sm:text-sm italic">"Help is closer when you make your needs visible."</p>

                <div class="mt-4 flex flex-wrap gap-2 sm:gap-3">
                    <a href="<?php echo e(route('requester.requests.create')); ?>" class="inline-flex items-center gap-2 bg-white text-red-600 px-3 sm:px-4 py-2 rounded-full text-sm sm:text-base font-semibold shadow hover:opacity-95">New Request</a>
                    <a href="<?php echo e(route('requester.requests.index')); ?>" class="inline-flex items-center gap-2 bg-white/20 text-white px-3 sm:px-4 py-2 rounded-full text-sm sm:text-base font-semibold border border-white/30 hover:opacity-95">My Requests</a>
                </div>
            </div>

            <div class="flex items-center gap-3 sm:gap-4 flex-shrink-0">
                <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full overflow-hidden border-4 border-white flex-shrink-0">
                    <?php if(isset($user->profile_image) && $user->profile_image): ?>
                        <img src="<?php echo e(asset('storage/profile_images/' . $user->profile_image)); ?>" alt="Profile" class="w-full h-full object-cover">
                    <?php else: ?>
                        <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($user->name)); ?>&background=fff&color=dc2626&size=256" alt="avatar" class="w-full h-full object-cover">
                    <?php endif; ?>
                </div>
                <div class="text-sm sm:text-base">
                    <div class="font-semibold">Request Status</div>
                    <div class="text-lg sm:text-xl font-bold"><?php echo e($totalRequests); ?></div>
                    <div class="mt-2 text-xs sm:text-sm">Requests made</div>
                </div>
            </div>
        </div>
    </section>

    <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
        <div class="card-panel dark:card-panel-dark">
            <p class="text-sm text-slate-500 dark:text-slate-400">Total Requests</p>
            <p class="text-2xl font-bold text-red-600"><?php echo e($totalRequests); ?></p>
        </div>
        <div class="card-panel dark:card-panel-dark">
            <p class="text-sm text-slate-500 dark:text-slate-400">Pending</p>
            <p class="text-2xl font-bold text-yellow-600"><?php echo e($pendingRequests); ?></p>
        </div>
        <div class="card-panel dark:card-panel-dark">
            <p class="text-sm text-slate-500 dark:text-slate-400">Approved</p>
            <p class="text-2xl font-bold text-blue-600"><?php echo e($approvedRequests); ?></p>
        </div>
        <div class="card-panel dark:card-panel-dark">
            <p class="text-sm text-slate-500 dark:text-slate-400">Completed</p>
            <p class="text-2xl font-bold text-green-600"><?php echo e($completedRequests); ?></p>
        </div>
    </div>

    <?php
        $approvalRate = $totalRequests > 0 ? round(($approvedRequests / $totalRequests) * 100) : 0;
        $completionRate = $totalRequests > 0 ? round(($completedRequests / $totalRequests) * 100) : 0;
        $activeRequests = $pendingRequests + $approvedRequests;
        $trendRequests = $recentRequests->sortBy(function ($request) {
            return optional($request->created_at)->timestamp ?? 0;
        })->values();
        $trendPoints = $trendRequests->map(function ($request, $index) use ($trendRequests) {
            $status = $request->status ?? 'Pending';
            $score = match ($status) {
                'Completed' => 3,
                'Approved' => 2,
                'Rejected' => 0,
                default => 1,
            };

            $count = max($trendRequests->count(), 1);
            $x = $count === 1 ? 50 : round((100 / max($count - 1, 1)) * $index, 2);
            $y = round(83 - ($score * 24), 2);

            return [
                'label' => optional($request->created_at)->format('M d') ?? 'Recent',
                'status' => $status,
                'score' => $score,
                'x' => $x,
                'y' => $y,
            ];
        })->values();
        $trendBaselineY = 83;
        $trendPath = $trendPoints->map(function ($point) {
            return $point['x'] . ',' . $point['y'];
        })->implode(' ');
        $trendAreaPath = $trendPoints->isEmpty()
            ? ''
            : 'M ' . $trendPoints->first()['x'] . ',' . $trendBaselineY
                . ' L ' . $trendPoints->map(fn ($point) => $point['x'] . ',' . $point['y'])->implode(' L ')
                . ' L ' . $trendPoints->last()['x'] . ',' . $trendBaselineY
                . ' Z';
        $latestRequest = $trendRequests->last();
        $latestUpdateLabel = $latestRequest ? (optional($latestRequest->created_at)->format('M d, Y') ?? 'Recent') : 'No recent activity';
        $latestStatusLabel = $latestRequest?->status ?? 'No update';
        $focusCopy = $pendingRequests > 0
            ? $pendingRequests . ' pending request' . ($pendingRequests === 1 ? '' : 's') . ' still need attention.'
            : 'All active requests are currently on track.';
        $oldestPendingRequest = $recentRequests
            ->where('status', 'Pending')
            ->sortBy(fn ($request) => optional($request->created_at)->timestamp ?? PHP_INT_MAX)
            ->first();
        $oldestPendingLabel = $oldestPendingRequest?->patient_name ?? 'No pending requests';
        $oldestPendingDate = $oldestPendingRequest
            ? optional($oldestPendingRequest->created_at)->format('M d, Y')
            : null;
        $oldestPendingDays = $oldestPendingRequest
            ? optional($oldestPendingRequest->created_at)->diffInDays(now())
            : 0;
        $pendingWaitDays = $recentRequests
            ->where('status', 'Pending')
            ->map(fn ($request) => optional($request->created_at)->diffInDays(now()) ?? 0)
            ->values();
        $averagePendingWait = $pendingWaitDays->isEmpty()
            ? 0
            : round($pendingWaitDays->avg(), 1);
        $queueHealthLabel = 'Healthy';
        $queueHealthCopy = 'Your pending queue is in good shape.';

        if ($averagePendingWait >= 5) {
            $queueHealthLabel = 'Critical';
            $queueHealthCopy = 'Several pending requests are waiting too long and need attention.';
        } elseif ($averagePendingWait >= 2) {
            $queueHealthLabel = 'Watch';
            $queueHealthCopy = 'Pending requests are aging and should be reviewed soon.';
        }

        $oldestPendingId = $oldestPendingRequest
            ? optional($oldestPendingRequest)->_id ?? optional($oldestPendingRequest)->id
            : null;
        $oldestPendingUrl = $oldestPendingId
            ? route('requester.requests.show', ['id' => $oldestPendingId])
            : null;
        $priorityLabel = 'Low priority';
        $priorityCopy = 'No urgent follow-up needed yet.';

        if ($oldestPendingDays >= 5) {
            $priorityLabel = 'High priority';
            $priorityCopy = 'This request has been waiting a while and should be reviewed soon.';
            $actionLabel = 'Review now';
            $actionCopy = 'Open this request and follow up before it waits longer.';
        } elseif ($oldestPendingDays >= 2) {
            $priorityLabel = 'Medium priority';
            $priorityCopy = 'This request needs attention within the next day.';
            $actionLabel = 'Schedule review';
            $actionCopy = 'Check this request soon and confirm the next step.';
        } else {
            $actionLabel = 'Monitor';
            $actionCopy = 'Keep an eye on the request and revisit if it changes.';
        }

        $momentumLabel = 'Stable';
        $momentumCopy = 'Activity is steady right now.';
        $suggestedNextStep = 'Create a new request when you need urgent help.';
        $statusBreakdown = [
            'Pending' => [
                'count' => $pendingRequests,
                'percent' => $totalRequests > 0 ? round(($pendingRequests / $totalRequests) * 100) : 0,
                'tone' => 'bg-amber-400',
            ],
            'Approved' => [
                'count' => $approvedRequests,
                'percent' => $totalRequests > 0 ? round(($approvedRequests / $totalRequests) * 100) : 0,
                'tone' => 'bg-sky-500',
            ],
            'Completed' => [
                'count' => $completedRequests,
                'percent' => $totalRequests > 0 ? round(($completedRequests / $totalRequests) * 100) : 0,
                'tone' => 'bg-emerald-500',
            ],
            'Rejected' => [
                'count' => $rejectedRequests,
                'percent' => $totalRequests > 0 ? round(($rejectedRequests / $totalRequests) * 100) : 0,
                'tone' => 'bg-rose-500',
            ],
        ];

        if ($pendingRequests > 0) {
            $suggestedNextStep = 'Review pending requests';
        } elseif ($approvedRequests > 0) {
            $suggestedNextStep = 'Monitor approved requests for updates';
        }

        if ($trendPoints->count() >= 2) {
            $firstScore = $trendPoints->first()['score'];
            $lastScore = $trendPoints->last()['score'];
            $trendDelta = $lastScore - $firstScore;

            if ($lastScore > $firstScore) {
                $momentumLabel = 'Improving';
                $momentumCopy = 'Your latest activity is moving toward completion.';
                $trendSummaryCopy = 'Improving by ' . $trendDelta . ' milestone' . ($trendDelta === 1 ? '' : 's');
            } elseif ($lastScore < $firstScore) {
                $momentumLabel = 'Needs attention';
                $momentumCopy = 'Recent updates are slowing down.';
                $trendSummaryCopy = 'Slowing by ' . abs($trendDelta) . ' milestone' . (abs($trendDelta) === 1 ? '' : 's');
            } else {
                $trendSummaryCopy = 'Stable across the latest records.';
            }

            $trendSummaryDetail = 'Latest activity moved from ' . $trendPoints->first()['status'] . ' to ' . $trendPoints->last()['status'] . '.';
        } else {
            $trendDelta = 0;
            $trendSummaryCopy = 'Not enough data for a trend summary.';
            $trendSummaryDetail = 'Add one more request update to compare progress.';
        }
    ?>

    <section class="dashboard-analytics card-panel dark:card-panel-dark">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Dashboard analytics</p>
                <h2 class="mt-2 text-xl font-bold text-slate-900 dark:text-white">Request performance at a glance</h2>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-300">Use these quick metrics to understand how your emergency requests are progressing.</p>
            </div>
            <div class="inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-sm font-semibold text-emerald-700 dark:bg-emerald-950/30 dark:text-emerald-200">
                <?php echo e($activeRequests); ?> active
            </div>
        </div>

        <div class="activity-chart mt-6 rounded-[1.5rem] border border-slate-200 bg-slate-50 px-4 py-4 dark:border-slate-700 dark:bg-slate-900/70">
            <div class="flex flex-col gap-3 xl:flex-row xl:items-end xl:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Recent activity</p>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-300">A timeline of your latest request milestones, ordered by timestamp.</p>
                </div>
                <div class="text-sm font-semibold text-slate-900 dark:text-white">
                    <?php echo e($trendRequests->count()); ?> records
                </div>
            </div>

            <div class="mt-4 grid gap-4 xl:grid-cols-[minmax(0,1.4fr)_minmax(0,1fr)] xl:items-start">
                <?php if($trendPoints->isEmpty()): ?>
                    <div class="rounded-[1rem] bg-white px-4 py-3 text-sm text-slate-500 dark:bg-slate-950/50 dark:text-slate-300">
                        Recent activity will appear here as soon as your requests are created or updated.
                    </div>
                <?php else: ?>
                    <div class="overflow-x-auto rounded-[1rem] bg-white px-3 py-2 dark:bg-slate-950/50">
                        <svg class="trend-line h-48 w-full min-w-[24rem] overflow-visible" viewBox="0 0 100 100" preserveAspectRatio="none" role="img" aria-label="Requester activity trend">
                            <defs>
                                <linearGradient id="trendGlow" x1="0%" y1="0%" x2="100%" y2="0%">
                                    <stop offset="0%" stop-color="#fb7185" stop-opacity="0.9" />
                                    <stop offset="100%" stop-color="#f59e0b" stop-opacity="0.95" />
                                </linearGradient>
                                <linearGradient id="trendFill" x1="0%" y1="0%" x2="0%" y2="100%">
                                    <stop offset="0%" stop-color="#fb7185" stop-opacity="0.18" />
                                    <stop offset="100%" stop-color="#f59e0b" stop-opacity="0.02" />
                                </linearGradient>
                            </defs>
                            <line class="trend-grid" x1="0" y1="83" x2="100" y2="83" stroke="#cbd5e1" stroke-width="0.8" stroke-dasharray="2 2" />
                            <?php if($trendAreaPath): ?>
                                <path class="trend-area" d="<?php echo e($trendAreaPath); ?>" fill="url(#trendFill)" />
                            <?php endif; ?>
                            <polyline class="trend-line" points="<?php echo e($trendPath); ?>" fill="none" stroke="url(#trendGlow)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <?php $__currentLoopData = $trendPoints; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $point): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <circle class="trend-point" cx="<?php echo e($point['x']); ?>" cy="<?php echo e($point['y']); ?>" r="1.8" fill="#fff" stroke="<?php echo e($point['status'] === 'Completed' ? '#10b981' : ($point['status'] === 'Approved' ? '#0ea5e9' : ($point['status'] === 'Rejected' ? '#f43f5e' : '#f59e0b'))); ?>" stroke-width="1" />
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = $trendPoints; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $point): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <text x="<?php echo e($point['x']); ?>" y="97" text-anchor="middle" font-size="3.2" fill="#64748b"><?php echo e($point['label']); ?></text>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </svg>

                        <div class="mt-3 rounded-[1rem] bg-slate-50 px-3 py-3 dark:bg-slate-900/40">
                            <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-400">Trend summary</p>
                            <p class="mt-2 text-sm font-semibold text-slate-900 dark:text-white"><?php echo e($trendSummaryCopy); ?></p>
                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-300"><?php echo e($trendSummaryDetail); ?></p>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="space-y-3">
                    <div class="rounded-[1rem] bg-white px-4 py-3 shadow-sm dark:bg-slate-950/50">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-400">Newest update</p>
                        <p class="mt-2 text-sm font-semibold text-slate-900 dark:text-white"><?php echo e($latestStatusLabel); ?> • <?php echo e($latestUpdateLabel); ?></p>
                    </div>
                    <div class="rounded-[1rem] bg-white px-4 py-3 shadow-sm dark:bg-slate-950/50">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-400">Current focus</p>
                        <p class="mt-2 text-sm font-semibold text-slate-900 dark:text-white"><?php echo e($focusCopy); ?></p>
                    </div>
                    <div class="rounded-[1rem] bg-white px-4 py-3 shadow-sm dark:bg-slate-950/50">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-400">Momentum</p>
                        <p class="mt-2 text-sm font-semibold text-slate-900 dark:text-white"><?php echo e($momentumLabel); ?></p>
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-300"><?php echo e($momentumCopy); ?></p>
                    </div>
                    <div class="rounded-[1rem] bg-white px-4 py-3 shadow-sm dark:bg-slate-950/50">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-400">Queue health</p>
                        <p class="mt-2 text-sm font-semibold text-slate-900 dark:text-white"><?php echo e($queueHealthLabel); ?></p>
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-300"><?php echo e($queueHealthCopy); ?></p>
                    </div>
                </div>
            </div>

            <div class="mt-4 rounded-[1rem] bg-white px-4 py-3 shadow-sm dark:bg-slate-950/50">
                <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-400">Suggested next step</p>
                <p class="mt-2 text-sm font-semibold text-slate-900 dark:text-white"><?php echo e($suggestedNextStep); ?></p>
            </div>

            <div class="mt-4 rounded-[1rem] bg-white px-4 py-3 shadow-sm dark:bg-slate-950/50">
                <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-400">Oldest pending</p>
                <p class="mt-2 text-sm font-semibold text-slate-900 dark:text-white"><?php echo e($oldestPendingLabel); ?></p>
                <?php if($oldestPendingDate): ?>
                    <div class="mt-2 space-y-1 text-xs text-slate-500 dark:text-slate-300">
                        <p><span class="font-semibold text-slate-700 dark:text-slate-200">Blood group:</span> <?php echo e(optional($oldestPendingRequest)->blood_group ?? 'Unknown'); ?></p>
                        <p><span class="font-semibold text-slate-700 dark:text-slate-200">Hospital:</span> <?php echo e(optional($oldestPendingRequest)->hospital ?? 'Unknown'); ?></p>
                    </div>
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-300">Since <?php echo e($oldestPendingDate); ?></p>
                    <p class="mt-1 text-xs font-semibold text-amber-600 dark:text-amber-300">Days waiting: <?php echo e($oldestPendingDays); ?> days</p>
                    <p class="mt-1 text-xs font-semibold text-slate-700 dark:text-slate-200">Priority: <?php echo e($priorityLabel); ?></p>
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-300"><?php echo e($priorityCopy); ?></p>
                    <div class="mt-3 inline-flex items-center rounded-full bg-rose-50 px-3 py-1 text-xs font-semibold text-rose-700 dark:bg-rose-950/40 dark:text-rose-200">
                        <span class="mr-1">Suggested action:</span>
                        <span><?php echo e($actionLabel); ?></span>
                    </div>
                    <?php if($oldestPendingUrl): ?>
                        <div class="mt-3">
                            <a href="<?php echo e($oldestPendingUrl); ?>" class="inline-flex items-center rounded-full bg-red-600 px-3 py-1.5 text-xs font-semibold text-white shadow-sm transition hover:bg-red-700">
                                Open request
                            </a>
                        </div>
                    <?php endif; ?>
                    <p class="mt-2 text-xs text-slate-500 dark:text-slate-300"><?php echo e($actionCopy); ?></p>
                <?php endif; ?>
            </div>

            <div class="mt-4 rounded-[1rem] bg-white px-4 py-3 shadow-sm dark:bg-slate-950/50">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-400">Status breakdown</p>
                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-300">A quick split of where your requests sit right now.</p>
                    </div>
                    <div class="text-sm font-semibold text-slate-900 dark:text-white"><?php echo e($totalRequests); ?> total</div>
                </div>

                <div class="mt-4 space-y-3">
                    <?php $__currentLoopData = $statusBreakdown; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label => $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div>
                            <div class="flex items-center justify-between text-xs font-semibold text-slate-500 dark:text-slate-300">
                                <span><?php echo e($label); ?></span>
                                <span><?php echo e($status['count']); ?> • <?php echo e($status['percent']); ?>%</span>
                            </div>
                            <div class="mt-1 h-2 rounded-full bg-slate-200 dark:bg-slate-800">
                                <div class="h-2 rounded-full <?php echo e($status['tone']); ?>" style="width: <?php echo e(max($status['percent'], 3)); ?>%"></div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <div class="mt-4 flex flex-wrap gap-3 text-xs text-slate-500 dark:text-slate-300">
                <span class="inline-flex items-center gap-2"><span class="h-2.5 w-2.5 rounded-full bg-amber-400"></span> Pending</span>
                <span class="inline-flex items-center gap-2"><span class="h-2.5 w-2.5 rounded-full bg-sky-500"></span> Approved</span>
                <span class="inline-flex items-center gap-2"><span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span> Completed</span>
                <span class="inline-flex items-center gap-2"><span class="h-2.5 w-2.5 rounded-full bg-rose-500"></span> Rejected</span>
            </div>
        </div>

        <div class="mt-6 grid gap-4 grid-cols-1 sm:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-[1.5rem] bg-slate-50 px-4 py-4 dark:bg-slate-900/70">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Approval rate</p>
                <p class="mt-3 text-2xl font-bold text-slate-900 dark:text-white"><?php echo e($approvalRate); ?>%</p>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-300"><?php echo e($approvedRequests); ?> approved out of <?php echo e($totalRequests); ?> requests.</p>
            </div>
            <div class="rounded-[1.5rem] bg-slate-50 px-4 py-4 dark:bg-slate-900/70">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Completion rate</p>
                <p class="mt-3 text-2xl font-bold text-slate-900 dark:text-white"><?php echo e($completionRate); ?>%</p>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-300"><?php echo e($completedRequests); ?> completed requests are fully closed.</p>
            </div>
            <div class="rounded-[1.5rem] bg-slate-50 px-4 py-4 dark:bg-slate-900/70">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Average wait</p>
                <p class="mt-3 text-2xl font-bold text-slate-900 dark:text-white"><?php echo e($averagePendingWait); ?> days</p>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-300">Average age of pending requests across your current queue.</p>
            </div>
            <div class="rounded-[1.5rem] bg-slate-50 px-4 py-4 dark:bg-slate-900/70">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Current priorities</p>
                <p class="mt-3 text-2xl font-bold text-slate-900 dark:text-white"><?php echo e($pendingRequests); ?> pending</p>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-300"><?php echo e($approvedRequests); ?> approved and ready to monitor.</p>
            </div>
        </div>
    </section>

    <section class="card-panel dark:card-panel-dark">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Urgent actions</p>
                <h3 class="mt-2 text-lg font-bold text-slate-900 dark:text-white">Stay ahead of the queue</h3>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-300">Use these quick actions to move the most important requests forward.</p>
            </div>
            <a href="<?php echo e(route('requester.requests.index')); ?>" class="inline-flex w-full items-center justify-center rounded-full bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-700 sm:w-auto">View all requests</a>
        </div>

        <div class="mt-4 grid gap-3 xl:grid-cols-3">
            <div class="rounded-[1.25rem] border border-rose-100 bg-rose-50 px-4 py-4 dark:border-rose-900/60 dark:bg-rose-950/30">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-rose-700 dark:text-rose-200">Review oldest pending request</p>
                <p class="mt-3 text-sm font-semibold text-slate-900 dark:text-white"><?php echo e($oldestPendingLabel); ?></p>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-300"><?php echo e($oldestPendingDays); ?> days waiting • <?php echo e(optional($oldestPendingRequest)->blood_group ?? 'Unknown'); ?> • <?php echo e(optional($oldestPendingRequest)->hospital ?? 'Unknown'); ?></p>
                <?php if($oldestPendingUrl): ?>
                    <a href="<?php echo e($oldestPendingUrl); ?>" class="mt-4 inline-flex items-center rounded-full bg-red-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-red-700">Open request</a>
                <?php endif; ?>
            </div>

            <div class="rounded-[1.25rem] border border-amber-100 bg-amber-50 px-4 py-4 dark:border-amber-900/70 dark:bg-amber-950/30">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-amber-700 dark:text-amber-200">Queue health</p>
                <p class="mt-3 text-2xl font-bold text-slate-900 dark:text-white"><?php echo e($queueHealthLabel); ?></p>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-300"><?php echo e($queueHealthCopy); ?></p>
                <a href="<?php echo e(route('requester.requests.index')); ?>" class="mt-4 inline-flex items-center rounded-full bg-amber-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-amber-700">Review queue</a>
            </div>

            <div class="rounded-[1.25rem] border border-emerald-100 bg-emerald-50 px-4 py-4 dark:border-emerald-900/70 dark:bg-emerald-950/30">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-700 dark:text-emerald-200">Create follow-up</p>
                <p class="mt-3 text-sm font-semibold text-slate-900 dark:text-white">Add a new request when urgent help is needed.</p>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">Keep the latest details visible so you can respond faster.</p>
                <a href="<?php echo e(route('requester.requests.create')); ?>" class="mt-4 inline-flex items-center rounded-full bg-emerald-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-emerald-700">New request</a>
            </div>
        </div>
    </section>

    <section class="card-panel dark:card-panel-dark">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Quick filters</p>
                <h3 class="mt-2 text-lg font-bold text-slate-900 dark:text-white">Jump straight to the requests you need</h3>
            </div>
            <p class="text-sm text-slate-500 dark:text-slate-300">Use these shortcuts to view specific request states on the full request list.</p>
        </div>

        <?php
            $activeFilterStatus = $activeFilterStatus ?? null;
        ?>

        <div class="mt-4 flex flex-wrap gap-2">
            <a href="<?php echo e(route('requester.requests.index')); ?>" class="inline-flex items-center rounded-full border px-3 py-1.5 text-sm font-semibold shadow-sm <?php echo e($activeFilterStatus === null ? 'border-red-300 bg-red-50 text-red-700 font-bold' : 'border-slate-300 text-slate-700 hover:border-red-400 hover:text-red-600 dark:border-slate-700 dark:text-slate-200'); ?>">All requests</a>
            <a href="<?php echo e(route('requester.requests.index', ['status' => 'Pending'])); ?>" class="inline-flex items-center rounded-full border px-3 py-1.5 text-sm font-semibold shadow-sm <?php echo e($activeFilterStatus === 'Pending' ? 'border-amber-300 bg-amber-200 text-amber-900 font-bold' : 'border-amber-200 bg-amber-50 text-amber-700 hover:bg-amber-100 dark:border-amber-900/60 dark:bg-amber-950/30 dark:text-amber-200'); ?>">Pending (<?php echo e($pendingRequests); ?>)</a>
            <a href="<?php echo e(route('requester.requests.index', ['status' => 'Approved'])); ?>" class="inline-flex items-center rounded-full border px-3 py-1.5 text-sm font-semibold shadow-sm <?php echo e($activeFilterStatus === 'Approved' ? 'border-sky-300 bg-sky-200 text-sky-900 font-bold' : 'border-sky-200 bg-sky-50 text-sky-700 hover:bg-sky-100 dark:border-sky-900/60 dark:bg-sky-950/30 dark:text-sky-200'); ?>">Approved (<?php echo e($approvedRequests); ?>)</a>
            <a href="<?php echo e(route('requester.requests.index', ['status' => 'Completed'])); ?>" class="inline-flex items-center rounded-full border px-3 py-1.5 text-sm font-semibold shadow-sm <?php echo e($activeFilterStatus === 'Completed' ? 'border-emerald-300 bg-emerald-200 text-emerald-900 font-bold' : 'border-emerald-200 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 dark:border-emerald-900/60 dark:bg-emerald-950/30 dark:text-emerald-200'); ?>">Completed (<?php echo e($completedRequests); ?>)</a>
            <a href="<?php echo e(route('requester.requests.index', ['status' => 'Rejected'])); ?>" class="inline-flex items-center rounded-full border px-3 py-1.5 text-sm font-semibold shadow-sm <?php echo e($activeFilterStatus === 'Rejected' ? 'border-rose-300 bg-rose-200 text-rose-900 font-bold' : 'border-rose-200 bg-rose-50 text-rose-700 hover:bg-rose-100 dark:border-rose-900/60 dark:bg-rose-950/30 dark:text-rose-200'); ?>">Rejected (<?php echo e($rejectedRequests); ?>)</a>
        </div>

        <div class="mt-3 inline-flex flex-wrap items-center gap-2">
            <div class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-sm font-semibold text-slate-700 dark:bg-slate-800 dark:text-slate-100">
                <span class="mr-1">Current filter:</span>
                <span><?php echo e($activeFilterStatus ?? 'All requests'); ?></span>
            </div>
            <?php if($activeFilterStatus): ?>
                <a href="<?php echo e(route('requester.requests.index')); ?>" class="inline-flex items-center rounded-full border border-slate-300 px-3 py-1 text-sm font-semibold text-slate-700 hover:border-red-400 hover:text-red-600 dark:border-slate-700 dark:text-slate-200">Clear filter</a>
            <?php endif; ?>
        </div>
    </section>

    <div id="priority-insight" class="card-panel dark:card-panel-dark"></div>
    <div id="requester-priority-data" class="hidden">
        <?php echo json_encode($requesterPriorityData ?? [], 15, 512) ?>
    </div>

    <div class="card-panel dark:card-panel-dark">
        <div class="recent-requests-header flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between mb-4">
            <div>
                <h3 class="text-lg font-semibold">Recent Requests</h3>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">A quick snapshot of your latest emergency activity.</p>
            </div>
            <a href="<?php echo e(route('requester.requests.index')); ?>" class="inline-flex w-full items-center justify-center rounded-full bg-red-50 px-4 py-2 text-sm font-semibold text-red-700 hover:bg-red-100 dark:bg-red-950/30 dark:text-red-200 sm:w-auto">View all</a>
        </div>

        <div class="recent-requests-list space-y-4">
            <?php $__empty_1 = true; $__currentLoopData = $recentRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $requestId = optional($request)->_id ?? optional($request)->id;
                    $requestUrl = $requestId ? route('requester.requests.show', ['id' => $requestId]) : null;
                    $requestAge = optional($request->created_at)->diffInDays(now()) ?? 0;
                ?>

                <div class="rounded-[1.5rem] border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-700 dark:bg-slate-900/70">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                        <div class="min-w-0 flex-1">
                            <h4 class="text-lg font-semibold"><?php echo e($request->patient_name); ?></h4>
                            <p class="text-sm text-slate-500 dark:text-slate-400"><?php echo e($request->blood_group); ?> • <?php echo e($request->hospital); ?>, <?php echo e($request->city); ?></p>
                        </div>
                        <span class="inline-flex shrink-0 items-center justify-center rounded-full px-3 py-1 text-xs font-semibold <?php echo e($request->status === 'Approved' ? 'bg-blue-100 text-blue-800' : ($request->status === 'Completed' ? 'bg-green-100 text-green-800' : ($request->status === 'Rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800'))); ?>"><?php echo e($request->status ?? 'Pending'); ?></span>
                    </div>
                    <?php if($request->admin_message): ?>
                        <p class="mt-3 text-sm text-slate-500 dark:text-slate-400">Admin message: <?php echo e($request->admin_message); ?></p>
                    <?php endif; ?>
                    <div class="mt-3 flex flex-wrap items-center gap-2 text-xs text-slate-500 dark:text-slate-300">
                        <span>Days waiting: <?php echo e($requestAge); ?></span>
                        <span>•</span>
                        <span>Submitted <?php echo e(optional($request->created_at)->diffForHumans()); ?></span>
                    </div>
                    <?php if($requestUrl): ?>
                        <div class="mt-4">
                            <a href="<?php echo e($requestUrl); ?>" class="inline-flex items-center rounded-full bg-red-600 px-3 py-1.5 text-xs font-semibold text-white shadow-sm transition hover:bg-red-700">
                                View details
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-slate-500">No recent requests yet. Start by creating a new emergency request.</p>
            <?php endif; ?>
        </div>
    </div>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.requester', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\MyProject\eblood\resources\views/requester/home.blade.php ENDPATH**/ ?>