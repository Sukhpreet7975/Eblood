const COMPATIBILITY_RULES = {
    'A+': ['A+', 'AB+'],
    'A-': ['A+', 'A-', 'AB+', 'AB-'],
    'B+': ['B+', 'AB+'],
    'B-': ['B+', 'B-', 'AB+', 'AB-'],
    'O+': ['O+', 'A+', 'B+', 'AB+'],
    'O-': ['O-', 'O+', 'A-', 'A+', 'B-', 'B+', 'AB-', 'AB+'],
    'AB+': ['AB+'],
    'AB-': ['AB+', 'AB-'],
};

const RARITY = {
    'O-': 5,
    'AB-': 4,
    'B-': 3,
    'A-': 3,
    'O+': 2,
    'AB+': 1,
    'A+': 1,
    'B+': 1,
};

const BASE_RESPONSES = [
    {
        keywords: ['eligible', 'eligibility', 'can i donate'],
        reply: 'Most healthy adults can donate if they feel well, are hydrated, and are not currently unwell. If you have any recent illness, medication concerns, or travel restrictions, it is best to review them with your care team before donating.',
    },
    {
        keywords: ['hydrate', 'hydration', 'drink water'],
        reply: 'Hydrate well before and after donation, eat a balanced meal, and avoid heavy alcohol or fatigue. Gentle rest and light snacks are usually recommended after your donation.',
    },
    {
        keywords: ['recover', 'recovery', 'rest'],
        reply: 'After donation, rest for a short period, keep your arm supported, and continue to drink water. If you feel lightheaded or unwell, seek medical support promptly.',
    },
    {
        keywords: ['interval', 'how often', 'donate again'],
        reply: 'Donation intervals vary by local medical guidance, but most donors should wait until they feel fully recovered and follow the official recommendation in their area. Keeping your availability updated helps emergency teams plan faster.',
    },
    {
        keywords: ['emergency blood process', 'emergency process', 'blood process'],
        reply: 'When an urgent request is created, the system highlights the request based on blood rarity, city, and status. Donors who are available and compatible are surfaced first so the request can be handled quickly.',
    },
    {
        keywords: ['myth', 'fact', 'myths'],
        reply: 'Common myth: donating blood causes weakness. Fact: a single donation is carefully managed and most healthy donors recover quickly with hydration, nourishment, and rest.',
    },
    {
        keywords: ['compatible', 'compatibility', 'blood compatibility'],
        reply: 'Compatibility is checked locally using blood group rules. O- is the universal donor for red cells, while AB+ can receive from most groups. The search page highlights compatible donors automatically.',
    },
    {
        keywords: ['urgent', 'emergency', 'priority'],
        reply: 'Emergency priority is calculated using blood rarity, request age, and pending status. Rare blood groups and older urgent requests are prioritized so they can be matched faster.',
    },
    {
        keywords: ['nearby', 'find donor', 'recommend'],
        reply: 'Use the Search Donors page to see ranked donors. The platform prioritizes compatibility, city match, and availability so the best matches are surfaced first.',
    },
    {
        keywords: ['notify', 'alert', 'reminder'],
        reply: 'I can help enable browser alerts for fresh updates. Open the notification center in the top bar and use the local alerts option to stay informed.',
    },
];

function ensureWindowObject() {
    if (!window.eBloodSmart) {
        window.eBloodSmart = {};
    }

    return window.eBloodSmart;
}

function getCompatibilityLabel(targetGroup, donorGroup) {
    if (!targetGroup || !donorGroup) {
        return 'Unknown';
    }

    return COMPATIBILITY_RULES[targetGroup]?.includes(donorGroup) ? 'Compatible' : 'Review';
}

function getCompatibilityTone(label) {
    return label === 'Compatible' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800';
}

function calculateDonorScore(donor, targetGroup, currentCity) {
    let score = 0;

    if (getCompatibilityLabel(targetGroup, donor.blood_group) === 'Compatible') {
        score += 45;
    }

    if (currentCity && donor.city && donor.city.toLowerCase() === currentCity.toLowerCase()) {
        score += 25;
    }

    if (donor.available === 'yes') {
        score += 20;
    }

    if (donor.profile_image) {
        score += 5;
    }

    if (donor.phone) {
        score += 3;
    }

    if (targetGroup && RARITY[targetGroup]) {
        score += RARITY[targetGroup];
    }

    return score;
}

