<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\MidtransService;

class MidtransServiceTest extends TestCase
{
    /** @test */
    public function test_connection_returns_array()
    {
        $service = new MidtransService();

        $result = $service->testConnection();

        $this->assertIsArray($result);
        $this->assertArrayHasKey('success', $result);
        $this->assertArrayHasKey('environment', $result);
    }
}
