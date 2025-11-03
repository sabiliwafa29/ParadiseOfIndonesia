<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Travel Pickup Map</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
    <style>
        #map { height: 90vh; width: 100%; border-radius: 12px; }
    </style>
</head>
<body class="bg-gray-100">

    <div id="map"></div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Peta awal diambil dari pickup pertama
            const map = L.map('map').setView([{{ $pickups->first()->latitude }}, {{ $pickups->first()->longitude }}], 10);

            // Layer peta
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            // Marker titik pickup
            @foreach($pickups as $pickup)
                L.marker([{{ $pickup->latitude }}, {{ $pickup->longitude }}])
                    .addTo(map)
                    .bindPopup("<b>{{ $pickup->name }}</b><br>{{ $pickup->description }}");
            @endforeach

            // Marker destinasi
            @foreach($pickoffdestinations as $dest)
                L.marker([{{ $dest->latitude }}, {{ $dest->longitude }}])
                    .addTo(map)
                    .bindPopup("<b>{{ $dest->name }}</b><br>{{ $dest->description }}");
            @endforeach

            // Tampilkan rute dari pickup pertama ke semua destinasi
            L.Routing.control({
                waypoints: [
                    L.latLng({{ $pickups->first()->latitude }}, {{ $pickups->first()->longitude }}),
                    @foreach($pickoffdestinations as $dest)
                        L.latLng({{ $dest->latitude }}, {{ $dest->longitude }}),
                    @endforeach
                ],
                lineOptions: {
                    styles: [{ color: 'green', weight: 5, opacity: 0.8 }]
                },
                createMarker: function() { return null; }
            }).addTo(map);
        });
    </script>

</body>
</html>
