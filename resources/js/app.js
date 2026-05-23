import './bootstrap';
import Alpine from 'alpinejs';
import { initNotificationCenter } from './shared/notifications';
import { initSmartFeatures } from './features/ai-features';
import { initTheme } from './shared/theme';
import { initMobileMenu, initPageLoader } from './shared/ui';

window.Alpine = Alpine;
Alpine.start();

initTheme();

document.addEventListener('DOMContentLoaded', () => {
    initMobileMenu();
    initNotificationCenter();
    initSmartFeatures();
});

window.addEventListener('load', initPageLoader);

