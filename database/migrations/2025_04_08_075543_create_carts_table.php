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
        Schema::create('carts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes(); // Hỗ trợ Soft Deletes
            $table->string('session_id')->nullable(); // ID phiên làm việc
            $table->string('ip_address')->nullable(); // Địa chỉ IP của khách hàng
            $table->string('user_agent')->nullable(); // Thông tin trình duyệt của khách hàng
            $table->string('status')->default('active'); // Trạng thái giỏ hàng
            $table->unsignedInteger('total_items')->default(0); // Tổng số sản phẩm trong giỏ hàng
            $table->decimal('total_price', 10, 2)->default(0); // Tổng giá trị giỏ hàng
            $table->string('discount_code')->nullable(); // Mã giảm giá
            $table->decimal('discount_amount', 10, 2)->default(0); // Số tiền giảm giá
            $table->string('currency')->default('VND'); // Tiền tệ
            $table->string('shipping_method')->nullable(); // Phương thức vận chuyển
            $table->decimal('shipping_cost', 10, 2)->default(0); // Chi phí vận chuyển
            $table->string('payment_status')->default('pending'); // Trạng thái thanh toán
            $table->string('payment_method')->nullable(); // Phương thức thanh toán
            $table->text('shipping_address')->nullable(); // Địa chỉ giao hàng
            $table->text('billing_address')->nullable(); // Địa chỉ thanh toán
            $table->text('notes')->nullable(); // Ghi chú
            $table->text('gift_message')->nullable(); // Tin nhắn quà tặng
            $table->boolean('gift_wrap')->default(false); // Gói quà
            $table->unsignedInteger('loyalty_points_used')->default(0); // Điểm đã sử dụng
            $table->unsignedInteger('loyalty_points_earned')->default(0); // Điểm đã kiếm được
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
