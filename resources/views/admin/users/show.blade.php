@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">User: {{ $user->name }}</h1>

    <div class="bg-white shadow rounded p-4">
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Role:</strong> {{ $user->role ?? 'N/A' }}</p>
        <p><strong>Created At:</strong> {{ $user->created_at }}</p>
    </div>

    <div class="mt-4">
        <a href="{{ route('admin.users.index') }}" class="text-blue-600">Back to users</a>
    </div>
</div>
@endsection