function formatTime() {
    return new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
}

function showToast(message, variant = 'info') {
    const existing = document.getElementById('smart-toast');

    if (existing) {
        existing.remove();
    }

    const toast = document.createElement('div');
    toast.id = 'smart-toast';
    toast.className = variant === 'success'
        ? 'fixed right-4 top-4 z-[60] rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 shadow-lg'
        : 'fixed right-4 top-4 z-[60] rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 shadow-lg';
    toast.textContent = message;

    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 2600);
}

function requestNotificationPermission() {
    if (!('Notification' in window)) {
        showToast('This browser does not support local notifications.', 'info');
        return Promise.resolve('unsupported');
    }

    if (Notification.permission === 'granted') {
        return Promise.resolve('granted');
    }

    if (Notification.permission === 'denied') {
        showToast('Browser notifications are blocked. Please enable them in your browser settings.', 'info');
        return Promise.resolve('denied');
    }

    return Notification.requestPermission().then((permission) => {
        if (permission === 'granted') {
            showToast('Local alerts enabled successfully.', 'success');
        }

        return permission;
    });
}

function showLocalNotification(title, body) {
    if (!('Notification' in window)) {
        return;
    }

    if (Notification.permission === 'granted') {
        new Notification(title, { body });
        return;
    }

    if (Notification.permission === 'default') {
        requestNotificationPermission().then((permission) => {
            if (permission === 'granted') {
                new Notification(title, { body });
            }
        });
    }
}

function initLocalNotifications() {
    const smart = ensureWindowObject();

    smart.requestNotificationPermission = requestNotificationPermission;
    smart.showLocalNotification = showLocalNotification;

    const reminder = document.getElementById('enable-alerts-btn');

    if (reminder) {
        reminder.addEventListener('click', () => {
            requestNotificationPermission();
        });
    }
}

