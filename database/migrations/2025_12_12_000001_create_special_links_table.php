<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('special_links', function (Blueprint $table) {
            $table->id();
            $table->string('token')->unique();
            $table->foreignId('tour_package_id')->constrained('tour_packages')->onDelete('cascade');
            $table->decimal('price_special_idr', 12, 2)->nullable();
            $table->decimal('price_special_usd', 12, 2)->nullable();
            $table->decimal('price_special_cny', 12, 2)->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->integer('max_uses')->nullable();
            $table->integer('used_count')->default(0);
            $table->text('note')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('special_links');
    }
};
