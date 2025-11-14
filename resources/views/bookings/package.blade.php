@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('tour-packages.show', $package) }}" class="inline-flex items-center text-emerald-600 hover:text-emerald-700 font-semibold">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                {{ __('messages.back_to_package') }}
            </a>
        </div>

        <!-- Package Info -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
            <div class="relative h-64">
                <img src="{{ asset($package->image) }}" alt="{{ $package->name }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                    <h1 class="text-3xl font-bold">{{ $package->name }}</h1>
                    <p class="text-xl mt-2 opacity-90">{{ $package->description }}</p>
                </div>
            </div>
            <div class="p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-600">{{ __('messages.package_price') }}</p>
                        <p class="text-3xl font-bold text-emerald-600">Rp {{ number_format($package->price, 0, ',', '.') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-gray-600">{{ __('messages.includes') }}</p>
                        <div class="flex space-x-4 mt-2">
                            @if($package->includes_guide)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-800">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ __('messages.guide') }}
                                </span>
                            @endif
                            @if($package->includes_transport)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-green-100 text-green-800">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ __('messages.transport') }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Form -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ __('messages.book_this_package') }}</h2>

            <form action="{{ route('bookings.store-package', $package) }}" method="POST" class="space-y-6">
                @csrf

                <!-- Date -->
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('messages.select_date') }}
                    </label>
                    <input type="date" id="date" name="date" value="{{ old('date') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                           required>
                    @error('date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Guests -->
                <div>
                    <label for="guests" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('messages.number_of_guests') }}
                    </label>
                    <select id="guests" name="guests"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                            required>
                        @for($i = 1; $i <= 50; $i++)
                            <option value="{{ $i }}" {{ old('guests') == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                    @error('guests')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Add-ons -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900">{{ __('messages.additional_services') }}</h3>

                    <!-- Guide Service -->
                    <div class="flex items-center">
                        <input type="checkbox" id="guide" name="guide" value="1" {{ old('guide') ? 'checked' : '' }}
                               class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded">
                        <label for="guide" class="ml-2 block text-sm text-gray-900">
                            <span class="font-medium">{{ __('messages.professional_tour_guide') }}</span>
                            <span class="text-gray-500">({{ __('messages.price_per_person') }}: Rp {{ number_format(config('booking.addon_prices.guide', 50), 0, ',', '.') }})</span>
                        </label>
                    </div>

                    <!-- Transport Service -->
                    <div class="flex items-center">
                        <input type="checkbox" id="transport" name="transport" value="1" {{ old('transport') ? 'checked' : '' }}
                               class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded">
                        <label for="transport" class="ml-2 block text-sm text-gray-900">
                            <span class="font-medium">{{ __('messages.private_transport') }}</span>
                            <span class="text-gray-500">({{ __('messages.price_per_person') }}: Rp {{ number_format(config('booking.addon_prices.transport', 30), 0, ',', '.') }})</span>
                        </label>
                    </div>
                </div>

                <!-- Price Summary -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('messages.price_summary') }}</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span>{{ __('messages.package_price') }}</span>
                            <span id="base-price">Rp {{ number_format($package->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between" id="guide-cost" style="display: none;">
                            <span>{{ __('messages.guide_service') }}</span>
                            <span id="guide-price">Rp 0</span>
                        </div>
                        <div class="flex justify-between" id="transport-cost" style="display: none;">
                            <span>{{ __('messages.transport_service') }}</span>
                            <span id="transport-price">Rp 0</span>
                        </div>
                        <hr class="my-2">
                        <div class="flex justify-between font-semibold text-lg">
                            <span>{{ __('messages.total') }}</span>
                            <span id="total-price" class="text-emerald-600">Rp {{ number_format($package->price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" class="px-8 py-3 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 transition">
                        {{ __('messages.book_now') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const guestsSelect = document.getElementById('guests');
        const guideCheckbox = document.getElementById('guide');
        const transportCheckbox = document.getElementById('transport');
        const basePrice = {{ $package->price }};
        const guidePricePerPerson = {{ config('booking.addon_prices.guide', 50) }};
        const transportPricePerPerson = {{ config('booking.addon_prices.transport', 30) }};

        function updatePrice() {
            const guests = parseInt(guestsSelect.value) || 1;
            const guideChecked = guideCheckbox.checked;
            const transportChecked = transportCheckbox.checked;

            const guideCost = guideChecked ? guidePricePerPerson * guests : 0;
            const transportCost = transportChecked ? transportPricePerPerson * guests : 0;
            const total = (basePrice * guests) + guideCost + transportCost;

            document.getElementById('base-price').textContent = 'Rp ' + (basePrice * guests).toLocaleString('id-ID');
            document.getElementById('guide-price').textContent = 'Rp ' + guideCost.toLocaleString('id-ID');
            document.getElementById('transport-price').textContent = 'Rp ' + transportCost.toLocaleString('id-ID');
            document.getElementById('total-price').textContent = 'Rp ' + total.toLocaleString('id-ID');

            document.getElementById('guide-cost').style.display = guideChecked ? 'flex' : 'none';
            document.getElementById('transport-cost').style.display = transportChecked ? 'flex' : 'none';
        }

        guestsSelect.addEventListener('change', updatePrice);
        guideCheckbox.addEventListener('change', updatePrice);
        transportCheckbox.addEventListener('change', updatePrice);

        // Initial calculation
        updatePrice();
    });
</script>
@endpush
