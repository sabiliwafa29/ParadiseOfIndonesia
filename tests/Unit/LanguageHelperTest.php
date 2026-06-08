<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Helpers\LanguageHelper;
use App\Services\LocationService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class LanguageHelperTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
    }

    public function test_get_price_for_indonesian_user()
    {
        // Mock Indonesian IP
        Http::fake([
            'https://ipapi.co/127.0.0.1/json/' => Http::response([
                'country_code' => 'ID',
                'status' => 'success'
            ], 200),
        ]);

        $this->app['request']->server->set('REMOTE_ADDR', '127.0.0.1');

        // Mock model with different price fields
        $model = (object) [
            'price' => 100,
            'price_idr' => 1500000,
            'price_usd' => 100,
            'price_cny' => 700
        ];

        $price = LanguageHelper::getPrice($model);

        $this->assertEquals(1500000, $price);
    }

    public function test_get_price_for_chinese_user()
    {
        // Mock Chinese IP
        Http::fake([
            'https://ipapi.co/127.0.0.1/json/' => Http::response([
                'country_code' => 'CN',
                'status' => 'success'
            ], 200),
        ]);

        $this->app['request']->server->set('REMOTE_ADDR', '127.0.0.1');

        $model = (object) [
            'price' => 100,
            'price_idr' => 1500000,
            'price_usd' => 100,
            'price_cny' => 700
        ];

        $price = LanguageHelper::getPrice($model);

        $this->assertEquals(700, $price);
    }

    public function test_get_price_for_international_user()
    {
        // Mock US IP
        Http::fake([
            'https://ipapi.co/127.0.0.1/json/' => Http::response([
                'country_code' => 'US',
                'status' => 'success'
            ], 200),
        ]);

        $this->app['request']->server->set('REMOTE_ADDR', '127.0.0.1');

        $model = (object) [
            'price' => 100,
            'price_idr' => 1500000,
            'price_usd' => 100,
            'price_cny' => 700
        ];

        $price = LanguageHelper::getPrice($model);

        $this->assertEquals(100, $price);
    }

    public function test_get_price_fallback_to_general_price()
    {
        // Mock Indonesian IP
        Http::fake([
            'https://ipapi.co/127.0.0.1/json/' => Http::response([
                'country_code' => 'ID',
                'status' => 'success'
            ], 200),
        ]);

        $this->app['request']->server->set('REMOTE_ADDR', '127.0.0.1');

        // Model without specific currency fields
        $model = (object) [
            'price' => 200,
        ];

        $price = LanguageHelper::getPrice($model);

        $this->assertEquals(200, $price);
    }

    public function test_get_price_with_locale_override()
    {
        // Mock Indonesian IP, but override with Chinese locale
        Http::fake([
            'https://ipapi.co/127.0.0.1/json/' => Http::response([
                'country_code' => 'ID',
                'status' => 'success'
            ], 200),
        ]);

        $this->app['request']->server->set('REMOTE_ADDR', '127.0.0.1');

        $model = (object) [
            'price' => 100,
            'price_idr' => 1500000,
            'price_usd' => 100,
            'price_cny' => 700
        ];

        // Override with Chinese locale
        $price = LanguageHelper::getPrice($model, 'zh');

        $this->assertEquals(700, $price);
    }

    public function test_format_price_for_different_locales()
    {
        $this->assertEquals('Rp 1.500.000', LanguageHelper::formatPrice(1500000, 'id'));
        $this->assertEquals('$1,500.00', LanguageHelper::formatPrice(1500, 'en'));
        $this->assertEquals('¥1,500.00', LanguageHelper::formatPrice(1500, 'zh'));
    }

    public function test_get_currency_symbol()
    {
        $this->assertEquals('Rp', LanguageHelper::getCurrencySymbol('id'));
        $this->assertEquals('$', LanguageHelper::getCurrencySymbol('en'));
        $this->assertEquals('¥', LanguageHelper::getCurrencySymbol('zh'));
    }
}