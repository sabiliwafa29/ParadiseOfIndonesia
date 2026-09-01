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
            $table->decimal('price_special_idr', 10, 2)->nullable();
            $table->decimal('price_special_usd', 10, 2)->nullable();
            $table->decimal('price_special_cny', 10, 2)->nullable();
            $table->dropColumn('price_special');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tour_packages', function (Blueprint $table) {
            $table->decimal('price_special', 10, 2)->nullable();
            $table->dropColumn(['price_special_idr', 'price_special_usd', 'price_special_cny']);
        });
    }
};
