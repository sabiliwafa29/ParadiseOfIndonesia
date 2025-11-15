import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Ensure x-cloak works properly by starting Alpine
Alpine.start();

// Debug: Log when Alpine is ready
console.log('Alpine.js initialized');
