@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- Header Section --}}
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Users</h1>
                    <p class="text-gray-600 mt-1">Manage registered users and their accounts</p>
                </div>
            </div>

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
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Users</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $users->total() }}</p>
                    </div>
                    <div class="bg-blue-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Verified Users</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $users->where('email_verified_at', '!=', null)->count() }}</p>
                    </div>
                    <div class="bg-green-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Admins</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $users->where('is_admin', true)->count() }}</p>
                    </div>
                    <div class="bg-purple-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">New This Month</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $users->where('created_at', '>=', now()->startOfMonth())->count() }}</p>
                    </div>
                    <div class="bg-yellow-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            {{-- Filter Section --}}
            <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex space-x-4">
                        <button onclick="filterUsers('all')" id="filter-all"
                                class="px-4 py-2 text-sm rounded-lg transition text-blue-700 bg-blue-100 font-semibold">
                            All Users
                        </button>
                        <button onclick="filterUsers('admin')" id="filter-admin"
                                class="px-4 py-2 text-sm rounded-lg transition text-gray-600 hover:bg-gray-100 font-medium">
                            Admins
                        </button>
                        <button onclick="filterUsers('verified')" id="filter-verified"
                                class="px-4 py-2 text-sm rounded-lg transition text-gray-600 hover:bg-gray-100 font-medium">
                            Verified
                        </button>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="relative">
                            <input type="text" 
                                   id="search-input"
                                   oninput="searchUsers()"
                                   placeholder="Search users..." 
                                   class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                let currentFilter = 'all';

                function filterUsers(filter) {
                    currentFilter = filter;
                    
                    document.querySelectorAll('[id^="filter-"]').forEach(btn => {
                        btn.className = 'px-4 py-2 text-sm rounded-lg transition text-gray-600 hover:bg-gray-100 font-medium';
                    });
                    document.getElementById('filter-' + filter).className = 'px-4 py-2 text-sm rounded-lg transition text-blue-700 bg-blue-100 font-semibold';
                    
                    applyFilters();
                }

                function searchUsers() {
                    applyFilters();
                }

                function applyFilters() {
                    const searchValue = document.getElementById('search-input').value.toLowerCase();
                    const users = document.querySelectorAll('.user-card');
                    
                    users.forEach(user => {
                        let matchesFilter = true;
                        let matchesSearch = true;
                        
                        if (currentFilter === 'admin') {
                            matchesFilter = user.dataset.admin === '1';
                        } else if (currentFilter === 'verified') {
                            matchesFilter = user.dataset.verified === '1';
                        }
                        
                        if (searchValue) {
                            const name = user.dataset.name.toLowerCase();
                            const email = user.dataset.email.toLowerCase();
                            matchesSearch = name.includes(searchValue) || email.includes(searchValue);
                        }
                        
                        if (matchesFilter && matchesSearch) {
                            user.style.display = 'block';
                        } else {
                            user.style.display = 'none';
                        }
                    });
                }
            </script>

            {{-- Users Grid --}}
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                    @forelse($users as $user)
                    <div class="user-card group bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-xl transition-all duration-300"
                         data-admin="{{ $user->is_admin ? '1' : '0' }}"
                         data-verified="{{ $user->email_verified_at ? '1' : '0' }}"
                         data-name="{{ $user->name }}"
                         data-email="{{ $user->email }}">
                        
                        {{-- User Card Content --}}
                        <div class="p-6">
                            <div class="flex items-start space-x-4">
                                {{-- Avatar --}}
                                <div class="flex-shrink-0">
                                    <div class="w-14 h-14 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center text-white font-bold text-xl">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                </div>

                                {{-- Info --}}
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center space-x-2 mb-1">
                                        <h3 class="text-lg font-bold text-gray-800 truncate group-hover:text-blue-600 transition">
                                            {{ $user->name }}
                                        </h3>
                                        @if($user->is_admin)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-purple-100 text-purple-700">
                                                Admin
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-500 truncate">{{ $user->email }}</p>
                                    
                                    @if($user->phone)
                                        <p class="text-sm text-gray-500 mt-1 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                            </svg>
                                            {{ $user->phone }}
                                        </p>
                                    @endif
                                </div>
                            </div>

                            {{-- Status Badges --}}
                            <div class="flex flex-wrap gap-2 mt-4">
                                @if($user->email_verified_at)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        Verified
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                        </svg>
                                        Pending
                                    </span>
                                @endif
                            </div>

                            {{-- Meta Info --}}
                            <div class="mt-4 pt-4 border-t border-gray-100 text-sm text-gray-500">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Joined {{ $user->created_at->format('M d, Y') }}
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="flex items-center space-x-2 mt-4 pt-4 border-t border-gray-100">
                                <a href="{{ route('admin.users.show', $user) }}" 
                                   class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition font-medium text-sm">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    View
                                </a>
                                <a href="{{ route('admin.users.edit', $user) }}" 
                                   class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-emerald-50 text-emerald-700 rounded-lg hover:bg-emerald-100 transition font-medium text-sm">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit
                                </a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full text-center py-16">
                        <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <h3 class="text-xl font-semibold text-gray-600 mb-2">No users found</h3>
                        <p class="text-gray-500">Users will appear here once they register</p>
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- Pagination --}}
            @if($users->hasPages())
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                {{ $users->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
