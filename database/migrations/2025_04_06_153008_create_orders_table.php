<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Người đặt hàng
            $table->timestamp('order_date')->useCurrent();
            $table->enum('status', ['pending', 'processing', 'shipped', 'delivered', 'canceled'])->default('pending');
            $table->decimal('total', 10, 2);
            $table->text('shipping_address');
            $table->timestamps();
            $table->softDeletes(); // Thêm trường deleted_at để hỗ trợ Soft Deletes
            $table->string('payment_method')->nullable(); // Phương thức thanh toán
            $table->string('tracking_number')->nullable(); // Số theo dõi đơn hàng
            $table->string('shipping_method')->nullable(); // Phương thức vận chuyển
            $table->decimal('shipping_cost', 10, 2)->nullable(); // Chi phí vận chuyển
            $table->string('billing_address')->nullable(); // Địa chỉ thanh toán
            $table->string('coupon_code')->nullable(); // Mã giảm giá
            $table->decimal('discount', 10, 2)->nullable(); // Giảm giá
            $table->text('notes')->nullable(); // Ghi chú
        });
    }

    public function down(): void {
        Schema::dropIfExists('orders');
    }
};
