@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">Booking #{{ $booking->id }}</h1>

    <div class="bg-white shadow rounded p-4">
        <p><strong>User:</strong> {{ optional($booking->user)->name }}</p>
        <p><strong>Tour:</strong> {{ optional($booking->tour)->name }}</p>
        <p><strong>Status:</strong> {{ $booking->status }}</p>
        <p><strong>Total Price:</strong> {{ $booking->total_price }}</p>
        <p><strong>Created At:</strong> {{ $booking->created_at }}</p>
    </div>

    <div class="mt-4">
        <a href="{{ route('admin.bookings.index') }}" class="text-blue-600">Back to bookings</a>
    </div>
</div>
@endsection
