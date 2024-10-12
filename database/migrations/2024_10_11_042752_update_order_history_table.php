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
            $table->integer('from_status')->default(1)->comment('Trạng thái đơn hàng (1: Chờ xác nhận, 2: Đã xác nhận, 3: Đang giao, 4: Giao hàng thành công, 5: Giao hàng thất bại, 6: Hoàn thành, 7: Đã hủy)');
            $table->integer('to_status')->default(1)->comment('Trạng thái đơn hàng (1: Chờ xác nhận, 2: Đã xác nhận, 3: Đang giao, 4: Giao hàng thành công, 5: Giao hàng thất bại, 6: Hoàn thành, 7: Đã hủy)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_history', function (Blueprint $table) {
            //
        });
    }
};
