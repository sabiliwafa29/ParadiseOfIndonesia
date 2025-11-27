@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow sm:rounded-lg p-6">

            <h2 class="text-2xl font-bold mb-6 text-center text-emerald-700">
                Booking {{ $service->name }}
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- 🗺️ PETA DI SEBELAH KIRI --}}
                <div id="map" class="h-[500px] w-full rounded-lg shadow-md"></div>

                {{-- 📋 FORM DETAIL BOOKING --}}
                <form action="{{ route('travel-services.confirm', $service) }}" method="POST" class="space-y-5">
                    @csrf

                    {{-- DETAIL UNIT --}}
                    <div class="bg-gray-100 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold">{{ $service->name }}</h3>
                        <p class="text-gray-600 mt-1">{{ $service->description }}</p>
                        <p class="text-gray-700 mt-2 font-bold">
                            {{ \App\Helpers\LanguageHelper::formatPrice( \App\Helpers\LanguageHelper::getPrice($service) ) }}
                        </p>
                    </div>

                    {{-- PICKUP LOCATION (Autocomplete) --}}
                    <div class="relative">
                        <label class="block font-semibold mb-2">Pickup Location</label>
                        <div class="relative">
                            <input id="pickup" type="text" 
                                placeholder="Search pickup location..."
                                class="w-full border border-gray-300 rounded-md p-2 focus:ring-emerald-500 focus:border-emerald-500"
                                autocomplete="off">
                            <div id="pickup-loading" class="absolute right-3 top-2 hidden">
                                <svg class="animate-spin h-5 w-5 text-emerald-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                        </div>
                        <div id="pickup-suggestions"
                            class="absolute bg-white border border-gray-300 rounded-md mt-1 w-full hidden max-h-48 overflow-y-auto z-50 shadow-lg"></div>
                    </div>

                    {{-- DESTINATION LOCATION (Autocomplete) --}}
                    <div class="relative">
                        <label class="block font-semibold mb-2">Destination</label>
                        <div class="relative">
                            <input id="destination" type="text" 
                                placeholder="Search destination..."
                                class="w-full border border-gray-300 rounded-md p-2 focus:ring-emerald-500 focus:border-emerald-500"
                                autocomplete="off">
                            <div id="destination-loading" class="absolute right-3 top-2 hidden">
                                <svg class="animate-spin h-5 w-5 text-emerald-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                        </div>
                        <div id="destination-suggestions"
                            class="absolute bg-white border border-gray-300 rounded-md mt-1 w-full hidden max-h-48 overflow-y-auto z-50 shadow-lg"></div>
                    </div>

                    {{-- Hidden fields untuk ID dan koordinat --}}
                    <input type="hidden" name="pickup_id" id="pickup_id">
                    <input type="hidden" name="destination_id" id="destination_id">
                    <input type="hidden" name="pickup_lat" id="pickup_lat">
                    <input type="hidden" name="pickup_lng" id="pickup_lng">
                    <input type="hidden" name="dest_lat" id="dest_lat">
                    <input type="hidden" name="dest_lng" id="dest_lng">

                    {{-- TIPE BOOKING --}}
                    <div>
                        <label class="block font-semibold mb-2">Booking Type</label>
                        <div class="flex space-x-4">
                            <label>
                                <input type="radio" name="booking_type" value="one-way" class="mr-2" checked> One Way
                            </label>
                            <label>
                                <input type="radio" name="booking_type" value="round-trip" class="mr-2"> Round Trip
                            </label>
                        </div>
                    </div>

                    {{-- JADWAL --}}
                    <div>
                        <label class="block font-semibold mb-2">Pickup Date & Time</label>
                        <div class="flex space-x-3">
                            <input type="date" name="schedule_date" class="border-gray-300 rounded-md w-1/2" required>
                            <input type="time" name="schedule_time" class="border-gray-300 rounded-md w-1/2" required>
                        </div>
                    </div>

                    {{-- JARAK ESTIMASI --}}
                    <div class="mt-4 text-gray-700">
                        <span class="font-semibold">Estimated Distance:</span>
                        <span id="distance" class="ml-2">-</span>
                    </div>

                    {{-- TOTAL HARGA --}}
                    <div class="mt-2 text-gray-700">
                        <span class="font-semibold">Estimated Price:</span>
                        <span id="total_price" class="ml-2 font-bold text-emerald-700">Rp 0</span>
                    </div>


                    {{-- TOMBOL --}}
                    <div class="text-center mt-6">
                        <button type="submit" 
                            class="bg-emerald-600 text-white px-6 py-2 rounded-md font-semibold hover:bg-emerald-700 transition">
                            Confirm Booking
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- 🌍 LEAFLET --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
const pricePerKm = {{ \App\Helpers\LanguageHelper::getPrice($service) }};

