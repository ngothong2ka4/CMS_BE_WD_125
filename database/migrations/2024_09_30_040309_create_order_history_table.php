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
        Schema::create('order_history', function (Blueprint $table) {
            $table->id();
            $table->integer('id_order');
            $table->enum('from_status',['Đang chờ xử lý', 'Đang vận chuyển', 'Đang chờ giao hàng', 'Đã hủy'])->default('Đang chờ xử lý');
            $table->enum('to_status', ['Đang chờ xử lý', 'Đang vận chuyển', 'Đang chờ giao hàng', 'Đã hủy'])->default('Đang chờ xử lý');
            $table->string('note')->nullable();
            $table->integer('id_user');
            $table->timestamp('at_date_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_history');
    }
};
