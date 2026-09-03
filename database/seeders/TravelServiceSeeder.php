<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TravelService;

class TravelServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'name' => 'Airport Transfer',
                'description' => 'Layanan antar jemput bandara dengan armada kendaraan premium. Tersedia untuk bandara di seluruh Indonesia termasuk Soekarno-Hatta, Ngurah Rai, Juanda, dan lainnya. Sopir profesional, kendaraan AC, dan layanan 24 jam.',
                'price' => 350000,
                'type' => 'Transport',
                'image' => 'images/services/airport-transfer.jpg',
            ],
            [
                'name' => 'Hotel Booking',
                'description' => 'Pemesanan hotel dengan harga terbaik di seluruh Indonesia. Tersedia dari hotel budget hingga resort bintang 5. Termasuk Bali, Yogyakarta, Lombok, Labuan Bajo, Raja Ampat, dan destinasi populer lainnya.',
                'price' => 500000,
                'type' => 'Accommodation',
                'image' => 'images/services/hotel-booking.jpg',
            ],
            [
                'name' => 'Car Rental',
                'description' => 'Sewa kendaraan dengan atau tanpa sopir untuk perjalanan wisata atau bisnis. Tersedia Avanza, Innova, Hiace, Elf, dan bus pariwisata. Armada terawat, AC, dan asuransi perjalanan.',
                'price' => 450000,
                'type' => 'Transport',
                'image' => 'images/services/car-rental.jpg',
            ],
            [
                'name' => 'Tour Guide Professional',
                'description' => 'Pemandu wisata berlisensi resmi dengan pengetahuan mendalam tentang budaya, sejarah, dan alam Indonesia. Tersedia dalam bahasa Indonesia, Inggris, Mandarin, Jepang, dan Korea.',
                'price' => 600000,
                'type' => 'Guide',
                'image' => 'images/services/tour-guide.jpg',
            ],
            [
                'name' => 'Fast Boat & Ferry',
                'description' => 'Tiket fast boat dan feri untuk destinasi pulau. Melayani rute Bali-Lombok, Bali-Nusa Penida, Labuan Bajo-Komodo, dan rute kepulauan lainnya. Termasuk asuransi perjalanan laut.',
                'price' => 250000,
                'type' => 'Transport',
                'image' => 'images/services/boat-ferry.jpg',
            ],
            [
                'name' => 'Flight Ticket Booking',
                'description' => 'Pemesanan tiket pesawat domestik dan internasional dengan harga kompetitif. Melayani semua maskapai termasuk Garuda, Lion Air, Batik Air, AirAsia, dan lainnya. Proses cepat dan e-ticket langsung.',
                'price' => 800000,
                'type' => 'Transport',
                'image' => 'images/services/flight-tickets.jpg',
            ],
            [
                'name' => 'Visa & Travel Document',
                'description' => 'Layanan pengurusan visa wisata dan bisnis untuk destinasi internasional. Termasuk visa Jepang, Korea, Schengen, Australia, China, dan lainnya. Konsultasi gratis dan proses terjamin.',
                'price' => 1500000,
                'type' => 'Document',
                'image' => 'images/services/visa-processing.jpg',
            ],
            [
                'name' => 'Travel Insurance',
                'description' => 'Asuransi perjalanan untuk wisatawan domestik dan mancanegara. Menanggung kecelakaan, kehilangan bagasi, pembatalan perjalanan, dan evakuasi medis. Tersedia paket individu dan grup.',
                'price' => 150000,
                'type' => 'Insurance',
                'image' => 'images/services/travel-insurance.jpg',
            ],
            [
                'name' => 'MICE & Event Organizer',
                'description' => 'Layanan Meeting, Incentive, Conference, dan Exhibition di destinasi premium Indonesia. Termasuk venue, catering, akomodasi, transportasi, dan team building. Paket all-in-one untuk korporat.',
                'price' => 5000000,
                'type' => 'Event',
                'image' => 'images/services/event-mice.jpg',
            ],
            [
                'name' => 'Custom Tour Package',
                'description' => 'Paket wisata custom sesuai kebutuhan Anda. Rancang itinerary sendiri atau konsultasi dengan tim kami. Tersedia untuk Bali, Komodo, Raja Ampat, Bromo, Ijen, Yogyakarta, dan destinasi lainnya.',
                'price' => 2500000,
                'type' => 'Package',
                'image' => 'images/services/custom-tour.jpg',
            ],
        ];

        foreach ($services as $service) {
            TravelService::updateOrCreate(
                ['name' => $service['name']],
                $service
            );
        }

        $this->command->info('Travel services seeded successfully!');
    }
}
