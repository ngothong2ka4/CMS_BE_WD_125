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
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');
            $table->string('recipient_name');
            $table->string('email');
            $table->string('phone_number');
            $table->string('recipient_address');
            $table->text('note')->nullable();
            $table->decimal('total_payment',10,2);
            $table->integer('payment_role')->default(1)->comment('Phương thức thanh toán (1: COD, 2: VNPay, 3: MoMo)');
            $table->integer('status_payment')->default(1)->comment('Trạng thái thanh toán (1: Chưa thanh toán, 2: Đã thanh toán)');
            $table->integer('status')->default(1)->comment('Trạng thái đơn hàng (1: Chờ xác nhận, 2: Đã xác nhận, 3: Đang giao, 4: Giao hàng thành công, 5: Giao hàng thất bại, 6: Hoàn thành, 7: Đã hủy)');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order');
    }
};
