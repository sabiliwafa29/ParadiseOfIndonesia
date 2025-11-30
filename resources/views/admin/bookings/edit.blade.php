@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-emerald-50 to-teal-50">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <h1 class="text-2xl font-bold text-gray-800">Edit Booking</h1>
                <a href="{{ route('admin.bookings.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-md">Back</a>
            </div>

            <form action="{{ route('admin.bookings.update', $booking) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Booking ID</label>
                        <p class="mt-1 text-sm text-gray-700">{{ $booking->id }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Customer</label>
                        <p class="mt-1 text-sm text-gray-700">{{ $booking->full_name ?? ($booking->user->name ?? 'Guest') }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" required class="mt-1 block w-full border-gray-300 rounded-md">
                            @php $statuses = ['pending','confirmed','completed','cancelled']; @endphp
                            @foreach($statuses as $s)
                                <option value="{{ $s }}" {{ (old('status', $booking->status) === $s) ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                        @error('status')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-emerald-600 text-white rounded-md">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
