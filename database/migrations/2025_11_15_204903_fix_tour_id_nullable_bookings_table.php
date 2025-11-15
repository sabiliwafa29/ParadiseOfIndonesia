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
        // Use raw SQL untuk PostgreSQL karena Schema::table()->change() kadang tidak bekerja
        DB::statement('ALTER TABLE bookings ALTER COLUMN tour_id DROP NOT NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to NOT NULL (hati-hati, bisa error jika ada data dengan tour_id NULL)
        DB::statement('ALTER TABLE bookings ALTER COLUMN tour_id SET NOT NULL');
    }
};
