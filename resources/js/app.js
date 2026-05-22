import './bootstrap';
import './dark-mode';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Mobile menu toggle
document.addEventListener('DOMContentLoaded', function() {
    const menuBtn = document.getElementById('menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    if (menuBtn && mobileMenu) {
        menuBtn.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
            mobileMenu.classList.toggle('flex');
        });

        // Close menu when a link is clicked
        const menuLinks = mobileMenu.querySelectorAll('a, button');
        menuLinks.forEach(link => {
            link.addEventListener('click', function() {
                mobileMenu.classList.add('hidden');
                mobileMenu.classList.remove('flex');
            });
        });
    }
});

