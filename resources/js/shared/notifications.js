const STORAGE_KEY = 'eblood-notifications-v1';

const VALID_ROLES = ['admin', 'donor', 'requester'];

const getCurrentRole = () => {
    const role = window.__ebloodCurrentRole;

    if (VALID_ROLES.includes(role)) {
        return role;
    }

    return 'guest';
};

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
    read: Boolean(notification?.read),
});

const getAllNotifications = () => {
    const seed = getSeedNotifications().map(normalizeNotification);
    const stored = getStoredNotifications().map(normalizeNotification);

    return [...seed, ...stored].reduce((items, notification) => {
        if (!notification?.id) {
            return items;
        }

        const existingIndex = items.findIndex((item) => item.id === notification.id);

        if (existingIndex === -1) {
            items.push(notification);
            return items;
        }

        items[existingIndex] = {
            ...items[existingIndex],
            ...notification,
            read: Boolean(notification.read),
        };

        return items;
    }, []);
};

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
    const merged = getAllNotifications();
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

const getTypeStyles = (type) => {
    const styles = {
        announcement: 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-100',
        reminder: 'bg-amber-100 text-amber-700 dark:bg-amber-950/40 dark:text-amber-200',
        approved: 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-200',
        rejected: 'bg-rose-100 text-rose-700 dark:bg-rose-950/40 dark:text-rose-200',
        critical: 'bg-red-100 text-red-700 dark:bg-red-950/40 dark:text-red-200',
    };

    return styles[type] || styles.reminder;
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
                <p class="text-sm font-semibold text-slate-900 dark:text-white">No alerts yet</p>
                <p class="mt-2 text-sm leading-6 text-slate-500 dark:text-slate-300">You're all caught up. New updates will appear here when your role needs attention.</p>
            </div>
        `;
        return;
    }

    container.innerHTML = notifications.map((notification) => `
        <div class="rounded-[1.5rem] border border-slate-200/80 bg-white/95 px-4 py-4 shadow-sm transition-all duration-200 hover:border-red-200 hover:shadow-[0_16px_40px_-28px_rgba(239,68,68,0.75)] dark:border-slate-700/80 dark:bg-slate-950/90">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="inline-flex rounded-full px-2.5 py-1 text-[11px] font-semibold uppercase tracking-[0.2em] ${getTypeStyles(notification.type)}">${notification.type || 'update'}</span>
                        <span class="text-xs text-slate-500 dark:text-slate-300">${notification.read ? 'Read' : 'Unread'}</span>
                    </div>
                    <p class="mt-3 text-sm font-semibold text-slate-900 dark:text-white">${notification.title}</p>
                    <p class="mt-2 text-sm leading-6 text-slate-500 dark:text-slate-300">${notification.message}</p>
                </div>
                <button type="button" data-notification-id="${notification.id}" class="js-mark-read shrink-0 rounded-full px-3 py-1 text-xs font-semibold text-slate-600 transition hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-800">
                    ${notification.read ? 'Seen' : 'Mark read'}
                </button>
            </div>
        </div>
    `).join('');

    container.querySelectorAll('.js-mark-read').forEach((button) => {
        button.addEventListener('click', () => {
            markNotificationAsRead(button.dataset.notificationId);
        });
    });
};

const updateNotifications = (updater) => {
    const notifications = getAllNotifications().map(updater);
    saveNotifications(notifications);
    renderNotifications();
};

const markNotificationAsRead = (id) => {
    updateNotifications((notification) => (
        notification.id === id ? { ...notification, read: true } : notification
    ));
};

const markAllRead = () => {
    updateNotifications((notification) => ({ ...notification, read: true }));
};

const refreshNotifications = () => {
    renderNotifications();
};

const setupDropdown = () => {
    const button = document.getElementById('notification-toggle');
    const dropdown = document.getElementById('notification-dropdown');

    if (!button || !dropdown) {
        return;
    }

    button.setAttribute('aria-haspopup', 'true');
    button.setAttribute('aria-expanded', 'false');

    const openDropdown = () => {
        dropdown.style.display = 'flex';
        button.setAttribute('aria-expanded', 'true');
    };

    const closeDropdown = () => {
        dropdown.style.display = 'none';
        button.setAttribute('aria-expanded', 'false');
    };

    button.addEventListener('click', (event) => {
        event.stopPropagation();

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

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeDropdown();
        }
    });

    const markAll = document.getElementById('mark-all-read');
    if (markAll) {
        markAll.addEventListener('click', markAllRead);
    }

    window.addEventListener('storage', refreshNotifications);
    window.addEventListener('eblood:notifications:refresh', refreshNotifications);
};

export const initNotificationCenter = () => {
    const role = getCurrentRole();

    if (role === 'guest') {
        return;
    }

    renderNotifications();
    setupDropdown();

    window.setInterval(refreshNotifications, 30000);
};
