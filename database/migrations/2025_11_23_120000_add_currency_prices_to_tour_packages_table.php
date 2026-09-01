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
        // Add new currency columns if they don't exist
        Schema::table('tour_packages', function (Blueprint $table) {
            if (! Schema::hasColumn('tour_packages', 'price_idr')) {
                $table->decimal('price_idr', 15, 2)->nullable()->comment('Price in Indonesian Rupiah');
            }
            if (! Schema::hasColumn('tour_packages', 'price_usd')) {
                $table->decimal('price_usd', 15, 2)->nullable()->comment('Price in US Dollars');
            }
            if (! Schema::hasColumn('tour_packages', 'price_cny')) {
                $table->decimal('price_cny', 15, 2)->nullable()->comment('Price in Chinese Yuan (CNY)');
            }
        });

        // Backfill price_idr from existing price column when available
        if (Schema::hasColumn('tour_packages', 'price')) {
            DB::table('tour_packages')
                ->whereNotNull('price')
                ->update(['price_idr' => DB::raw('price')]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tour_packages', function (Blueprint $table) {
            if (Schema::hasColumn('tour_packages', 'price_cny')) {
                $table->dropColumn('price_cny');
            }
            if (Schema::hasColumn('tour_packages', 'price_usd')) {
                $table->dropColumn('price_usd');
            }
            if (Schema::hasColumn('tour_packages', 'price_idr')) {
                $table->dropColumn('price_idr');
            }
        });
    }
};
