<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('order_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->timestamps();
            $table->softDeletes(); // Hỗ trợ Soft Deletes
            // Chỉ giữ lại các trường cần thiết
            $table->string('sku')->nullable(); // Mã sản phẩm
            $table->string('product_name')->nullable(); // Tên sản phẩm
            $table->string('product_image')->nullable(); // Ảnh sản phẩm
        });
    }

    public function down(): void {
        Schema::dropIfExists('order_items');
    }
};
