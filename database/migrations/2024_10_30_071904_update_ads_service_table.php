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
        Schema::table('ads_services', function (Blueprint $table) {
            $table->integer('status_payment')->after('status')->default(1)->comment('Trạng thái thanh toán (1: Chưa thanh toán, 2: Đã thanh toán)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
    }
};
