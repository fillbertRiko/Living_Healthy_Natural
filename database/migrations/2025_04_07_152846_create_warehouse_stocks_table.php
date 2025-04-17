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
        Schema::create('warehouse_stocks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('warehouse_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->timestamps();
            $table->softDeletes(); // Thêm trường deleted_at để hỗ trợ Soft Deletes
            
            // Thêm các trường cho việc quản lý kho hàng
            $table->decimal('cost_price', 10, 2)->nullable();
            $table->decimal('selling_price', 10, 2)->nullable();
            $table->integer('reorder_level')->nullable();
            $table->integer('reorder_quantity')->nullable();
            $table->string('status')->default('active'); // Trạng thái kho hàng (active, inactive, out_of_stock)
            $table->decimal('discount_price', 10, 2)->nullable();
            $table->integer('minimum_order_quantity')->nullable();
            $table->integer('maximum_order_quantity')->nullable();
            $table->text('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouse_stocks');
    }
};