function initHealthcareChatbot() {
    if (document.getElementById('eblood-chatbot')) {
        return;
    }

    const launcher = document.createElement('button');
    launcher.id = 'eblood-chat-launcher';
    launcher.type = 'button';
    launcher.setAttribute('aria-controls', 'eblood-chatbot');
    launcher.setAttribute('aria-expanded', 'false');
    launcher.className = 'fixed z-[60] inline-flex items-center gap-3 rounded-full bg-gradient-to-r from-red-600 to-rose-500 px-4 py-2.5 text-sm font-semibold text-white shadow-[0_26px_80px_-32px_rgba(239,68,68,0.9)] transition-all duration-200 hover:-translate-y-0.5 hover:shadow-[0_30px_90px_-30px_rgba(239,68,68,0.95)]';
    launcher.style.position = 'fixed';
    launcher.style.bottom = '1rem';
    launcher.style.right = '1rem';
    launcher.style.left = 'auto';
    launcher.style.top = 'auto';
    launcher.innerHTML = `
        <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-white/15">
            <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M12 2v20"/>
                <path d="M2 12h20"/>
            </svg>
        </span>
        <span class="flex flex-col items-start leading-none">
            <span>Care assistant</span>
            <span class="text-[11px] font-medium text-white/80">Live healthcare support</span>
        </span>
    `;

    const wrapper = document.createElement('div');
    wrapper.id = 'eblood-chatbot';
    wrapper.className = 'fixed z-[55] hidden flex flex-col overflow-hidden rounded-[1.75rem] border border-slate-200/80 bg-white/95 p-4 shadow-[0_24px_80px_-30px_rgba(15,23,42,0.45)] backdrop-blur-xl dark:border-slate-700/80 dark:bg-slate-950/95';
    wrapper.style.position = 'fixed';
    wrapper.style.bottom = '1rem';
    wrapper.style.right = '1rem';
    wrapper.style.left = 'auto';
    wrapper.style.top = 'auto';
    wrapper.style.height = '32rem';
    wrapper.style.maxHeight = 'calc(100vh - 5rem)';
    wrapper.style.width = 'min(24rem, calc(100vw - 1rem))';
    wrapper.style.maxWidth = 'calc(100vw - 1rem)';
    wrapper.innerHTML = `
        <div class="flex items-center justify-between gap-3 border-b border-slate-200/70 pb-3 dark:border-slate-700/70">
            <div>
                <p class="text-sm font-semibold text-slate-900 dark:text-white">Care assistant</p>
                <p class="mt-1 text-xs text-slate-500 dark:text-slate-300">Guidance, compatibility checks, and urgent alerts</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-[11px] font-semibold text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-200">Live</span>
                <button id="eblood-chat-toggle" type="button" class="rounded-full bg-slate-100 px-3 py-1 text-[11px] font-semibold text-slate-700 dark:bg-slate-800 dark:text-slate-100">Close</button>
            </div>
        </div>

        <div class="mt-3 rounded-[1.4rem] bg-gradient-to-r from-red-50 to-rose-50 px-4 py-3 dark:from-red-950/30 dark:to-rose-950/20">
            <p class="text-[11px] uppercase tracking-[0.2em] text-red-500">Care note</p>
            <p class="mt-2 text-sm leading-6 text-slate-700 dark:text-slate-100">Ask about donation guidance, compatibility, or emergency support and keep local notifications enabled for urgent updates.</p>
        </div>

        <div id="eblood-chat-body" class="mt-3 flex min-h-0 flex-1 flex-col gap-3">
            <div id="eblood-chat-log" class="flex-1 min-h-0 space-y-3 overflow-y-auto rounded-[1.35rem] bg-slate-50 p-3 dark:bg-slate-900/80"></div>

            <div class="grid grid-cols-2 gap-2">
                <button type="button" class="quick-chat-btn rounded-full bg-red-50 px-3 py-2 text-[11px] font-semibold text-red-700 dark:bg-red-950/40 dark:text-red-100" data-message="How do I donate?">Donate tips</button>
                <button type="button" class="quick-chat-btn rounded-full bg-slate-100 px-3 py-2 text-[11px] font-semibold text-slate-700 dark:bg-slate-800 dark:text-slate-100" data-message="Check compatibility">Compatibility</button>
                <button type="button" class="quick-chat-btn rounded-full bg-slate-100 px-3 py-2 text-[11px] font-semibold text-slate-700 dark:bg-slate-800 dark:text-slate-100" data-message="Show smart recommendations">Recommendations</button>
                <button type="button" class="quick-chat-btn rounded-full bg-slate-100 px-3 py-2 text-[11px] font-semibold text-slate-700 dark:bg-slate-800 dark:text-slate-100" data-message="Notify me">Alerts</button>
            </div>

            <div class="rounded-[1.25rem] border border-slate-200/80 bg-white px-2 py-2 dark:border-slate-700/80 dark:bg-slate-950">
                <div class="flex gap-2">
                    <input id="eblood-chat-input" type="text" placeholder="Ask about blood safety" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-900 focus:border-red-400 focus:outline-none dark:border-slate-700 dark:bg-slate-900 dark:text-white" />
                    <button id="eblood-chat-send" type="button" class="rounded-2xl bg-red-600 px-4 py-2 text-sm font-semibold text-white">Send</button>
                </div>
            </div>

            <button id="enable-alerts-btn" type="button" class="w-full rounded-2xl border border-red-200 bg-red-50 px-3 py-2 text-sm font-semibold text-red-700 dark:border-red-900/60 dark:bg-red-950/30 dark:text-red-100">Enable local alerts</button>
        </div>
    `;

    document.body.appendChild(launcher);
    document.body.appendChild(wrapper);

    const toggle = document.getElementById('eblood-chat-toggle');
    const log = document.getElementById('eblood-chat-log');
    const input = document.getElementById('eblood-chat-input');
    const send = document.getElementById('eblood-chat-send');

    const openChat = () => {
        wrapper.classList.remove('hidden');
        launcher.classList.add('hidden');
        launcher.setAttribute('aria-expanded', 'true');
    };

    const closeChat = () => {
        wrapper.classList.add('hidden');
        launcher.classList.remove('hidden');
        launcher.setAttribute('aria-expanded', 'false');
    };

    const appendMessage = (role, message) => {
        const bubble = document.createElement('div');
        bubble.className = role === 'assistant'
            ? 'rounded-[1.5rem] rounded-bl-md border border-slate-200 bg-white px-4 py-3 text-sm leading-6 text-slate-700 shadow-sm dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100'
            : 'rounded-[1.5rem] rounded-br-md bg-red-600 px-4 py-3 text-sm leading-6 text-white shadow-sm';
        bubble.textContent = message;
        log.appendChild(bubble);
        log.scrollTop = log.scrollHeight;
    };

    const streamAssistantReply = (message) => {
        const bubble = document.createElement('div');
        bubble.className = 'rounded-[1.5rem] rounded-bl-md border border-slate-200 bg-white px-4 py-3 text-sm leading-6 text-slate-700 shadow-sm dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100';
        bubble.innerHTML = `
            <div class="flex items-center gap-2 text-[11px] uppercase tracking-[0.2em] text-slate-400 dark:text-slate-300">
                <span class="h-2 w-2 rounded-full bg-red-500 animate-bounce"></span>
                <span class="h-2 w-2 rounded-full bg-rose-400 animate-bounce [animation-delay:120ms]"></span>
                <span class="h-2 w-2 rounded-full bg-amber-400 animate-bounce [animation-delay:240ms]"></span>
                <span>typing</span>
            </div>
        `;
        log.appendChild(bubble);
        log.scrollTop = log.scrollHeight;

        const characters = message.split('');
        let rendered = '';

        const timer = window.setInterval(() => {
            rendered += characters.shift();
            bubble.innerHTML = `<p class="text-sm leading-6 text-slate-700 dark:text-slate-100">${rendered}</p>`;
            log.scrollTop = log.scrollHeight;

            if (!characters.length) {
                window.clearInterval(timer);
            }
        }, 18);
    };

    const answerFor = (question) => {
        const normalized = question.toLowerCase();

        for (const item of BASE_RESPONSES) {
            if (item.keywords.some((keyword) => normalized.includes(keyword))) {
                return item.reply;
            }
        }

        return 'I can help with donor matching, blood compatibility, emergency priority, and donation tips. Try asking about compatibility, recommendations, or urgent care.';
    };

    const sendMessage = () => {
        const text = input.value.trim();

        if (!text) {
            return;
        }

        appendMessage('user', text);
        input.value = '';
        streamAssistantReply(answerFor(text));

        if (text.toLowerCase().includes('notify') || text.toLowerCase().includes('alert')) {
            requestNotificationPermission();
        }
    };

    launcher.addEventListener('click', () => {
        if (wrapper.classList.contains('hidden')) {
            openChat();
            return;
        }

        closeChat();
    });

    toggle.addEventListener('click', closeChat);

    send.addEventListener('click', sendMessage);
    input.addEventListener('keydown', (event) => {
        if (event.key === 'Enter') {
            event.preventDefault();
            sendMessage();
        }
    });

    document.querySelectorAll('.quick-chat-btn').forEach((button) => {
        button.addEventListener('click', () => {
            input.value = button.dataset.message;
            sendMessage();
        });
    });

    document.addEventListener('click', (event) => {
        if (wrapper.classList.contains('hidden')) {
            return;
        }

        if (!wrapper.contains(event.target) && !launcher.contains(event.target)) {
            closeChat();
        }
    });

    streamAssistantReply('Hi! I am your local care assistant. Ask me about donations, compatibility, or current emergency priority.');
}

