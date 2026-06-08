<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            // Rename existing price column to USD
            $table->renameColumn('price', 'price_usd');
            
            // Add new currency columns
            $table->decimal('price_idr', 15, 2)->nullable()->comment('Price in Indonesian Rupiah');
            $table->decimal('price_cny', 15, 2)->nullable()->comment('Price in Chinese Yuan (Renminbi)');
            
            // Add currency exchange rate columns (optional, for auto-conversion)
            $table->decimal('exchange_rate_idr', 10, 2)->default(15000)->comment('USD to IDR rate');
            $table->decimal('exchange_rate_cny', 10, 2)->default(6.5)->comment('USD to CNY rate');
        });
    }

    public function down(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->renameColumn('price_usd', 'price');
            $table->dropColumn(['price_idr', 'price_cny', 'exchange_rate_idr', 'exchange_rate_cny']);
        });
    }
};