@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-md">

            <h2 class="text-2xl font-bold mb-4 text-center text-emerald-700">
                Booking Confirmation
            </h2>

            {{-- DETAIL TRAVEL SERVICE --}}
            <div class="bg-gray-100 p-4 rounded-lg mb-6">
                <h3 class="font-semibold text-lg">{{ $service->name }}</h3>
                <p class="text-gray-600">{{ $service->description }}</p>
                <p class="text-gray-800 font-bold mt-2">
                    {{ \App\Helpers\LanguageHelper::formatPrice( \App\Helpers\LanguageHelper::getPrice($service) ) }} / km
                </p>
            </div>

            {{-- DETAIL BOOKING --}}
            <div class="space-y-3">
                <p><strong>Pickup:</strong> {{ $pickup->name ?? '-' }}</p>
                <p><strong>Destination:</strong> {{ $destination->name ?? '-' }}</p>
                <p><strong>Distance:</strong> {{ $distance }} km</p>
                <p><strong>Booking Type:</strong> {{ ucfirst(str_replace('-', ' ', $booking->booking_type ?? 'one-way')) }}</p>

                @if (isset($booking->schedule_date) && isset($booking->schedule_time))
                    <p><strong>Schedule:</strong> {{ \Carbon\Carbon::parse($booking->schedule_date)->format('d M Y') }} at {{ $booking->schedule_time }}</p>
                @endif
                
                <p><strong>Total Price:</strong> 
                    <span class="text-emerald-700 font-bold text-lg">
                        {{ \App\Helpers\LanguageHelper::formatPrice( $booking->total_price ?? ($distance * \App\Helpers\LanguageHelper::getPrice($service)) ) }}
                    </span>
                </p>
            </div>

            <hr class="my-5">

            {{-- TOMBOL KONFIRMASI --}}
            <form action="{{ route('travel-services.pay', $service) }}" method="POST">
                @csrf
                <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                <div class="flex justify-center">
                    <button type="submit" class="bg-emerald-600 text-white px-6 py-2 rounded-md font-semibold hover:bg-emerald-700 transition">
                        Proceed to Payment
                    </button>
                </div>
            </form>

            {{-- Tombol kembali --}}
            <div class="text-center mt-4">
                <a href="{{ url()->previous() }}" class="text-emerald-600 hover:underline">
                    ← Go Back
                </a>
            </div>
        </div>
    </div>
</div>
@endsection