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
            $table->integer('from_status')->default(1)->comment('Trạng thái đơn hàng (1: Chờ xử lý, 2: Vận chuyển, 3: Giao hàng, 4: Hủy)')->change();
            $table->integer('to_status')->default(1)->comment('Trạng thái đơn hàng (1: Chờ xử lý, 2: Vận chuyển, 3: Giao hàng, 4: Hủy)')->change();
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
