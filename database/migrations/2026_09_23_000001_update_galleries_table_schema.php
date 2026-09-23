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
        if (Schema::hasTable('galleries')) {
            Schema::table('galleries', function (Blueprint $table) {
                // Make destination_id nullable
                if (Schema::hasColumn('galleries', 'destination_id')) {
                    $table->foreignId('destination_id')->nullable()->change();
                }

                // Make name and path nullable if present
                if (Schema::hasColumn('galleries', 'name')) {
                    $table->string('name')->nullable()->change();
                }

                if (Schema::hasColumn('galleries', 'path')) {
                    $table->string('path')->nullable()->change();
                }

                // Add title if not present
                if (!Schema::hasColumn('galleries', 'title')) {
                    $table->string('title')->nullable()->after('destination_id');
                }

                // Add description if not present
                if (!Schema::hasColumn('galleries', 'description')) {
                    $table->text('description')->nullable()->after('title');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('galleries')) {
            Schema::table('galleries', function (Blueprint $table) {
                if (Schema::hasColumn('galleries', 'title')) {
                    $table->dropColumn('title');
                }
                if (Schema::hasColumn('galleries', 'description')) {
                    $table->dropColumn('description');
                }
            });
        }
    }
};
