<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PickoffDestination;

class PickoffDestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $destinations = [
            // Bali Destinations
            [
                'name' => 'Ubud Palace',
                'description' => 'Cultural center of Bali, surrounded by temples and art markets',
                'latitude' => -8.5069,
                'longitude' => 115.2625,
            ],
            [
                'name' => 'Tanah Lot Temple',
                'description' => 'Iconic offshore temple and popular sunset spot',
                'latitude' => -8.6219,
                'longitude' => 115.0866,
            ],
            [
                'name' => 'Uluwatu Temple',
                'description' => 'Temple on the cliff with breathtaking ocean views and Kecak dance',
                'latitude' => -8.8287,
                'longitude' => 115.0840,
            ],
            [
                'name' => 'Tegallalang Rice Terrace',
                'description' => 'Famous rice terraces with stunning views',
                'latitude' => -8.4250,
                'longitude' => 115.2764,
            ],
            [
                'name' => 'Besakih Temple (Mother Temple)',
                'description' => 'Largest and holiest temple in Bali',
                'latitude' => -8.2744,
                'longitude' => 115.4500,
            ],
            [
                'name' => 'Tirta Empul Temple',
                'description' => 'Holy water temple for purification rituals',
                'latitude' => -8.4153,
                'longitude' => 115.3144,
            ],
            [
                'name' => 'Mount Batur',
                'description' => 'Active volcano with sunrise trekking',
                'latitude' => -8.2425,
                'longitude' => 115.3750,
            ],
            [
                'name' => 'Nusa Dua Beach',
                'description' => 'Luxury resort area with pristine beaches',
                'latitude' => -8.7833,
                'longitude' => 115.2167,
            ],
            [
                'name' => 'Waterbom Bali',
                'description' => 'Popular water park in Kuta',
                'latitude' => -8.7183,
                'longitude' => 115.1681,
            ],
            [
                'name' => 'Bali Safari & Marine Park',
                'description' => 'Wildlife park and conservation center',
                'latitude' => -8.5833,
                'longitude' => 115.2833,
            ],

            // Jakarta Destinations
            [
                'name' => 'National Monument (Monas)',
                'description' => 'Iconic landmark and symbol of Jakarta',
                'latitude' => -6.1751,
                'longitude' => 106.8650,
            ],
            [
                'name' => 'Istiqlal Mosque',
                'description' => 'Largest mosque in Southeast Asia',
                'latitude' => -6.1700,
                'longitude' => 106.8314,
            ],
            [
                'name' => 'Jakarta Cathedral',
                'description' => 'Historic Catholic cathedral',
                'latitude' => -6.1697,
                'longitude' => 106.8331,
            ],
            [
                'name' => 'Taman Mini Indonesia Indah',
                'description' => 'Cultural park showcasing Indonesian culture',
                'latitude' => -6.3022,
                'longitude' => 106.8950,
            ],
            [
                'name' => 'Ancol Dreamland',
                'description' => 'Entertainment complex with theme park and beach',
                'latitude' => -6.1250,
                'longitude' => 106.8333,
            ],
            [
                'name' => 'Ragunan Zoo',
                'description' => 'Largest zoo in Jakarta',
                'latitude' => -6.3133,
                'longitude' => 106.8081,
            ],

            // Yogyakarta Destinations
            [
                'name' => 'Borobudur Temple',
                'description' => 'Largest Buddhist temple in the world, UNESCO World Heritage',
                'latitude' => -7.6081,
                'longitude' => 110.2042,
            ],
            [
                'name' => 'Prambanan Temple',
                'description' => 'Largest Hindu temple in Indonesia, UNESCO World Heritage',
                'latitude' => -7.7520,
                'longitude' => 110.4915,
            ],
            [
                'name' => 'Keraton Yogyakarta',
                'description' => 'Royal palace of Yogyakarta Sultanate',
                'latitude' => -7.8050,
                'longitude' => 110.3644,
            ],
            [
                'name' => 'Taman Sari Water Castle',
                'description' => 'Historic royal garden and bathing complex',
                'latitude' => -7.8100,
                'longitude' => 110.3581,
            ],
            [
                'name' => 'Malioboro Street',
                'description' => 'Famous shopping street and cultural center',
                'latitude' => -7.7956,
                'longitude' => 110.3694,
            ],
            [
                'name' => 'Mount Merapi',
                'description' => 'Active volcano with jeep tours and trekking',
                'latitude' => -7.5407,
                'longitude' => 110.4456,
            ],

            // Bandung Destinations
            [
                'name' => 'Tangkuban Perahu',
                'description' => 'Active volcano crater with stunning views',
                'latitude' => -6.7700,
                'longitude' => 107.6000,
            ],
            [
                'name' => 'Kawah Putih',
                'description' => 'Beautiful white crater lake',
                'latitude' => -7.1667,
                'longitude' => 107.4000,
            ],
            [
                'name' => 'Dago Tea House',
                'description' => 'Scenic tea plantation with restaurant',
                'latitude' => -6.8500,
                'longitude' => 107.6167,
            ],
            [
                'name' => 'Braga Street',
                'description' => 'Historic street with colonial architecture',
                'latitude' => -6.9200,
                'longitude' => 107.6100,
            ],

            // Surabaya Destinations
            [
                'name' => 'House of Sampoerna',
                'description' => 'Historic cigarette factory and museum',
                'latitude' => -7.2333,
                'longitude' => 112.7333,
            ],
            [
                'name' => 'Surabaya Zoo',
                'description' => 'One of the oldest zoos in Indonesia',
                'latitude' => -7.3167,
                'longitude' => 112.7333,
            ],
            [
                'name' => 'Tugu Pahlawan',
                'description' => 'Heroes Monument commemorating Battle of Surabaya',
                'latitude' => -7.2458,
                'longitude' => 112.7378,
            ],

            // Medan Destinations
            [
                'name' => 'Maimun Palace',
                'description' => 'Royal palace of Deli Sultanate',
                'latitude' => 3.5750,
                'longitude' => 98.6833,
            ],
            [
                'name' => 'Great Mosque of Medan',
                'description' => 'Historic mosque with beautiful architecture',
                'latitude' => 3.5833,
                'longitude' => 98.6833,
            ],
            [
                'name' => 'Lake Toba',
                'description' => 'Largest volcanic lake in Indonesia',
                'latitude' => 2.6833,
                'longitude' => 98.8833,
            ],

            // Makassar Destinations
            [
                'name' => 'Fort Rotterdam',
                'description' => 'Historic Dutch fort and museum',
                'latitude' => -5.1333,
                'longitude' => 119.4167,
            ],
            [
                'name' => 'Losari Beach',
                'description' => 'Famous beach for sunset viewing',
                'latitude' => -5.1500,
                'longitude' => 119.4000,
            ],

            // Lombok Destinations
            [
                'name' => 'Mount Rinjani',
                'description' => 'Second highest volcano in Indonesia',
                'latitude' => -8.4167,
                'longitude' => 116.4667,
            ],
            [
                'name' => 'Gili Trawangan',
                'description' => 'Popular island destination for diving and beaches',
                'latitude' => -8.3500,
                'longitude' => 116.0333,
            ],
            [
                'name' => 'Gili Meno',
                'description' => 'Peaceful island with beautiful beaches',
                'latitude' => -8.3500,
                'longitude' => 116.0500,
            ],
            [
                'name' => 'Gili Air',
                'description' => 'Island with great snorkeling spots',
                'latitude' => -8.3500,
                'longitude' => 116.0833,
            ],
            [
                'name' => 'Sasak Village',
                'description' => 'Traditional Sasak cultural village',
                'latitude' => -8.5833,
                'longitude' => 116.1167,
            ],

            // Batam Destinations
            [
                'name' => 'Barelang Bridge',
                'description' => 'Iconic bridge connecting islands',
                'latitude' => 1.0167,
                'longitude' => 104.0167,
            ],
            [
                'name' => 'Nagoya Hill Shopping Mall',
                'description' => 'Largest shopping mall in Batam',
                'latitude' => 1.1167,
                'longitude' => 104.0167,
            ],
            [
                'name' => 'Maharani Zoo',
                'description' => 'Zoo and recreational park',
                'latitude' => 1.0833,
                'longitude' => 104.0167,
            ],
        ];

        foreach ($destinations as $destination) {
            PickoffDestination::updateOrCreate(
                ['name' => $destination['name']],
                $destination
            );
        }
    }
}