function updateSearchSummary(donors, requestGroup) {
    const summaryCard = document.getElementById('smart-summary');
    const liveStatus = document.getElementById('refresh-status');
    const compatibilitySummary = document.getElementById('compatibility-summary');
    const recommendationSummary = document.getElementById('recommendation-summary');

    if (!summaryCard) {
        return;
    }

    if (liveStatus) {
        liveStatus.textContent = `Live • ${formatTime()}`;
    }

    if (compatibilitySummary) {
        if (!requestGroup) {
            compatibilitySummary.textContent = 'Choose a blood group to validate compatibility';
        } else {
            const compatible = donors.filter((donor) => getCompatibilityLabel(requestGroup, donor.blood_group) === 'Compatible').length;
            compatibilitySummary.textContent = `${compatible} of ${donors.length || 0} donors are compatible`;
        }
    }

    if (recommendationSummary) {
        if (donors.length) {
            recommendationSummary.textContent = `${donors[0].name} is the top match`;
        } else {
            recommendationSummary.textContent = 'No live matches yet';
        }
    }
}

function renderSearchResults(donors, requestGroup, currentCity) {
    const results = document.getElementById('results');

    if (!results) {
        return;
    }

    const ranked = [...donors]
        .map((donor, index) => ({
            ...donor,
            score: calculateDonorScore(donor, requestGroup, currentCity),
            compatibility: getCompatibilityLabel(requestGroup, donor.blood_group),
            index,
        }))
        .sort((first, second) => second.score - first.score);

    if (!ranked.length) {
        results.innerHTML = `
            <div class="col-span-full rounded-[2rem] border border-dashed border-slate-200 bg-white/95 px-6 py-10 text-center shadow-[0_18px_50px_-32px_rgba(15,23,42,0.28)] dark:border-slate-700 dark:bg-slate-950/80">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-[1.5rem] bg-red-50 text-red-600 dark:bg-red-950/40 dark:text-red-200">
                    <svg viewBox="0 0 24 24" class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 21l-4.35-4.35"/>
                        <circle cx="11" cy="11" r="7"/>
                    </svg>
                </div>
                <h3 class="mt-4 text-xl font-semibold text-slate-900 dark:text-white">No donors match your filters</h3>
                <p class="mx-auto mt-3 max-w-xl text-sm leading-7 text-slate-500 dark:text-slate-300">Try a wider city search or switch the blood group to see more available donors in your area.</p>
            </div>
        `;
        updateSearchSummary([], requestGroup);
        return;
    }

    results.innerHTML = ranked.map((donor, index) => `
        <article class="card-panel dark:card-panel-dark donor-card">
            <div class="flex items-start gap-4">
                <div class="flex h-14 w-14 shrink-0 items-center justify-center overflow-hidden rounded-[1.25rem] bg-red-50 text-lg font-bold text-red-700 dark:bg-red-950/40 dark:text-red-100">
                    ${donor.profile_image
                        ? `<img src="/storage/profile_images/${donor.profile_image}" alt="${donor.name || 'Donor'}" class="h-full w-full object-cover">`
                        : `<span>${(donor.name || 'D').charAt(0).toUpperCase()}</span>`}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-red-500">Rank #${index + 1}</p>
                    <h2 class="mt-2 text-xl font-semibold text-slate-900 dark:text-white">${donor.name || 'Unknown donor'}</h2>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-300">${donor.city || 'City not listed'}</p>
                </div>
            </div>

            <div class="mt-5 flex flex-wrap items-center gap-2">
                <span class="rounded-full bg-red-600 px-3 py-1 text-sm font-semibold text-white">${donor.blood_group || 'N/A'}</span>
                <span class="rounded-full px-3 py-1 text-sm font-semibold ${getCompatibilityTone(donor.compatibility)}">${donor.compatibility}</span>
                <span class="rounded-full px-3 py-1 text-sm font-semibold ${donor.available === 'yes' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-200' : 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-100'}">
                    ${donor.available === 'yes' ? 'Available now' : 'Currently unavailable'}
                </span>
            </div>

            <div class="mt-5 rounded-[1.5rem] bg-slate-50 px-4 py-3 dark:bg-slate-900/70">
                <p class="text-xs uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Privacy note</p>
                <p class="mt-2 text-sm leading-6 text-slate-700 dark:text-slate-200">Only limited donor details are shown here for safety. Contact information is shared only after a request is approved.</p>
            </div>
        </article>
    `).join('');

    updateSearchSummary(ranked, requestGroup);

    if (requestGroup && ranked.some((donor) => donor.compatibility === 'Compatible')) {
        showLocalNotification('Compatible donor update', 'Compatible donors are available for your selected blood group.');
    }
}

