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
        Schema::create('ads_services', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->integer('location')->default(1)->comment('1: Phần trên, 2: Phần dưới');
            $table->string('duration');
            $table->decimal('price', 12)->nullable();;
            $table->timestamp('start')->nullable();
            $table->timestamp('end')->nullable();
            $table->integer('visits')->default(0);
            $table->integer('status')->default(1)->comment('1: Hoạt động, 2: Dừng hoạt động');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads_services');
    }
};
