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
            $table->dropColumn('status_payment');  
            $table->dropColumn('status');
        
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order', function (Blueprint $table) {
        $table->enum('status_payment',['Đang chờ xử lý','Đã hoàn thành','Đã hủy'])->default('Đang chờ xử lý');
        $table->enum('status',['Đang chờ xử lý','Đang vận chuyển','Đang chờ giao hàng','Đã hủy'])->default('Đang chờ xử lý');
    });
    }
};
