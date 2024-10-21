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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->integer('id_product')->nullable();
            $table->string('code')->unique();
            $table->integer('discount_type')->default(1)->comment('Loại giảm giá(1: Phần trăm, 2: Giá trị cố định)');
            $table->decimal('discount_value', 12, 0);
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('usage_limit');
            $table->integer('usage_per_user');
            $table->integer('status')->default(1)->comment('Trạng thái Voucher(1: Hoạt động, 2: Dừng hoạt động)');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voucher');
    }
};
