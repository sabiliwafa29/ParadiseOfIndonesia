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
        // 1. tour_packages: ensure price is nullable or has default
        Schema::table('tour_packages', function (Blueprint $table) {
            if (Schema::hasColumn('tour_packages', 'price')) {
                $table->decimal('price', 10, 2)->nullable()->default(0)->change();
            }
        });

        // 2. tour_activities: ensure time exists
        Schema::table('tour_activities', function (Blueprint $table) {
            if (!Schema::hasColumn('tour_activities', 'time')) {
                $table->string('time')->nullable()->after('name');
            }
        });

        // 3. users: ensure phone exists
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone', 50)->nullable()->after('role');
            }
        });

        // 4. bookings: ensure special_requests and reschedule_reason exist
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'special_requests')) {
                $table->text('special_requests')->nullable()->after('guests');
            }
            if (!Schema::hasColumn('bookings', 'reschedule_reason')) {
                $table->text('reschedule_reason')->nullable()->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'reschedule_reason')) {
                $table->dropColumn('reschedule_reason');
            }
            if (Schema::hasColumn('bookings', 'special_requests')) {
                $table->dropColumn('special_requests');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'phone')) {
                $table->dropColumn('phone');
            }
        });

        Schema::table('tour_activities', function (Blueprint $table) {
            if (Schema::hasColumn('tour_activities', 'time')) {
                $table->dropColumn('time');
            }
        });
    }
};
