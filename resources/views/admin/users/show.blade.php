@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-emerald-50 to-teal-50 py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <div class="lg:col-span-3">
                <div class="mb-6">
                    <h1 class="text-3xl font-bold text-gray-800">User: {{ $user->name }}</h1>
                </div>

                <div class="bg-white shadow rounded p-6">
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p class="mt-2"><strong>Role:</strong> {{ $user->role ?? 'N/A' }}</p>
                    <p class="mt-2"><strong>Created At:</strong> {{ $user->created_at }}</p>
                </div>
            </div>

            <aside class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow p-4 space-y-3">
                    <a href="{{ route('admin.users.edit', $user) }}" class="block w-full text-center px-4 py-2 bg-emerald-600 text-white rounded">Edit User</a>
                    <a href="{{ route('admin.users.index') }}" class="block w-full text-center px-4 py-2 border border-gray-200 rounded">Back to Users</a>
                </div>
            </aside>
        </div>
    </div>
</div>
@endsection
