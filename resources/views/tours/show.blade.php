@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Side - Tour Details -->
            <div class="lg:col-span-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <img src="{{ asset($tour->image) }}" alt="{{ $tour->name }}" class="w-full h-64 object-cover">
                    <div class="p-6">
                        <h1 class="text-3xl font-bold">{{ $tour->name }}</h1>
                        <p class="text-gray-600 mt-2">{{ $tour->destination->name }}</p>
                        
                        <!-- Key Information -->
                        <div class="mt-6 grid grid-cols-2 gap-4 bg-gray-50 p-4 rounded-lg">
                            <div>
                                <h3 class="font-semibold text-gray-600">Location</h3>
                                <p>{{ $tour->destination->location }}</p>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-600">Duration</h3>
                                <p>{{ $tour->duration }} days</p>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mt-6">
                            <h2 class="text-xl font-bold mb-3">Description</h2>
                            <div class="text-gray-700">{!! nl2br(e($tour->description)) !!}</div>
                        </div>

                        <!-- Facilities -->
                        @if($tour->includes)
                        <div class="mt-6">
                            <h2 class="text-xl font-bold mb-3">Facilities Included</h2>
                            <div class="grid grid-cols-2 gap-2">
                                @foreach(explode("\n", $tour->includes) as $facility)
                                    @if(trim($facility))
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>{{ trim($facility) }}</span>
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Itinerary -->
                        @if($tour->itinerary)
                        <div class="mt-6">
                            <h2 class="text-xl font-bold mb-4">Itinerary</h2>
                            <div class="space-y-4">
                                @foreach(explode("\n", $tour->itinerary) as $day => $activity)
                                    @if(trim($activity))
                                    <div class="flex gap-4 pb-4 border-b border-gray-100 last:border-0">
                                        <div class="flex-shrink-0 w-24">
                                            <span class="font-semibold text-emerald-600">Day {{ $day + 1 }}</span>
                                        </div>
                                        <div class="flex-grow">
                                            {{ $activity }}
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Side - Booking Details -->
            <div class="lg:col-span-1">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 sticky top-6">
                    <h2 class="text-xl font-bold mb-4">Book This Tour</h2>
                    <form action="{{ route('bookings.store', $tour) }}" method="POST" x-data="{ 
                        guests: 1,
                        basePrice: {{ $tour->price }},
                        guide: false,
                        transport: false,
                        get total() {
                            let total = this.basePrice * this.guests;
                            if (this.guide) total += 50 * this.guests;
                            if (this.transport) total += 30 * this.guests;
                            return total;
                        }
                    }">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Travel Date</label>
                                <input type="date" name="date" class="mt-1 block w-full rounded-md border-gray-300" required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Number of Guests</label>
                                <input type="number" name="guests" x-model="guests" min="1" class="mt-1 block w-full rounded-md border-gray-300" required>
                            </div>

                            <div class="border-t pt-4">
                                <h3 class="font-semibold mb-2">Additional Services</h3>
                                
                                <label class="flex items-center gap-2 mb-2">
                                    <input type="checkbox" name="guide" x-model="guide" class="rounded border-gray-300 text-emerald-600">
                                    <span>Tour Guide ($50 per person)</span>
                                </label>
                                
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" name="transport" x-model="transport" class="rounded border-gray-300 text-emerald-600">
                                    <span>Private Transport ($30 per person)</span>
                                </label>
                            </div>

                            <div class="border-t pt-4">
                                <div class="flex justify-between items-center font-semibold">
                                    <span>Total Price:</span>
                                    <span class="text-xl text-emerald-600" x-text="'$' + total.toLocaleString()"></span>
                                </div>
                            </div>

                            <button type="submit" class="w-full py-3 bg-emerald-600 text-white rounded-md font-semibold hover:bg-emerald-700 transition">
                                Book Now
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush
@endsection