function initSearchIntelligence() {
    const form = document.getElementById('search-form');

    if (!form) {
        return;
    }

    const cityInput = document.getElementById('q-city');
    const bloodSelect = document.getElementById('q-blood');
    const refreshStatus = document.getElementById('refresh-status');
    const clearButton = document.getElementById('clear-btn');

    const fetchResults = async () => {
        if (!cityInput || !bloodSelect) {
            return;
        }

        const params = new URLSearchParams({
            city: cityInput.value || '',
            blood_group: bloodSelect.value || '',
        });

        if (refreshStatus) {
            refreshStatus.textContent = 'Refreshing...';
        }

        try {
            const response = await fetch(`/live-search?${params.toString()}`, {
                headers: {
                    Accept: 'application/json',
                },
            });

            const donors = await response.json();

            renderSearchResults(Array.isArray(donors) ? donors : [], bloodSelect.value, cityInput.value);
        } catch (error) {
            if (refreshStatus) {
                refreshStatus.textContent = 'Refresh failed';
            }

            showToast('Search refresh failed. Please try again.', 'info');
        }
    };

    cityInput.addEventListener('input', fetchResults);
    bloodSelect.addEventListener('change', fetchResults);
    form.addEventListener('submit', (event) => {
        event.preventDefault();
        fetchResults();
    });

    if (clearButton) {
        clearButton.addEventListener('click', () => {
            cityInput.value = '';
            bloodSelect.value = '';
            fetchResults();
        });
    }

    setInterval(fetchResults, 20000);
    fetchResults();
}

