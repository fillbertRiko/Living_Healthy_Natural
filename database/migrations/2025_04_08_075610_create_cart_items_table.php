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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('cart_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('price', 10, 2); // Giá sản phẩm
            $table->decimal('discount_price', 10, 2)->nullable(); // Giá giảm giá
            $table->string('currency')->default('VND'); // Tiền tệ
            $table->string('status')->default('active'); // Trạng thái sản phẩm trong giỏ hàng
            $table->string('product_name'); // Tên sản phẩm
            $table->string('product_sku')->nullable(); // SKU sản phẩm
            $table->string('product_image')->nullable(); // Hình ảnh sản phẩm
            $table->text('product_description')->nullable(); // Mô tả sản phẩm
            $table->timestamps();
            $table->softDeletes(); // Hỗ trợ Soft Deletes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
