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
                    ->after('tour_id');
            }

            // Jadikan tour_id nullable hanya jika kolomnya memang ada
            if (Schema::hasColumn('bookings', 'tour_id')) {
                // Hapus foreign key lama jika ada
                try {
                    $table->dropForeign(['tour_id']);
                } catch (\Throwable $e) {
                    // Jika constraint tidak ada, abaikan
                }

                $table->foreignId('tour_id')
                    ->nullable()
                    ->constrained()
                    ->onDelete('cascade')
                    ->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Rollback package_id jika ada
            if (Schema::hasColumn('bookings', 'package_id')) {
                try {
                    $table->dropForeign(['package_id']);
                } catch (\Throwable $e) {
                    // constraint mungkin belum ada, abaikan
                }
                $table->dropColumn('package_id');
            }

            // Kembalikan tour_id ke NOT NULL + constrained jika kolomnya ada
            if (Schema::hasColumn('bookings', 'tour_id')) {
                try {
                    $table->dropForeign(['tour_id']);
                } catch (\Throwable $e) {
                    // constraint mungkin belum ada, abaikan
                }

                $table->foreignId('tour_id')
                    ->constrained()
                    ->onDelete('cascade')
                    ->change();
            }
        });
    }
};
