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
            $table->foreignId('package_id')->nullable()->constrained('tour_packages')->onDelete('cascade')->after('tour_id');
            $table->dropForeign(['tour_id']);
            $table->foreignId('tour_id')->nullable()->change();
            $table->foreignId('tour_id')->constrained()->onDelete('cascade')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['package_id']);
            $table->dropColumn('package_id');
            $table->dropForeign(['tour_id']);
            $table->foreignId('tour_id')->constrained()->onDelete('cascade')->change();
        });
    }
};