function calculatePriorityLevel(requests) {
    const pendingRequests = requests.filter((request) => (request.status || 'Pending') === 'Pending');

    if (!pendingRequests.length) {
        return {
            level: 'Low',
            score: 0,
            pendingCount: 0,
            message: 'No pending requests available right now.',
        };
    }

    let score = 0;

    pendingRequests.forEach((request) => {
        score += 30;

        if (RARITY[request.blood_group]) {
            score += RARITY[request.blood_group];
        }

        if (request.created_at) {
            const createdAt = new Date(request.created_at);
            const hoursAgo = (Date.now() - createdAt.getTime()) / 3600000;

            if (hoursAgo > 12) {
                score += 10;
            }
        }

        if (request.city) {
            score += 5;
        }
    });

    if (score >= 70) {
        return {
            level: 'High',
            score,
            pendingCount: pendingRequests.length,
            message: 'High-priority care is needed. Review the most urgent requests first.',
        };
    }

    if (score >= 40) {
        return {
            level: 'Medium',
            score,
            pendingCount: pendingRequests.length,
            message: 'The queue needs attention soon. Consider contacting the requester for updates.',
        };
    }

    return {
        level: 'Low',
        score,
        pendingCount: pendingRequests.length,
        message: 'Current pending requests are manageable and can be checked on a normal cadence.',
    };
}

function initRequesterPriority() {
    const container = document.getElementById('priority-insight');
    const data = document.getElementById('requester-priority-data');

    if (!container || !data) {
        return;
    }

    const requests = JSON.parse(data.textContent || '[]');
    const priority = calculatePriorityLevel(requests);
    const statusFocus = priority.pendingCount ? 'Pending queue' : 'No pending queue';

    container.innerHTML = `
        <div class="flex flex-col gap-3">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-sm font-semibold text-slate-900">Emergency priority detection</p>
                    <p class="text-sm text-slate-500">Local rule-based analysis for your latest pending requests</p>
                </div>
                <span class="rounded-full px-3 py-1 text-xs font-semibold ${priority.level === 'High' ? 'bg-red-100 text-red-700' : priority.level === 'Medium' ? 'bg-amber-100 text-amber-700' : 'bg-emerald-100 text-emerald-700'}">${priority.level}</span>
            </div>
            <p class="text-sm text-slate-600">${priority.message}</p>
            <div class="grid gap-3 sm:grid-cols-3">
                <div class="rounded-2xl bg-slate-50 px-4 py-3">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Score</p>
                    <p class="mt-2 text-lg font-semibold text-slate-900">${priority.score}</p>
                </div>
                <div class="rounded-2xl bg-slate-50 px-4 py-3">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Recent requests</p>
                    <p class="mt-2 text-lg font-semibold text-slate-900">${requests.length}</p>
                </div>
                <div class="rounded-2xl bg-slate-50 px-4 py-3">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Status focus</p>
                    <p class="mt-2 text-sm font-semibold text-slate-900">${statusFocus}</p>
                </div>
            </div>
        </div>
    `;

    if (priority.level === 'High' && typeof showLocalNotification === 'function') {
        showLocalNotification('Emergency priority detected', 'A high-priority request needs immediate attention.');
    }
}

export function initSmartFeatures() {
    if (document.documentElement.dataset.smartFeaturesLoaded === 'true') {
        return;
    }

    document.documentElement.dataset.smartFeaturesLoaded = 'true';

    initLocalNotifications();
    initHealthcareChatbot();
    initSearchIntelligence();
    initRequesterPriority();
}
