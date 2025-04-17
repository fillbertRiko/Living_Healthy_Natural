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
            $table->string('image')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Các trường bổ sung
            $table->string('sku')->nullable();
            $table->string('barcode')->nullable();
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('color')->nullable();
            $table->string('size')->nullable();
            $table->string('weight')->nullable();
            $table->string('dimensions')->nullable();
            $table->string('material')->nullable();
            $table->string('warranty')->nullable();
            $table->string('origin')->nullable();
            $table->string('tags')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();

            // Trạng thái
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_on_sale')->default(false);
            $table->boolean('is_new')->default(false);
        });
    }

    public function down(): void {
        Schema::dropIfExists('products');
    }
};
