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
        Schema::table('vouchers', function (Blueprint $table) {
            $table->integer('max_discount_amount')->nullable();
            $table->integer('user_voucher_limit')->default(1)->comment('Số người được phép sử dụng voucher(1: Tất cả; 2: Khoảng điểm; 3: Người cụ thể)');
            $table->integer('min_accumulated_points')->nullable()->default(0);
            $table->integer('max_accumulated_points')->nullable()->default(1000000000);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
