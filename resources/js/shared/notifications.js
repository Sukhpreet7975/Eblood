const STORAGE_KEY = 'eblood-notifications-v1';

const getCurrentRole = () => window.__ebloodCurrentRole || 'guest';

const getDefaultNotificationsForRole = (role) => {
    if (role === 'admin') {
        return [
            {
                id: 'admin-platform-summary',
                title: 'Admin summary',
                message: 'Platform health checks are running and system-wide alerts are ready for review.',
                type: 'announcement',
                read: false,
                role: 'admin',
            },
            {
                id: 'admin-queue-review',
                title: 'Emergency queue review',
                message: 'Review pending requests to keep response times fast and transparent.',
                type: 'reminder',
                read: false,
                role: 'admin',
            },
        ];
    }

    if (role === 'donor') {
        return [
            {
                id: 'donor-availability-reminder',
                title: 'Availability reminder',
                message: 'Keep your donor status updated so patients in your city can contact you faster.',
                type: 'reminder',
                read: false,
                role: 'donor',
            },
            {
                id: 'donor-profile-check',
                title: 'Profile check',
                message: 'Refresh your profile and availability so requesters get the latest information.',
                type: 'announcement',
                read: false,
                role: 'donor',
            },
        ];
    }

    if (role === 'requester') {
        return [
            {
                id: 'requester-search-tip',
                title: 'Search tip',
                message: 'Use city and blood group filters to find the most compatible donors quickly.',
                type: 'announcement',
                read: false,
                role: 'requester',
            },
            {
                id: 'requester-follow-up',
                title: 'Follow-up reminder',
                message: 'Keep your request details current so donors and admins can respond effectively.',
                type: 'reminder',
                read: false,
                role: 'requester',
            },
        ];
    }

    return [];
};

const getStoredNotifications = () => {
    try {
        const parsed = JSON.parse(localStorage.getItem(STORAGE_KEY) || '[]');
        return Array.isArray(parsed) ? parsed : [];
    } catch (error) {
        return [];
    }
};

const saveNotifications = (notifications) => {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(notifications));
};

const getSeedNotifications = () => Array.isArray(window.__ebloodNotificationsSeed) ? window.__ebloodNotificationsSeed : [];

const normalizeNotification = (notification) => ({
    ...notification,
    role: notification?.role || 'all',
});

const isNotificationVisible = (notification, role) => {
    if (!notification) {
        return false;
    }

    if (role === 'guest') {
        return false;
    }

    return notification.role === role || notification.role === 'all';
};

const resolveNotifications = () => {
    const role = getCurrentRole();
    const seed = getSeedNotifications().map(normalizeNotification);
    const stored = getStoredNotifications().map(normalizeNotification);

    const merged = [...seed, ...stored].reduce((items, notification) => {
        if (!notification?.id) {
            return items;
        }

        if (!items.some((item) => item.id === notification.id)) {
            items.push(notification);
        }

        return items;
    }, []);

    const visibleNotifications = merged.filter((notification) => isNotificationVisible(notification, role));

    if (visibleNotifications.length) {
        saveNotifications(merged);
        return visibleNotifications;
    }

    const defaults = getDefaultNotificationsForRole(role);
    saveNotifications(defaults);

    return defaults;
};

const buildBadge = (count) => {
    const badge = document.getElementById('notification-badge');

    if (!badge) {
        return;
    }

    badge.textContent = String(count);
    badge.classList.toggle('hidden', count === 0);
};

const renderNotifications = () => {
    const notifications = resolveNotifications();
    const container = document.getElementById('notification-list');

    if (!container) {
        return;
    }

    const unreadCount = notifications.filter((notification) => !notification.read).length;
    buildBadge(unreadCount);

    if (!notifications.length) {
        container.innerHTML = `
            <div class="rounded-[1.5rem] border border-dashed border-slate-200 bg-slate-50 px-4 py-6 text-left dark:border-slate-700 dark:bg-slate-900/80">
                <p class="text-sm font-semibold text-slate-900 dark:text-white">No notifications yet</p>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-300">You are all caught up. New alerts will appear here automatically.</p>
            </div>
        `;
        return;
    }

    container.innerHTML = notifications.map((notification) => {
        const typeStyles = {
            announcement: 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-100',
            reminder: 'bg-amber-100 text-amber-700 dark:bg-amber-950/40 dark:text-amber-200',
            approved: 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-200',
            rejected: 'bg-rose-100 text-rose-700 dark:bg-rose-950/40 dark:text-rose-200',
            critical: 'bg-red-100 text-red-700 dark:bg-red-950/40 dark:text-red-200',
        };

        const typeClass = typeStyles[notification.type] || typeStyles.reminder;

        return `
            <div class="rounded-[1.5rem] border border-slate-200/80 bg-white/95 px-4 py-4 shadow-sm dark:border-slate-700/80 dark:bg-slate-950/90">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="inline-flex rounded-full px-2.5 py-1 text-[11px] font-semibold uppercase tracking-[0.2em] ${typeClass}">${notification.type || 'update'}</span>
                            <span class="text-xs text-slate-500 dark:text-slate-300">${notification.read ? 'Read' : 'Unread'}</span>
                        </div>
                        <p class="mt-3 text-sm font-semibold text-slate-900 dark:text-white">${notification.title}</p>
                        <p class="mt-2 text-sm leading-6 text-slate-500 dark:text-slate-300">${notification.message}</p>
                    </div>
                    <button type="button" data-notification-id="${notification.id}" class="js-mark-read rounded-full px-3 py-1 text-xs font-semibold text-slate-600 hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-800">
                        ${notification.read ? 'Seen' : 'Mark read'}
                    </button>
                </div>
            </div>
        `;
    }).join('');

    container.querySelectorAll('.js-mark-read').forEach((button) => {
        button.addEventListener('click', () => {
            markNotificationAsRead(button.dataset.notificationId);
        });
    });
};

const markNotificationAsRead = (id) => {
    const notifications = getStoredNotifications().map((notification) => (
        notification.id === id ? { ...notification, read: true } : notification
    ));

    saveNotifications(notifications);
    renderNotifications();
};

const markAllRead = () => {
    const notifications = getStoredNotifications().map((notification) => ({ ...notification, read: true }));
    saveNotifications(notifications);
    renderNotifications();
};

const setupDropdown = () => {
    const button = document.getElementById('notification-toggle');
    const dropdown = document.getElementById('notification-dropdown');

    if (!button || !dropdown) {
        return;
    }

    const openDropdown = () => {
        dropdown.style.display = 'flex';
    };

    const closeDropdown = () => {
        dropdown.style.display = 'none';
    };

    button.addEventListener('click', () => {
        if (dropdown.style.display === 'flex') {
            closeDropdown();
            return;
        }

        openDropdown();
    });

    document.addEventListener('click', (event) => {
        if (dropdown.contains(event.target) || button.contains(event.target)) {
            return;
        }

        closeDropdown();
    });

    const markAll = document.getElementById('mark-all-read');
    if (markAll) {
        markAll.addEventListener('click', markAllRead);
    }
};

export const initNotificationCenter = () => {
    if (getCurrentRole() === 'guest') {
        return;
    }

    renderNotifications();
    setupDropdown();
};
