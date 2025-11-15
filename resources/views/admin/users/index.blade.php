@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">Users</h1>

    @if($users->count())
        <ul>
            @foreach($users as $user)
                <li class="mb-2">
                    {{ $user->name }} - {{ $user->email }}
                    <a href="{{ route('admin.users.show', $user) }}" class="text-blue-600 ml-2">View</a>
                </li>
            @endforeach
        </ul>
        <div class="mt-4">{{ $users->links() }}</div>
    @else
        <p>No users found.</p>
    @endif
</div>
@endsection
