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
        Schema::table('order', function (Blueprint $table) {
            $table->integer('payment_role')->default(1)->comment('Phương thức thanh toán (1: COD, 2: VNPay, 3: MoMo)')->change();
            $table->integer('status_payment')->default(1)->comment('Trạng thái thanh toán (1: Chờ xử lý, 2: Hoàn thành, 3: Hủy)')->change();
            $table->integer('status')->default(1)->comment('Trạng thái đơn hàng (1: Chờ xử lý, 2: Vận chuyển, 3: Giao hàng, 4: Hủy)')->change();
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
