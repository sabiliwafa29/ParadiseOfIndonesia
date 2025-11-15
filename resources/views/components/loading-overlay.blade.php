{{-- Full Page Loading Overlay --}}
<div x-data="{ loading: false }" 
     @start-loading.window="loading = true" 
     @stop-loading.window="loading = false"
     x-show="loading"
     x-cloak
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm z-50 flex items-center justify-center"
     style="display: none;">
    
    <div class="bg-white rounded-2xl shadow-2xl p-8 flex flex-col items-center space-y-4">
        {{-- Animated Logo/Spinner --}}
        <div class="relative">
            <div class="w-16 h-16 border-4 border-emerald-200 rounded-full"></div>
            <div class="w-16 h-16 border-4 border-emerald-600 border-t-transparent rounded-full animate-spin absolute top-0 left-0"></div>
        </div>
        
        {{-- Loading Text --}}
        <div class="text-center">
            <h3 class="text-lg font-semibold text-gray-800 mb-1">Loading...</h3>
            <p class="text-sm text-gray-500">Please wait a moment</p>
        </div>
    </div>
</div>

{{-- Form Loading State --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Intercept all form submissions
        document.querySelectorAll('form:not([data-no-loading])').forEach(form => {
            form.addEventListener('submit', function() {
                window.dispatchEvent(new CustomEvent('start-loading'));
            });
        });

        // Intercept navigation links with data-loading attribute
        document.querySelectorAll('a[data-loading]').forEach(link => {
            link.addEventListener('click', function(e) {
                if (!e.ctrlKey && !e.metaKey) {
                    window.dispatchEvent(new CustomEvent('start-loading'));
                }
            });
        });

        // Stop loading on page load
        window.addEventListener('load', function() {
            window.dispatchEvent(new CustomEvent('stop-loading'));
        });
    });
</script>
