<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Make tour_id nullable (works on both PostgreSQL and MySQL)
        Schema::table('bookings', function (Blueprint $table) {
            $table->unsignedBigInteger('tour_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to NOT NULL (can error if null data exists)
        Schema::table('bookings', function (Blueprint $table) {
            $table->unsignedBigInteger('tour_id')->nullable(false)->change();
        });
    }
};
