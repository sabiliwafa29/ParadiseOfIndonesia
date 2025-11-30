<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tours', function (Blueprint $table) {
            if (!Schema::hasColumn('tours', 'min_guests')) {
                $table->integer('min_guests')->unsigned()->default(1)->after('duration');
            }
        });

        Schema::table('tour_packages', function (Blueprint $table) {
            if (!Schema::hasColumn('tour_packages', 'min_guests')) {
                $table->integer('min_guests')->unsigned()->default(1)->after('price_cny');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tours', function (Blueprint $table) {
            if (Schema::hasColumn('tours', 'min_guests')) {
                $table->dropColumn('min_guests');
            }
        });

        Schema::table('tour_packages', function (Blueprint $table) {
            if (Schema::hasColumn('tour_packages', 'min_guests')) {
                $table->dropColumn('min_guests');
            }
        });
    }
};
