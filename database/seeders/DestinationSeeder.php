<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Destination;

class DestinationSeeder extends Seeder
{
    public function run()
    {
        $items = [
            [
                'name_id' => 'Surga Bali',
                'name_en' => 'Paradise of Bali',
                'name_zh' => '巴厘岛天堂',
                'slug' => 'bali',
                'description_id' => 'Bali: pulau dewata, terkenal dengan pantai, pura, dan budayanya.',
                'description_en' => 'Bali: the island of the gods, famous for beaches, temples and culture.',
                'description_zh' => '巴厘岛：众神之岛，以海滩、寺庙和文化闻名。',
                'location' => 'Bali, Indonesia',
                'image' => 'images/paradise-bali.webp',
                'featured' => true,
            ],
            [
                'name_id' => 'Surga Papua',
                'name_en' => 'Paradise of Papua',
                'name_zh' => '巴布亚天堂',
                'slug' => 'papua',
                'description_id' => 'Papua: Keindahan pulau Papua dari sudut yang jarang terekspos.',
                'description_en' => 'Papua: The beauty of Papua island from a rarely exposed POV.',
                'description_zh' => '巴布亚：从鲜为人知的角度欣赏巴布亚岛的美丽。',
                'location' => 'Papua, Indonesia',
                'image' => 'images/rajaAmpat.jpg',
                'featured' => true,
            ],
            [
                'name_id' => 'Surga Jawa Tengah & Yogyakarta',
                'name_en' => 'Paradise of Central Java and Yogyakarta',
                'name_zh' => '中爪哇和日惹天堂',
                'slug' => 'jawatengah-yogyakarta',
                'description_id' => 'Yogyakarta: pusat budaya dengan candi Borobudur dan Prambanan.',
                'description_en' => 'Yogyakarta: cultural heart with temples like Borobudur and Prambanan.',
                'description_zh' => '日惹：文化之心，拥有婆罗浮屠和普兰巴南等寺庙。',
                'location' => 'Java, Indonesia',
                'image' => 'images/tuguJogja.jpg',
                'featured' => true,
            ],
            [
                'name_id' => 'Surga Jawa Barat & Jakarta',
                'name_en' => 'Paradise of West Java and Jakarta',
                'name_zh' => '西爪哇和雅加达天堂',
                'slug' => 'jawabarat-jakarta',
                'description_id' => 'Jawa Barat: wisata alam dan kota metropolitan Jakarta.',
                'description_en' => 'West Java: natural attractions and the metropolitan city of Jakarta.',
                'description_zh' => '西爪哇：自然景点和大都市雅加达。',
                'location' => 'Java, Indonesia',
                'image' => 'images/pangandaran.jpg',
                'featured' => false,
            ],
            [
                'name_id' => 'Surga Lombok & Komodo',
                'name_en' => 'Paradise of Lombok and Komodo',
                'name_zh' => '龙目岛和科莫多天堂',
                'slug' => 'lombok-komodo',
                'description_id' => 'Lombok: Keindahan di Lombok yang tiada tanding.',
                'description_en' => 'Lombok: unmatched beauty in Lombok.',
                'description_zh' => '龙目岛：无与伦比的美丽。',
                'location' => 'Nusa Tenggara, Indonesia',
                'image' => 'images/senggigiBeach.jpg',
                'featured' => false,
            ],
            [
                'name_id' => 'Surga Jawa Timur',
                'name_en' => 'Paradise of East Java',
                'name_zh' => '东爪哇天堂',
                'slug' => 'east-java',
                'description_id' => 'Jawa Timur: Keindahan alam di sepanjang pulau Jawa Timur.',
                'description_en' => 'East Java: natural beauty along the island of East Java.',
                'description_zh' => '东爪哇：东爪哇岛的自然美景。',
                'location' => 'Java, Indonesia',
                'image' => 'images/blufireIjenCarter.webp',
                'featured' => false,
            ],
        ];

        foreach ($items as $i) {
            Destination::updateOrCreate(['slug' => $i['slug']], $i);
        }
    }
}
