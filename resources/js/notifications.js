const STORAGE_KEY = 'eblood-notifications-v1';

const defaultNotifications = [
    {
        id: 'system-announcement',
        title: 'Admin announcement',
        message: 'System health checks are running and the platform is operating normally.',
        type: 'announcement',
        read: false,
    },
    {
        id: 'availability-reminder',
        title: 'Availability reminder',
        message: 'Update your donor status regularly so patients can contact you faster.',
        type: 'reminder',
        read: false,
    },
];

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

const resolveNotifications = () => {
    const stored = getStoredNotifications();
    const seed = getSeedNotifications();

    const merged = [...seed, ...stored].reduce((items, notification) => {
        if (!notification?.id) {
            return items;
        }

        if (!items.some((item) => item.id === notification.id)) {
            items.push(notification);
        }

        return items;
    }, []);

    const finalNotifications = merged.length ? merged : defaultNotifications;

    saveNotifications(finalNotifications);

    return finalNotifications;
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
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-300">You are all caught up. New request updates will appear here automatically.</p>
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
            const id = button.dataset.notificationId;
            markNotificationAsRead(id);
        });
    });
};

const markNotificationAsRead = (id) => {
    const notifications = getStoredNotifications();
    const next = notifications.map((notification) => (
        notification.id === id ? { ...notification, read: true } : notification
    ));

    saveNotifications(next);
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

    button.addEventListener('click', () => {
        dropdown.classList.toggle('hidden');
    });

    document.addEventListener('click', (event) => {
        if (dropdown.contains(event.target) || button.contains(event.target)) {
            return;
        }

        dropdown.classList.add('hidden');
    });

    const markAll = document.getElementById('mark-all-read');
    if (markAll) {
        markAll.addEventListener('click', markAllRead);
    }
};

export const initNotificationCenter = () => {
    renderNotifications();
    setupDropdown();
};
