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
        Schema::table('special_links', function (Blueprint $table) {
            $table->unsignedInteger('fixed_guests')->nullable()->after('max_guests');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('special_links', function (Blueprint $table) {
            $table->dropColumn('fixed_guests');
        });
    }
};
