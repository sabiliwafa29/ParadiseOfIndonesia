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
            $table->unsignedInteger('min_guests')->nullable()->after('used_count');
            $table->unsignedInteger('max_guests')->nullable()->after('min_guests');
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
            $table->dropColumn(['min_guests', 'max_guests']);
        });
    }
};
