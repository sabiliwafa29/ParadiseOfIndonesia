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
                            Rp {{ number_format($service->price, 0, ',', '.') }}
                        </p>
                    </div>

                    {{-- PICKUP LOCATION (Autocomplete) --}}
                    <div class="relative">
                        <label class="block font-semibold mb-2">Pickup Location</label>
                        <input id="pickup" type="text" name="pickup_name"
                            placeholder="Search pickup location..."
                            class="w-full border border-gray-300 rounded-md p-2 focus:ring-emerald-500 focus:border-emerald-500"
                            autocomplete="off">
                        <div id="pickup-suggestions"
                            class="absolute bg-white border border-gray-300 rounded-md mt-1 w-full hidden max-h-48 overflow-y-auto z-50"></div>
                    </div>

                    {{-- DESTINATION LOCATION (Autocomplete) --}}
                    <div class="relative">
                        <label class="block font-semibold mb-2">Destination</label>
                        <input id="destination" type="text" name="destination_name"
                            placeholder="Search destination..."
                            class="w-full border border-gray-300 rounded-md p-2 focus:ring-emerald-500 focus:border-emerald-500"
                            autocomplete="off">
                        <div id="destination-suggestions"
                            class="absolute bg-white border border-gray-300 rounded-md mt-1 w-full hidden max-h-48 overflow-y-auto z-50"></div>
                    </div>

                    {{-- Hidden untuk koordinat --}}
                    <input type="hidden" name="pickup_lat" id="pickup_lat">
                    <input type="hidden" name="pickup_lng" id="pickup_lng">
                    <input type="hidden" name="dest_lat" id="dest_lat">
                    <input type="hidden" name="dest_lng" id="dest_lng">

                    {{-- TIPE BOOKING --}}
                    <div>
                        <label class="block font-semibold mb-2">Booking Type</label>
                        <div class="flex space-x-4">
                            <label>
                                <input type="radio" name="booking_type" value="now" class="mr-2" checked> Book Now
                            </label>
                            <label>
                                <input type="radio" name="booking_type" value="later" class="mr-2"> Book for Later
                            </label>
                        </div>
                    </div>

                    {{-- JADWAL (Hanya muncul jika "Book for Later") --}}
                    <div id="schedule-fields" class="hidden">
                        <label class="block font-semibold mb-2">Pickup Date & Time</label>
                        <div class="flex space-x-3">
                            <input type="date" name="schedule_date" class="border-gray-300 rounded-md w-1/2">
                            <input type="time" name="schedule_time" class="border-gray-300 rounded-md w-1/2">
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
<script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>

<script>
const pricePerKm = {{ $service->price }};

document.addEventListener("DOMContentLoaded", function () {
    const map = L.map('map').setView([-8.65, 115.22], 10);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    let routeControl = null;
    let pickupMarker = null;
    let destinationMarker = null;
    const distanceDisplay = document.getElementById('distance');

    // === Fungsi Nominatim Search ===
    async function searchLocation(query) {
        const res = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&countrycodes=id`);
        return await res.json();
    }

    // === Fungsi set marker di map ===
    function setMarker(type, lat, lon, name) {
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
        } else {
            if (destinationMarker) map.removeLayer(destinationMarker);
            destinationMarker = L.marker([lat, lon], { icon }).addTo(map).bindPopup(name);
            document.getElementById('dest_lat').value = lat;
            document.getElementById('dest_lng').value = lon;
        }

        map.setView([lat, lon], 13);
        updateRoute();
    }

    // === Fungsi update rute & hitung jarak ===
    function updateRoute() {
        if (routeControl) map.removeControl(routeControl);

        const pickupLat = parseFloat(document.getElementById('pickup_lat').value);
        const pickupLng = parseFloat(document.getElementById('pickup_lng').value);
        const destLat = parseFloat(document.getElementById('dest_lat').value);
        const destLng = parseFloat(document.getElementById('dest_lng').value);

        if (!pickupLat || !destLat) return;

        // Buat routing
        routeControl = L.Routing.control({
            waypoints: [L.latLng(pickupLat, pickupLng), L.latLng(destLat, destLng)],
            addWaypoints: false,
            draggableWaypoints: false,
            routeWhileDragging: false,
            show: false,
            lineOptions: { styles: [{ color: 'green', opacity: 0.8, weight: 5 }] },
            createMarker: () => null
        }).addTo(map);

        // Hitung jarak dari koordinat (dalam km)
        const distance = map.distance([pickupLat, pickupLng], [destLat, destLng]) / 1000;
        distanceDisplay.textContent = distance.toFixed(2) + " km";

        // Hitung total harga
        const totalPrice = distance * pricePerKm;
        document.getElementById('total_price').textContent = 
            "Rp " + totalPrice.toLocaleString('id-ID', { minimumFractionDigits: 0 });
    }

    // === Autocomplete Handler ===
    function setupAutocomplete(inputId, suggestionsId, type) {
        const input = document.getElementById(inputId);
        const suggestionsBox = document.getElementById(suggestionsId);

        input.addEventListener('input', async function () {
            const query = this.value.trim();
            if (query.length < 3) {
                suggestionsBox.classList.add('hidden');
                return;
            }

            const results = await searchLocation(query);
            suggestionsBox.innerHTML = '';
            if (results.length === 0) {
                suggestionsBox.classList.add('hidden');
                return;
            }

            results.slice(0, 5).forEach(place => {
                const div = document.createElement('div');
                div.className = 'p-2 hover:bg-emerald-100 cursor-pointer text-sm';
                div.textContent = place.display_name;
                div.onclick = function () {
                    input.value = place.display_name;
                    suggestionsBox.classList.add('hidden');
                    setMarker(type, place.lat, place.lon, place.display_name);
                };
                suggestionsBox.appendChild(div);
            });

            suggestionsBox.classList.remove('hidden');
        });

        // Tutup jika klik di luar
        document.addEventListener('click', (e) => {
            if (!suggestionsBox.contains(e.target) && e.target !== input) {
                suggestionsBox.classList.add('hidden');
            }
        });
    }

    // Aktifkan autocomplete untuk pickup & destination
    setupAutocomplete('pickup', 'pickup-suggestions', 'pickup');
    setupAutocomplete('destination', 'destination-suggestions', 'destination');

    // === Toggle jadwal ===
    const radios = document.querySelectorAll('input[name="booking_type"]');
    const schedule = document.getElementById('schedule-fields');
    radios.forEach(r => {
        r.addEventListener('change', function () {
            if (this.value === 'later') schedule.classList.remove('hidden');
            else schedule.classList.add('hidden');
        });
    });
});
</script>
@endsection
