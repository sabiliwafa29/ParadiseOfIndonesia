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
        Schema::create('tour_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name_id');
            $table->string('name_en');
            $table->string('name_zh');
            $table->text('description_id');
            $table->text('description_en');
            $table->text('description_zh');
            $table->decimal('price', 10, 2);
            $table->string('image')->nullable();
            $table->json('image_derivatives')->nullable();
            $table->boolean('includes_guide')->default(false);
            $table->boolean('includes_transport')->default(false);
            $table->json('itinerary')->nullable(); // Harus JSON
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_packages');
    }
};
