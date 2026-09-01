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
        Schema::table('bookings', function (Blueprint $table) {
            // Tambah package_id hanya jika belum ada
            if (!Schema::hasColumn('bookings', 'package_id')) {
                $table->foreignId('package_id')
                    ->nullable()
                    ->constrained('tour_packages')
                    ->onDelete('cascade')
                    ;
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'package_id')) {
                try {
                    $table->dropForeign(['package_id']);
                } catch (\Throwable $e) {
                    // abaikan jika constraint belum ada
                }
                $table->dropColumn('package_id');
            }
        });
    }
};