document.addEventListener("DOMContentLoaded", function () {
    const map = L.map('map').setView([-8.65, 115.22], 10);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    let routeLine = null; // Line untuk route visualization
    let pickupMarker = null;
    let destinationMarker = null;
    const distanceDisplay = document.getElementById('distance');
    const totalPriceDisplay = document.getElementById('total_price');

    // Debounce timer
    let searchTimeout = {};
    let distanceCalculationTimeout = null;

    // === Search Location via API (Database + Nominatim) ===
    async function searchLocation(query, type) {
        try {
            const response = await fetch(`/api/locations/search/${type}?q=${encodeURIComponent(query)}`);
            if (!response.ok) throw new Error('Search failed');
            const data = await response.json();
            return data.results || [];
        } catch (error) {
            return [];
        }
    }

    // === Create or get location ID ===
    async function createOrGetLocation(location, type) {
        // If location has ID (from database), return it
        if (location.id) {
            return location.id;
        }

        // If location from Nominatim, create or get from database
        try {
            const response = await fetch('/api/locations/create-or-get', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || document.querySelector('input[name="_token"]')?.value
                },
                body: JSON.stringify({
                    name: location.name,
                    lat: location.lat,
                    lon: location.lon,
                    type: type
                })
            });

            if (!response.ok) throw new Error('Failed to create location');
            const data = await response.json();
            return data.id;
        } catch (error) {
            return null;
        }
    }

    // === Fungsi set marker di map ===
    async function setMarker(type, lat, lon, name, locationId = null) {
        const icon = L.icon({
            iconUrl: type === 'pickup'
                ? 'https://cdn-icons-png.flaticon.com/512/684/684908.png'
                : 'https://cdn-icons-png.flaticon.com/512/149/149059.png',
            iconSize: [32, 32],
        });

        if (type === 'pickup') {
            if (pickupMarker) map.removeLayer(pickupMarker);
            pickupMarker = L.marker([lat, lon], { icon }).addTo(map).bindPopup(name);
            document.getElementById('pickup_lat').value = lat;
            document.getElementById('pickup_lng').value = lon;
            document.getElementById('pickup_id').value = locationId || '';
        } else {
            if (destinationMarker) map.removeLayer(destinationMarker);
            destinationMarker = L.marker([lat, lon], { icon }).addTo(map).bindPopup(name);
            document.getElementById('dest_lat').value = lat;
            document.getElementById('dest_lng').value = lon;
            document.getElementById('destination_id').value = locationId || '';
        }

        map.setView([lat, lon], 13);
        updateRoute();
    }

    // === Fungsi update rute & hitung jarak menggunakan OSRM API ===
    async function updateRoute() {
        // Clear previous route line
        if (routeLine) {
            map.removeLayer(routeLine);
            routeLine = null;
        }

        const pickupLat = parseFloat(document.getElementById('pickup_lat').value);
        const pickupLng = parseFloat(document.getElementById('pickup_lng').value);
        const destLat = parseFloat(document.getElementById('dest_lat').value);
        const destLng = parseFloat(document.getElementById('dest_lng').value);

        if (!pickupLat || !pickupLng || !destLat || !destLng) {
            distanceDisplay.textContent = '-';
            totalPriceDisplay.textContent = 'Rp 0';
            return;
        }

        // Clear previous timeout
        if (distanceCalculationTimeout) {
            clearTimeout(distanceCalculationTimeout);
        }

        // Debounce distance calculation
        distanceCalculationTimeout = setTimeout(async () => {
            try {
                // Show loading state
                distanceDisplay.textContent = 'Calculating...';

                // Call OSRM API
                const params = new URLSearchParams({
                    start_lat: pickupLat.toString(),
                    start_lng: pickupLng.toString(),
                    end_lat: destLat.toString(),
                    end_lng: destLng.toString()
                });

                const response = await fetch(`/api/distance/calculate?${params}`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                    }
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();

                if (data.success) {
                    const distance = data.data.distance;
                    const method = data.data.method;

                    // Update distance display
                    distanceDisplay.textContent = `${distance.toFixed(2)} km (${method})`;

                    // Calculate and update total price
                    const totalPrice = distance * pricePerKm;
                    totalPriceDisplay.textContent = "Rp " + totalPrice.toLocaleString('id-ID', { minimumFractionDigits: 0 });

                    // Draw route line on map (straight line for visualization)
                    routeLine = L.polyline([
                        [pickupLat, pickupLng],
                        [destLat, destLng]
                    ], {
                        color: 'green',
                        weight: 4,
                        opacity: 0.8
                    }).addTo(map);

                    // Fit map to show both markers and route
                    const group = new L.featureGroup([pickupMarker, destinationMarker, routeLine]);
                    map.fitBounds(group.getBounds().pad(0.1));

                } else {
                    throw new Error(data.message || 'Failed to calculate distance');
                }

            } catch (error) {
                distanceDisplay.textContent = 'Error calculating distance';
                totalPriceDisplay.textContent = 'Rp 0';

                // Fallback: draw straight line anyway for visualization
                routeLine = L.polyline([
                    [pickupLat, pickupLng],
                    [destLat, destLng]
                ], {
                    color: 'red',
                    weight: 3,
                    opacity: 0.6,
                    dashArray: '10, 10'
                }).addTo(map);
            }
        }, 500); // 500ms debounce
    }

    // === Autocomplete Handler ===
    function setupAutocomplete(inputId, suggestionsId, loadingId, type) {
        const input = document.getElementById(inputId);
        const suggestionsBox = document.getElementById(suggestionsId);
        const loadingIndicator = document.getElementById(loadingId);

        input.addEventListener('input', function () {
            const query = this.value.trim();
            
            // Clear previous timeout
            if (searchTimeout[type]) {
                clearTimeout(searchTimeout[type]);
            }

            if (query.length < 2) {
                suggestionsBox.classList.add('hidden');
                loadingIndicator.classList.add('hidden');
                return;
            }

            // Show loading
            loadingIndicator.classList.remove('hidden');
            suggestionsBox.classList.add('hidden');

            // Debounce: wait 500ms before searching
            searchTimeout[type] = setTimeout(async () => {
                try {
                    const results = await searchLocation(query, type);
                    suggestionsBox.innerHTML = '';
                    
                    if (results.length === 0) {
                        suggestionsBox.innerHTML = '<div class="p-3 text-sm text-gray-500 text-center">No locations found</div>';
                        suggestionsBox.classList.remove('hidden');
                        loadingIndicator.classList.add('hidden');
                        return;
                    }

                    results.forEach(place => {
                        const div = document.createElement('div');
                        div.className = 'p-3 hover:bg-emerald-50 cursor-pointer text-sm border-b border-gray-100 last:border-b-0';
                        
                        // Add source indicator
                        const sourceBadge = place.source === 'database' 
                            ? '<span class="text-xs bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded ml-2">DB</span>'
                            : '<span class="text-xs bg-blue-100 text-blue-700 px-2 py-0.5 rounded ml-2">Map</span>';
                        
                        div.innerHTML = `
                            <div class="font-medium">${place.display_name}</div>
                            ${sourceBadge}
                        `;
                        
                        div.onclick = async function () {
                            input.value = place.display_name;
                            suggestionsBox.classList.add('hidden');
                            loadingIndicator.classList.add('hidden');
                            
                            // Get or create location ID
                            const locationId = await createOrGetLocation(place, type);
                            
                            // Set marker with location ID
                            await setMarker(type, parseFloat(place.lat), parseFloat(place.lon), place.display_name, locationId);
                        };
                        
                        suggestionsBox.appendChild(div);
                    });

                    suggestionsBox.classList.remove('hidden');
                    loadingIndicator.classList.add('hidden');
                } catch (error) {
                    suggestionsBox.innerHTML = '<div class="p-3 text-sm text-red-500 text-center">Error loading locations. Please try again.</div>';
                    suggestionsBox.classList.remove('hidden');
                    loadingIndicator.classList.add('hidden');
                }
            }, 500);
        });

        // Tutup jika klik di luar
        document.addEventListener('click', (e) => {
            if (!suggestionsBox.contains(e.target) && e.target !== input && !loadingIndicator.contains(e.target)) {
                suggestionsBox.classList.add('hidden');
                loadingIndicator.classList.add('hidden');
            }
        });
    }

    // Aktifkan autocomplete untuk pickup & destination
    setupAutocomplete('pickup', 'pickup-suggestions', 'pickup-loading', 'pickup');
    setupAutocomplete('destination', 'destination-suggestions', 'destination-loading', 'destination');
});
</script>
@endsection