<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('travel_service_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('travel_service_id')->constrained()->onDelete('cascade');
            $table->foreignId('pickup_id')->nullable()->constrained('pickups')->onDelete('set null');
            $table->foreignId('pickoff_destination_id')->nullable()->constrained('pickoff_destinations')->onDelete('set null');
            $table->string('booking_type'); // 'one-way' or 'round-trip'
            $table->date('schedule_date');
            $table->time('schedule_time');
            $table->decimal('distance', 10, 2)->nullable(); // in km
            $table->decimal('total_price', 10, 2);
            $table->string('status')->default('pending'); // pending, confirmed, cancelled
            $table->string('payment_id')->nullable();
            $table->string('payment_status')->nullable(); // pending, paid, failed
            $table->string('payment_method')->nullable();
            $table->string('order_id')->unique(); // Unique order ID for Midtrans
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel_service_bookings');
    }
};
