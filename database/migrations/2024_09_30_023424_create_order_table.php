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
            $table->date('order_date');
            $table->decimal('total_payment',10,2);
            $table->enum('payment_role',['Trả tiền khi nhận hàng','Thanh toán bằng ví điện tử / QR','Thanh Toán bằng MoMo'])->default('Trả tiền khi nhận hàng');
            $table->enum('status_payment',['Đang chờ xử lý','Đã hoàn thành','Đã hủy'])->default('Đang chờ xử lý');
            $table->enum('status',['Đang chờ xử lý','Đang vận chuyển','Đang chờ giao hàng','Đã hủy'])->default('Đang chờ xử lý');
            $table->timestamps();
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
