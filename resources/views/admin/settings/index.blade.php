@extends('layouts.admin')

@section('page-title', 'Settings')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- Header --}}
        <div class="mb-8">
            <div class="flex items-center space-x-3 mb-2">
                <div class="w-12 h-12 bg-gradient-to-br from-gray-600 to-gray-800 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Admin Settings</h1>
                    <p class="text-gray-600">Manage bookings, display preferences, and system settings</p>
                </div>
            </div>
        </div>

        {{-- Success/Error Messages --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-100 border-l-4 border-emerald-600 text-emerald-700 rounded-r-lg shadow">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-600 text-red-700 rounded-r-lg shadow">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            {{-- Booking Management Section --}}
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-red-500 to-rose-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Booking Management
                    </h2>
                    <p class="text-red-100 text-sm mt-1">Delete bookings by status or date</p>
                </div>

                <div class="p-6">
                    {{-- Booking Statistics --}}
                    <div class="grid grid-cols-3 gap-3 mb-6">
                        <div class="text-center p-3 bg-blue-50 rounded-lg">
                            <p class="text-2xl font-bold text-blue-600">{{ $bookingStats['total'] }}</p>
                            <p class="text-xs text-gray-600">Total</p>
                        </div>
                        <div class="text-center p-3 bg-yellow-50 rounded-lg">
                            <p class="text-2xl font-bold text-yellow-600">{{ $bookingStats['pending'] }}</p>
                            <p class="text-xs text-gray-600">Pending</p>
                        </div>
                        <div class="text-center p-3 bg-green-50 rounded-lg">
                            <p class="text-2xl font-bold text-green-600">{{ $bookingStats['confirmed'] }}</p>
                            <p class="text-xs text-gray-600">Confirmed</p>
                        </div>
                        <div class="text-center p-3 bg-emerald-50 rounded-lg">
                            <p class="text-2xl font-bold text-emerald-600">{{ $bookingStats['completed'] }}</p>
                            <p class="text-xs text-gray-600">Completed</p>
                        </div>
                        <div class="text-center p-3 bg-red-50 rounded-lg">
                            <p class="text-2xl font-bold text-red-600">{{ $bookingStats['cancelled'] }}</p>
                            <p class="text-xs text-gray-600">Cancelled</p>
                        </div>
                        <div class="text-center p-3 bg-gray-50 rounded-lg">
                            <p class="text-2xl font-bold text-gray-600">{{ $bookingStats['old_bookings'] }}</p>
                            <p class="text-xs text-gray-600">> 6 months</p>
                        </div>
                    </div>

                    {{-- Delete Form --}}
                    <form action="{{ route('admin.settings.delete-bookings') }}" method="POST" id="deleteBookingsForm">
                        @csrf
                        @method('DELETE')

                        <div class="space-y-4">
                            {{-- Delete Type --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Delete Type</label>
                                <select name="delete_type" id="deleteType" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                                    <option value="">Select delete option...</option>
                                    <option value="status">By Status</option>
                                    <option value="old">Old Bookings (by months)</option>
                                    <option value="all">Delete All Bookings</option>
                                </select>
                            </div>

                            {{-- Status Selection (shown when delete_type = status) --}}
                            <div id="statusField" class="hidden">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Select Status</label>
                                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                                    <option value="">Select status...</option>
                                    <option value="pending">Pending ({{ $bookingStats['pending'] }})</option>
                                    <option value="confirmed">Confirmed ({{ $bookingStats['confirmed'] }})</option>
                                    <option value="completed">Completed ({{ $bookingStats['completed'] }})</option>
                                    <option value="cancelled">Cancelled ({{ $bookingStats['cancelled'] }})</option>
                                </select>
                            </div>

                            {{-- Months Old Selection (shown when delete_type = old) --}}
                            <div id="monthsField" class="hidden">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Delete bookings older than</label>
                                <select name="months_old" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                                    <option value="3">3 months</option>
                                    <option value="6" selected>6 months</option>
                                    <option value="12">12 months</option>
                                    <option value="24">24 months</option>
                                </select>
                            </div>

                            {{-- Warning for delete all --}}
                            <div id="deleteAllWarning" class="hidden p-4 bg-red-100 border border-red-300 rounded-lg">
                                <div class="flex items-start">
                                    <svg class="w-6 h-6 text-red-600 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    <div>
                                        <p class="font-bold text-red-800">Warning: This action cannot be undone!</p>
                                        <p class="text-sm text-red-700">All {{ $bookingStats['total'] }} bookings will be permanently deleted.</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Confirmation --}}
                            <div class="flex items-center">
                                <input type="checkbox" name="confirm_delete" id="confirmDelete" class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500">
                                <label for="confirmDelete" class="ml-2 text-sm text-gray-700">
                                    I understand this action is <strong>permanent</strong> and cannot be undone.
                                </label>
                            </div>

                            {{-- Submit Button --}}
                            <button type="submit" id="deleteBtn" disabled
                                    class="w-full px-6 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Delete Bookings
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Display Settings Section --}}
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-500 to-teal-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Display Settings
                    </h2>
                    <p class="text-emerald-100 text-sm mt-1">Customize admin panel appearance</p>
                </div>

                <div class="p-6">
                    <form action="{{ route('admin.settings.update-display') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-5">
                            {{-- Items Per Page --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Items Per Page</label>
                                <select name="items_per_page" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                                    @foreach([10, 15, 20, 25, 50, 100] as $num)
                                        <option value="{{ $num }}" {{ ($displaySettings['items_per_page'] ?? 15) == $num ? 'selected' : '' }}>
                                            {{ $num }} items
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Default Currency --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Default Currency</label>
                                <select name="default_currency" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                                    <option value="USD" {{ ($displaySettings['default_currency'] ?? 'USD') == 'USD' ? 'selected' : '' }}>USD ($)</option>
                                    <option value="IDR" {{ ($displaySettings['default_currency'] ?? 'USD') == 'IDR' ? 'selected' : '' }}>IDR (Rp)</option>
                                    <option value="EUR" {{ ($displaySettings['default_currency'] ?? 'USD') == 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                                </select>
                            </div>

                            {{-- Date Format --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Date Format</label>
                                <select name="date_format" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                                    <option value="d/m/Y" {{ ($displaySettings['date_format'] ?? 'd M Y') == 'd/m/Y' ? 'selected' : '' }}>DD/MM/YYYY (31/12/2025)</option>
                                    <option value="m/d/Y" {{ ($displaySettings['date_format'] ?? 'd M Y') == 'm/d/Y' ? 'selected' : '' }}>MM/DD/YYYY (12/31/2025)</option>
                                    <option value="Y-m-d" {{ ($displaySettings['date_format'] ?? 'd M Y') == 'Y-m-d' ? 'selected' : '' }}>YYYY-MM-DD (2025-12-31)</option>
                                    <option value="d M Y" {{ ($displaySettings['date_format'] ?? 'd M Y') == 'd M Y' ? 'selected' : '' }}>DD Mon YYYY (31 Dec 2025)</option>
                                </select>
                            </div>

                            {{-- Theme Color --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Theme Color</label>
                                <div class="grid grid-cols-5 gap-3">
                                    @foreach(['emerald' => 'bg-emerald-500', 'blue' => 'bg-blue-500', 'purple' => 'bg-purple-500', 'red' => 'bg-red-500', 'orange' => 'bg-orange-500'] as $color => $bgClass)
                                        <label class="cursor-pointer">
                                            <input type="radio" name="theme_color" value="{{ $color }}" 
                                                   {{ ($displaySettings['theme_color'] ?? 'emerald') == $color ? 'checked' : '' }}
                                                   class="sr-only peer">
                                            <div class="w-full h-12 {{ $bgClass }} rounded-lg ring-2 ring-transparent peer-checked:ring-gray-800 peer-checked:ring-offset-2 transition flex items-center justify-center">
                                                <span class="text-white text-xs font-medium capitalize">{{ $color }}</span>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Sidebar Style --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Sidebar Style</label>
                                <div class="grid grid-cols-2 gap-3">
                                    <label class="cursor-pointer">
                                        <input type="radio" name="sidebar_style" value="default" 
                                               {{ ($displaySettings['sidebar_style'] ?? 'default') == 'default' ? 'checked' : '' }}
                                               class="sr-only peer">
                                        <div class="p-4 border-2 rounded-lg peer-checked:border-emerald-500 peer-checked:bg-emerald-50 transition">
                                            <p class="font-medium text-gray-800">Default</p>
                                            <p class="text-xs text-gray-500">Full width sidebar</p>
                                        </div>
                                    </label>
                                    <label class="cursor-pointer">
                                        <input type="radio" name="sidebar_style" value="compact" 
                                               {{ ($displaySettings['sidebar_style'] ?? 'default') == 'compact' ? 'checked' : '' }}
                                               class="sr-only peer">
                                        <div class="p-4 border-2 rounded-lg peer-checked:border-emerald-500 peer-checked:bg-emerald-50 transition">
                                            <p class="font-medium text-gray-800">Compact</p>
                                            <p class="text-xs text-gray-500">Icons only sidebar</p>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            {{-- Toggle Options --}}
                            <div class="space-y-3">
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div>
                                        <p class="font-medium text-gray-800">Enable Animations</p>
                                        <p class="text-xs text-gray-500">Smooth transitions and hover effects</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="enable_animations" value="1" 
                                               {{ ($displaySettings['enable_animations'] ?? true) ? 'checked' : '' }}
                                               class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-300 rounded-full peer peer-checked:bg-emerald-500 peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                                    </label>
                                </div>

                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div>
                                        <p class="font-medium text-gray-800">Show Stats Cards</p>
                                        <p class="text-xs text-gray-500">Display statistics on dashboard</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="show_stats_cards" value="1" 
                                               {{ ($displaySettings['show_stats_cards'] ?? true) ? 'checked' : '' }}
                                               class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-300 rounded-full peer peer-checked:bg-emerald-500 peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                                    </label>
                                </div>
                            </div>

                            {{-- Submit Button --}}
                            <button type="submit" 
                                    class="w-full px-6 py-3 bg-emerald-600 text-white font-semibold rounded-lg hover:bg-emerald-700 transition flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Save Display Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- System Actions --}}
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-slate-600 to-slate-800 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                        </svg>
                        System Actions
                    </h2>
                    <p class="text-slate-300 text-sm mt-1">Maintenance and system utilities</p>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        {{-- Clear Cache --}}
                        <form action="{{ route('admin.settings.clear-cache') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full p-4 border-2 border-gray-200 rounded-xl hover:border-blue-500 hover:bg-blue-50 transition group">
                                <div class="flex flex-col items-center">
                                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mb-3 group-hover:bg-blue-200 transition">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                        </svg>
                                    </div>
                                    <p class="font-semibold text-gray-800">Clear Cache</p>
                                    <p class="text-xs text-gray-500 mt-1">Clear all system cache</p>
                                </div>
                            </button>
                        </form>

                        {{-- View Logs --}}
                        <a href="{{ route('admin.bookings.index') }}" class="block p-4 border-2 border-gray-200 rounded-xl hover:border-purple-500 hover:bg-purple-50 transition group">
                            <div class="flex flex-col items-center">
                                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mb-3 group-hover:bg-purple-200 transition">
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <p class="font-semibold text-gray-800">View Bookings</p>
                                <p class="text-xs text-gray-500 mt-1">Manage all bookings</p>
                            </div>
                        </a>

                        {{-- Export Data --}}
                        <a href="{{ route('admin.bookings.export') }}" class="block p-4 border-2 border-gray-200 rounded-xl hover:border-green-500 hover:bg-green-50 transition group">
                            <div class="flex flex-col items-center">
                                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mb-3 group-hover:bg-green-200 transition">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <p class="font-semibold text-gray-800">Export Data</p>
                                <p class="text-xs text-gray-500 mt-1">Download booking data</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteType = document.getElementById('deleteType');
        const statusField = document.getElementById('statusField');
        const monthsField = document.getElementById('monthsField');
        const deleteAllWarning = document.getElementById('deleteAllWarning');
        const confirmDelete = document.getElementById('confirmDelete');
        const deleteBtn = document.getElementById('deleteBtn');
        const deleteForm = document.getElementById('deleteBookingsForm');

        // Toggle visibility based on delete type
        deleteType.addEventListener('change', function() {
            statusField.classList.add('hidden');
            monthsField.classList.add('hidden');
            deleteAllWarning.classList.add('hidden');

            switch(this.value) {
                case 'status':
                    statusField.classList.remove('hidden');
                    break;
                case 'old':
                    monthsField.classList.remove('hidden');
                    break;
                case 'all':
                    deleteAllWarning.classList.remove('hidden');
                    break;
            }
        });

        // Enable/disable delete button based on confirmation
        confirmDelete.addEventListener('change', function() {
            deleteBtn.disabled = !this.checked || !deleteType.value;
        });

        deleteType.addEventListener('change', function() {
            deleteBtn.disabled = !confirmDelete.checked || !this.value;
        });

        // Confirm before submit
        deleteForm.addEventListener('submit', function(e) {
            const type = deleteType.value;
            let message = 'Are you sure you want to delete these bookings?';
            
            if (type === 'all') {
                message = 'WARNING: This will delete ALL bookings permanently. Are you absolutely sure?';
            }

            if (!confirm(message)) {
                e.preventDefault();
            }
        });
    });
</script>
@endpush
@endsection
