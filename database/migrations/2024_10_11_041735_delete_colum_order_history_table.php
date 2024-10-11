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
            $table->dropColumn('from_status');  
            $table->dropColumn('to_status');
        
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_history', function (Blueprint $table) {
            $table->enum('from_status',['Đang chờ xử lý', 'Đang vận chuyển', 'Đang chờ giao hàng', 'Đã hủy'])->default('Đang chờ xử lý');
            $table->enum('to_status', ['Đang chờ xử lý', 'Đang vận chuyển', 'Đang chờ giao hàng', 'Đã hủy'])->default('Đang chờ xử lý');
    });
    }
};
