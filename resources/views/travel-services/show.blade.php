@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow sm:rounded-lg p-6">
            <h2 class="text-2xl font-bold mb-6">{{ $service->name }}</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- 🗺️ MAP DI KIRI --}}
                <div id="map" class="h-96 w-full rounded-lg"></div>

                {{-- 📋 DETAIL DI KANAN --}}
                <div>
                    <h3 class="text-xl font-semibold">{{ $service->name }}</h3>
                    <p class="text-gray-600 mt-2">{{ $service->description }}</p>

                    <div class="mt-4">
                        <span class="text-gray-700 font-semibold">Type:</span>
                        <span class="ml-2 bg-emerald-200 text-emerald-800 px-2 rounded-full text-xs uppercase">{{ $service->type }}</span>
                    </div>

                    <div class="mt-4">
                        <span class="text-gray-700 font-semibold">Price:</span>
                        <span class="ml-2 text-xl font-bold text-emerald-600">
                            {{ \App\Helpers\LanguageHelper::formatPrice( \App\Helpers\LanguageHelper::getPrice($service) ) }}
                        </span>
                    </div>

                    <div class="mt-4">
                        <span class="text-gray-700 font-semibold">Estimated Distance:</span>
                        <span class="ml-2 text-lg font-medium" id="distance">Calculating...</span>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('travel-services.index') }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300 transition">
                            ← Back to Services
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 🌍 LEAFLET --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const map = L.map('map').setView([-8.65, 115.22], 10);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Marker ikon khusus
    const pickupIcon = L.icon({
        iconUrl: '{{ asset("images/icons/pickup.png") }}',
        iconSize: [30, 30],
    });

    const destIcon = L.icon({
        iconUrl: '{{ asset("images/icons/destination.png") }}',
        iconSize: [30, 30],
    });

    // Pickup markers
    const pickups = @json($pickups);
    pickups.forEach(p => {
        L.marker([p.latitude, p.longitude], { icon: pickupIcon })
            .addTo(map)
            .bindPopup(`<b>${p.name}</b><br>${p.description}`);
    });

    // Destination markers
    const pickoffdestinations = @json($pickoffdestinations);
    pickoffdestinations.forEach(d => {
        L.marker([d.latitude, d.longitude], { icon: destIcon })
            .addTo(map)
            .bindPopup(`<b>${d.name}</b><br>${d.description}`);
    });

    // Hitung jarak terdekat antar titik (contoh: pickup pertama ke destinasi pertama)
    if (pickups.length && pickoffdestinations.length) {
        const latlng1 = L.latLng(pickups[0].latitude, pickups[0].longitude);
        const latlng2 = L.latLng(pickoffdestinations[0].latitude, pickoffdestinations[0].longitude);
        const distance = latlng1.distanceTo(latlng2) / 1000; // meter → km

        document.getElementById('distance').textContent = distance.toFixed(2) + ' km';

        // Tampilkan garis rute sederhana
        L.polyline([latlng1, latlng2], { color: 'blue' }).addTo(map);
        map.fitBounds([latlng1, latlng2]);
    }
});
</script>
@endsection
