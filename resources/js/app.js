import './bootstrap';

// Simple, CSP-safe navigation interactions without Alpine.js
document.addEventListener('DOMContentLoaded', () => {
    // Mega menu: Explore & Tours (hover)
    const megaContainers = document.querySelectorAll('[data-mega]');

    megaContainers.forEach((container) => {
        const key = container.getAttribute('data-mega');
        const toggle = container.querySelector(`[data-mega-toggle="${key}"]`);
        const panel = container.querySelector(`[data-mega-panel="${key}"]`);

        if (!toggle || !panel) return;

        let hoverTimeout = null;

        const open = () => {
            clearTimeout(hoverTimeout);
            panel.classList.remove('hidden');
            panel.classList.add('block');
            toggle.setAttribute('aria-expanded', 'true');
        };

        const close = () => {
            hoverTimeout = setTimeout(() => {
                panel.classList.add('hidden');
                panel.classList.remove('block');
                toggle.setAttribute('aria-expanded', 'false');
            }, 80);
        };

        container.addEventListener('mouseenter', open);
        container.addEventListener('mouseleave', close);
    });

    // Language dropdown (click)
    const langContainer = document.querySelector('[data-lang]');
    if (langContainer) {
        const langToggle = langContainer.querySelector('[data-lang-toggle]');
        const langPanel = langContainer.querySelector('[data-lang-panel]');

        if (langToggle && langPanel) {
            const closeLang = () => {
                langPanel.classList.add('hidden');
                langPanel.classList.remove('block');
                langToggle.setAttribute('aria-expanded', 'false');
            };

            const toggleLang = (e) => {
                e.stopPropagation();
                const isOpen = !langPanel.classList.contains('hidden');
                if (isOpen) {
                    closeLang();
                } else {
                    langPanel.classList.remove('hidden');
                    langPanel.classList.add('block');
                    langToggle.setAttribute('aria-expanded', 'true');
                }
            };

            langToggle.addEventListener('click', toggleLang);

            // Klik di luar menutup panel
            document.addEventListener('click', (e) => {
                if (!langContainer.contains(e.target)) {
                    closeLang();
                }
            });
        }
    }

    // Mobile menu (hamburger)
    const navToggle = document.querySelector('[data-nav-toggle]');
    const navMobile = document.querySelector('[data-nav-mobile]');
    if (navToggle && navMobile) {
        const iconMenu = navToggle.querySelector('.icon-menu');
        const iconClose = navToggle.querySelector('.icon-close');

        const updateIcons = (isOpen) => {
            if (!iconMenu || !iconClose) return;
            if (isOpen) {
                iconMenu.classList.add('hidden');
                iconClose.classList.remove('hidden');
                iconClose.classList.add('inline-flex');
            } else {
                iconClose.classList.add('hidden');
                iconMenu.classList.remove('hidden');
                iconMenu.classList.add('inline-flex');
            }
        };

        navToggle.addEventListener('click', () => {
            const isHidden = navMobile.classList.contains('hidden');
            if (isHidden) {
                navMobile.classList.remove('hidden');
                navMobile.classList.add('block');
                navToggle.setAttribute('aria-expanded', 'true');
            } else {
                navMobile.classList.add('hidden');
                navMobile.classList.remove('block');
                navToggle.setAttribute('aria-expanded', 'false');
            }
            updateIcons(isHidden);
        });
    }
});
