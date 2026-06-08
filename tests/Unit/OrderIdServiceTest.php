<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\OrderIdService;

class OrderIdServiceTest extends TestCase
{
    /** @test */
    public function it_generates_order_id_with_prefix()
    {
        $orderId = OrderIdService::generate('TEST');

        $this->assertIsString($orderId);
        $this->assertStringStartsWith('TEST-', $orderId);
    }

    /** @test */
    public function it_extracts_numeric_booking_id_when_present()
    {
        $id = OrderIdService::extractBookingId('BOOK-123');
        $this->assertEquals(123, $id);

        $id2 = OrderIdService::extractBookingId('BOOK-20251115-ABCDEF');
        // Implementation extracts numeric second segment if present
        $this->assertEquals(20251115, $id2);
    }
}
