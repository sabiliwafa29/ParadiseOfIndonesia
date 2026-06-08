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
        // Gallery
        if (Schema::hasTable('galleries')) {
            Schema::table('galleries', function (Blueprint $table) {
                if (!Schema::hasColumn('galleries', 'image_derivatives')) {
                    $table->json('image_derivatives')->nullable()->comment('JSON: {md: path, thumb: path}');
                }
            });
        }

        // Tours
        if (Schema::hasTable('tours')) {
            Schema::table('tours', function (Blueprint $table) {
                if (!Schema::hasColumn('tours', 'image_derivatives')) {
                    $table->json('image_derivatives')->nullable()->comment('JSON: {md: path, thumb: path}');
                }
            });
        }

        // Destinations
        if (Schema::hasTable('destinations')) {
            Schema::table('destinations', function (Blueprint $table) {
                if (!Schema::hasColumn('destinations', 'image_derivatives')) {
                    $table->json('image_derivatives')->nullable()->comment('JSON: {md: path, thumb: path}');
                }
            });
        }

        // TourPackages
        if (Schema::hasTable('tour_packages')) {
            Schema::table('tour_packages', function (Blueprint $table) {
                if (!Schema::hasColumn('tour_packages', 'image_derivatives')) {
                    $table->json('image_derivatives')->nullable()->comment('JSON: {md: path, thumb: path}');
                }
            });
        }

        // TravelServices
        if (Schema::hasTable('travel_services')) {
            Schema::table('travel_services', function (Blueprint $table) {
                if (!Schema::hasColumn('travel_services', 'image_derivatives')) {
                    $table->json('image_derivatives')->nullable()->comment('JSON: {md: path, thumb: path}');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = ['galleries', 'tours', 'destinations', 'tour_packages', 'travel_services'];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                Schema::table($table, function (Blueprint $table) {
                    if (Schema::hasColumn($table->getTable(), 'image_derivatives')) {
                        $table->dropColumn('image_derivatives');
                    }
                });
            }
        }
    }
};
