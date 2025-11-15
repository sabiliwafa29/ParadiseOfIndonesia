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

    // User profile dropdown (desktop, top-right)
    const userDropdown = document.querySelector('[data-user-dropdown]');
    if (userDropdown) {
        const toggle = userDropdown.querySelector('[data-user-toggle]');
        const menu = userDropdown.querySelector('[data-user-menu]');

        if (toggle && menu) {
            const closeMenu = () => {
                menu.classList.add('hidden');
                menu.classList.remove('block');
                toggle.setAttribute('aria-expanded', 'false');
            };

            const openMenu = () => {
                menu.classList.remove('hidden');
                menu.classList.add('block');
                toggle.setAttribute('aria-expanded', 'true');
            };

            const toggleMenu = (e) => {
                e.stopPropagation();
                const isOpen = !menu.classList.contains('hidden');
                if (isOpen) {
                    closeMenu();
                } else {
                    openMenu();
                }
            };

            toggle.addEventListener('click', toggleMenu);

            document.addEventListener('click', (e) => {
                if (!userDropdown.contains(e.target)) {
                    closeMenu();
                }
            });
        }
    }

    // Hero slider (auto-rotate + dots) - vanilla JS, CSP-safe
    const heroSlider = document.querySelector('[data-hero-slider]');
    if (heroSlider) {
        const total = parseInt(heroSlider.getAttribute('data-hero-slider-count') || '0', 10);
        const slides = heroSlider.querySelectorAll('[data-hero-slide]');
        const dotsContainer = heroSlider.querySelector('[data-hero-dots]');
        const dots = dotsContainer ? dotsContainer.querySelectorAll('[data-hero-dot]') : [];

        if (total > 0 && slides.length === total) {
            let current = 0;
            let intervalId = null;

            const updateSlides = () => {
                slides.forEach((slide, index) => {
                    if (index === current) {
                        slide.classList.remove('hidden', 'opacity-0');
                        slide.classList.add('block', 'opacity-100');
                        slide.style.zIndex = '10';
                    } else {
                        slide.classList.add('hidden');
                        slide.classList.remove('block');
                        slide.style.zIndex = '0';
                    }
                });

                dots.forEach((dot, index) => {
                    if (index === current) {
                        dot.classList.remove('bg-white/40', 'w-12');
                        dot.classList.add('bg-white', 'w-16');
                    } else {
                        dot.classList.add('bg-white/40', 'w-12');
                        dot.classList.remove('bg-white', 'w-16');
                    }
                });
            };

            const goTo = (index) => {
                current = (index + total) % total;
                updateSlides();
            };

            const next = () => {
                goTo(current + 1);
            };

            const startAuto = () => {
                if (intervalId) return;
                intervalId = window.setInterval(next, 5000);
            };

            const stopAuto = () => {
                if (!intervalId) return;
                window.clearInterval(intervalId);
                intervalId = null;
            };

            // Initialize
            slides.forEach((slide, index) => {
                if (index !== 0) {
                    slide.classList.add('hidden');
                }
            });
            updateSlides();
            startAuto();

            // Dot navigation
            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    stopAuto();
                    goTo(index);
                    startAuto();
                });
            });

            // Pause on hover
            heroSlider.addEventListener('mouseenter', stopAuto);
            heroSlider.addEventListener('mouseleave', startAuto);
        }
    }
});
