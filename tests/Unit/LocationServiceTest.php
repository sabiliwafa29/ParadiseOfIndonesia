<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\LocationService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class LocationServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        // Clear cache before each test
        Cache::flush();
    }

    public function test_detect_country_from_indonesian_ip()
    {
        // Mock IP detection API response for Indonesian IP
        Http::fake([
            'https://ipapi.co/192.168.1.1/json/' => Http::response([
                'country_code' => 'ID',
                'status' => 'success'
            ], 200),
        ]);

        // Mock request with Indonesian IP
        $this->app['request']->server->set('REMOTE_ADDR', '192.168.1.1');

        $country = LocationService::detectCountry();

        $this->assertEquals('ID', $country);
        $this->assertTrue(LocationService::isIndonesia());
        $this->assertEquals('domestic', LocationService::getUserMarket());
        $this->assertEquals('IDR', LocationService::getUserCurrency());
    }

    public function test_detect_country_from_chinese_ip()
    {
        // Mock IP detection API response for Chinese IP
        Http::fake([
            'https://ipapi.co/192.168.1.2/json/' => Http::response([
                'country_code' => 'CN',
                'status' => 'success'
            ], 200),
        ]);

        // Mock request with Chinese IP
        $this->app['request']->server->set('REMOTE_ADDR', '192.168.1.2');

        $country = LocationService::detectCountry();

        $this->assertEquals('CN', $country);
        $this->assertFalse(LocationService::isIndonesia());
        $this->assertEquals('international', LocationService::getUserMarket());
        $this->assertEquals('CNY', LocationService::getUserCurrency());
    }

    public function test_detect_country_from_hong_kong_ip()
    {
        // Mock IP detection API response for Hong Kong IP
        Http::fake([
            'https://ipapi.co/192.168.1.2/json/' => Http::response([
                'country_code' => 'HK',
                'status' => 'success'
            ], 200),
        ]);

        // Mock request with Hong Kong IP
        $this->app['request']->server->set('REMOTE_ADDR', '192.168.1.2');

        $country = LocationService::detectCountry();

        $this->assertEquals('HK', $country);
        $this->assertFalse(LocationService::isIndonesia());
        $this->assertEquals('international', LocationService::getUserMarket());
        $this->assertEquals('CNY', LocationService::getUserCurrency());
    }

    public function test_detect_country_from_international_ip()
    {
        // Mock IP detection API response for US IP
        Http::fake([
            'https://ipapi.co/192.168.1.3/json/' => Http::response([
                'country_code' => 'US',
                'status' => 'success'
            ], 200),
        ]);

        // Mock request with US IP
        $this->app['request']->server->set('REMOTE_ADDR', '192.168.1.3');

        $country = LocationService::detectCountry();

        $this->assertEquals('US', $country);
        $this->assertFalse(LocationService::isIndonesia());
        $this->assertEquals('international', LocationService::getUserMarket());
        $this->assertEquals('USD', LocationService::getUserCurrency());
    }

    public function test_fallback_to_ip_api_when_ipapi_fails()
    {
        // Mock ipapi.co to fail, ip-api.com to succeed
        Http::fake([
            'https://ipapi.co/192.168.1.4/json/' => Http::response('Service unavailable', 500),
            'http://ip-api.com/json/192.168.1.4?fields=countryCode,status' => Http::response([
                'countryCode' => 'SG',
                'status' => 'success'
            ], 200),
        ]);

        $this->app['request']->server->set('REMOTE_ADDR', '192.168.1.4');

        $country = LocationService::detectCountry();

        $this->assertEquals('SG', $country);
    }

    public function test_default_to_indonesia_for_private_ips()
    {
        // Private IP should default to Indonesia
        $this->app['request']->server->set('REMOTE_ADDR', '127.0.0.1');

        $country = LocationService::detectCountry();

        $this->assertEquals('ID', $country);
    }

    public function test_session_country_priority()
    {
        // Set session country
        session(['user_country' => 'JP']);

        // Even with different IP, should use session
        $this->app['request']->server->set('REMOTE_ADDR', '192.168.1.5');

        $country = LocationService::detectCountry();

        $this->assertEquals('JP', $country);
    }

    public function test_cache_functionality()
    {
        // Mock API response
        Http::fake([
            'https://ipapi.co/192.168.1.6/json/' => Http::response([
                'country_code' => 'AU',
                'status' => 'success'
            ], 200),
        ]);

        $this->app['request']->server->set('REMOTE_ADDR', '192.168.1.6');

        // First call should hit API
        $country1 = LocationService::detectCountry();
        $this->assertEquals('AU', $country1);

        // Second call should use cache
        Http::fake([]); // Clear fakes to ensure cache is used
        $country2 = LocationService::detectCountry();
        $this->assertEquals('AU', $country2);
    }

    public function test_country_name_lookup()
    {
        $this->assertEquals('Indonesia', LocationService::getCountryName('ID'));
        $this->assertEquals('China', LocationService::getCountryName('CN'));
        $this->assertEquals('United States', LocationService::getCountryName('US'));
        $this->assertEquals('Unknown', LocationService::getCountryName('XX'));
    }

    public function test_market_labels()
    {
        $this->assertEquals('Indonesia Only', LocationService::getMarketLabel('domestic'));
        $this->assertEquals('International Only', LocationService::getMarketLabel('international'));
        $this->assertEquals('All Markets', LocationService::getMarketLabel('both'));
    }
}