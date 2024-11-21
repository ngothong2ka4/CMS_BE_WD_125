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
        Schema::table('combo_products', function (Blueprint $table) {
            $table->unsignedBigInteger('id_variant')->nullable()->after('id_product');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('combo_products', function (Blueprint $table) {
            $table->dropColumn('id_variant');
        });
    }
};
