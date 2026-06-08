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

        Schema::table('bookings', function (Blueprint $table) {
            // Tambah kolom contact info untuk booking paket / tour
            if (!Schema::hasColumn('bookings', 'full_name')) {
                $table->string('full_name')->nullable()->after('package_id');
            }

            if (!Schema::hasColumn('bookings', 'contact_handle')) {
                $table->string('contact_handle')->nullable()->after('full_name');
            }

            if (!Schema::hasColumn('bookings', 'email')) {
                $table->string('email')->nullable()->after('contact_handle');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'full_name')) {
                $table->dropColumn('full_name');
            }
            if (Schema::hasColumn('bookings', 'contact_handle')) {
                $table->dropColumn('contact_handle');
            }
            if (Schema::hasColumn('bookings', 'email')) {
                $table->dropColumn('email');
            }
        });
    }
};
