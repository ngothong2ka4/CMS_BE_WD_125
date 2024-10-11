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
        Schema::table('order_history', function (Blueprint $table) {
            $table->enum('from_status',['Chờ xác nhận','Đã xác nhận','Đang giao','Giao hàng thành công','Giao hàng thất bại','Hoàn thành','Đã hủy'])->default('Chờ xác nhận');
            $table->enum('to_status',['Chờ xác nhận','Đã xác nhận','Đang giao','Giao hàng thành công','Giao hàng thất bại','Hoàn thành','Đã hủy'])->default('Chờ xác nhận');
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
