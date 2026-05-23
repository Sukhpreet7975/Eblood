export function initMobileMenu() {
    const menuBtn = document.getElementById('menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    if (!menuBtn || !mobileMenu) {
        return;
    }

    menuBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
        mobileMenu.classList.toggle('flex');
    });

    mobileMenu.querySelectorAll('a, button').forEach((link) => {
        link.addEventListener('click', () => {
            mobileMenu.classList.add('hidden');
            mobileMenu.classList.remove('flex');
        });
    });
}

export function initPageLoader() {
    const pageLoader = document.getElementById('page-loader');

    if (!pageLoader) {
        return;
    }

    pageLoader.classList.add('opacity-0');
    pageLoader.classList.remove('pointer-events-auto');
    setTimeout(() => pageLoader.remove(), 300);
}
