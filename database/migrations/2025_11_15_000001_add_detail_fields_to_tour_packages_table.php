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
        Schema::table('tour_packages', function (Blueprint $table) {
            // Mirror detail fields from tours table
            $table->longText('itinerary')->nullable()->after('image');
            $table->text('includes')->nullable()->after('itinerary');
            $table->text('excludes')->nullable()->after('includes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tour_packages', function (Blueprint $table) {
            $table->dropColumn(['itinerary', 'includes', 'excludes']);
        });
    }
};
