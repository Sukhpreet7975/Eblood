const themeStorageKey = 'ebloodTheme';
const root = document.documentElement;
const buttonClass = 'js-dark-mode-toggle';
const iconClass = 'dark-mode-icon';

const getStoredTheme = () => {
    return localStorage.getItem(themeStorageKey);
};

const getPreferredTheme = () => {
    if(window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
        return 'dark';
    }

    return 'light';
};

const applyTheme = (theme) => {
    if(theme === 'dark') {
        root.classList.add('dark');
    } else {
        root.classList.remove('dark');
    }

    localStorage.setItem(themeStorageKey, theme);
    updateToggleButtons();
    window.dispatchEvent(new Event('themeChanged'));
};

const getTheme = () => {
    return root.classList.contains('dark') ? 'dark' : 'light';
};

const getToggleButtons = () => Array.from(document.querySelectorAll(`.${buttonClass}`));
const getToggleIcons = () => Array.from(document.querySelectorAll(`.${iconClass}`));

const setInitialTheme = () => {
    const storedTheme = getStoredTheme();
    const theme = storedTheme ?? getPreferredTheme();
    applyTheme(theme);
};

const updateToggleButtons = () => {
    const buttons = getToggleButtons();
    const icons = getToggleIcons();
    const isDark = getTheme() === 'dark';
    const iconMarkup = isDark
        ? '<path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" fill="currentColor" />'
        : '<circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.5" fill="none" /><line x1="12" y1="1" x2="12" y2="3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" /><line x1="12" y1="21" x2="12" y2="23" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" /><line x1="4.22" y1="4.22" x2="5.64" y2="5.64" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" /><line x1="18.36" y1="18.36" x2="19.78" y2="19.78" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" /><line x1="1" y1="12" x2="3" y2="12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" /><line x1="21" y1="12" x2="23" y2="12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" /><line x1="4.22" y1="19.78" x2="5.64" y2="18.36" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" /><line x1="18.36" y1="5.64" x2="19.78" y2="4.22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />';

    buttons.forEach(button => {
        button.setAttribute('aria-label', isDark ? 'Switch to light mode' : 'Switch to dark mode');
        button.classList.toggle('bg-white', !isDark);
        button.classList.toggle('bg-slate-900', isDark);
        button.classList.toggle('text-slate-900', !isDark);
        button.classList.toggle('text-slate-100', isDark);
        button.classList.toggle('border-slate-200', !isDark);
        button.classList.toggle('border-slate-700', isDark);
    });

    icons.forEach(icon => {
        icon.innerHTML = iconMarkup;
    });
};

const initThemeToggle = () => {
    const buttons = getToggleButtons();
    if (!buttons.length) {
        return;
    }

    buttons.forEach(button => {
        button.addEventListener('click', () => {
            applyTheme(getTheme() === 'dark' ? 'light' : 'dark');
            button.classList.add('rotate-90');
            setTimeout(() => button.classList.remove('rotate-90'), 300);
        });
    });

    updateToggleButtons();
};

setInitialTheme();

document.addEventListener('DOMContentLoaded', initThemeToggle);
