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
        Schema::create('variants', function (Blueprint $table) {
            $table->id();
            $table->integer('id_product');
            $table->integer('id_attribute_color');
            $table->integer('id_attribute_size')->nullable();
            $table->decimal('import_price',12,2);
            $table->decimal('list_price',12,2);
            $table->decimal('selling_price',12,2);
            $table->string('image_color');
            $table->integer('quantity');
            $table->boolean('is_show')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variants');
    }
};
