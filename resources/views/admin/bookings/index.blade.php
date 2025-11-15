@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">Bookings</h1>
    @if($bookings->count())
        <table class="w-full table-auto">
            <thead>
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">User</th>
                    <th class="px-4 py-2">Tour</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookings as $booking)
                    <tr>
                        <td class="border px-4 py-2">{{ $booking->id }}</td>
                        <td class="border px-4 py-2">{{ optional($booking->user)->name }}</td>
                        <td class="border px-4 py-2">{{ optional($booking->tour)->name }}</td>
                        <td class="border px-4 py-2">{{ $booking->status }}</td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('admin.bookings.show', $booking) }}" class="text-blue-600">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">{{ $bookings->links() }}</div>
    @else
        <p>No bookings found.</p>
    @endif
</div>
@endsection
