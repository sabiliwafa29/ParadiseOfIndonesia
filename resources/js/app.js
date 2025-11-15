import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Navigation state factory for CSP-safe x-data
window.navState = function () {
    return {
        open: false,
        megaMenu: null,
        languageOpen: false,
    };
};

// Ensure x-cloak works properly by starting Alpine
Alpine.start();

console.log('Alpine.js initialized');
