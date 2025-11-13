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
        Schema::create('tour_tour_package', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tour_package_id');
            $table->unsignedBigInteger('tour_id');
            $table->timestamps();

            $table->foreign('tour_package_id')
                ->references('id')
                ->on('tour_packages')
                ->onDelete('cascade');

            $table->foreign('tour_id')
                ->references('id')
                ->on('tours')
                ->onDelete('cascade');

            $table->unique(['tour_package_id', 'tour_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_package_tour');
    }
};