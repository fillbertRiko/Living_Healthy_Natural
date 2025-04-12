<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('quantity');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('image')->nullable(); // Thêm ảnh sản phẩm
            $table->timestamps();

            // Thêm 4 cột trạng thái dạng true/false
            $table->boolean('is_active')->default(true);   // Sản phẩm có hoạt động không?
            $table->boolean('is_featured')->default(false); // Sản phẩm nổi bật?
            $table->boolean('is_on_sale')->default(false); // Sản phẩm đang giảm giá?
            $table->boolean('is_new')->default(false); // Sản phẩm mới ra mắt?
        });
    }

    public function down(): void {
        Schema::dropIfExists('products');
    }
};
