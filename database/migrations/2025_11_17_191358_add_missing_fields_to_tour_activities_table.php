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
        Schema::table('tour_activities', function (Blueprint $table) {
            // Add missing fields for tour activities detail page
            $table->text('description')->nullable()->after('photo');
            $table->json('highlights')->nullable()->after('description');
            $table->json('what_to_bring')->nullable()->after('highlights');
            $table->text('notes')->nullable()->after('what_to_bring');
            
            // Make tour_id nullable since activities are standalone
            $table->foreignId('tour_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tour_activities', function (Blueprint $table) {
            $table->dropColumn(['description', 'highlights', 'what_to_bring', 'notes']);
        });
    }
};
