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
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->timestamp('payment_date')->useCurrent();
            $table->decimal('amount', 10, 2);
            $table->enum('payment_method', ['credit_card', 'paypal', 'bank_transfer', 'cash'])->default('cash');
            $table->enum('status', ['pending', 'completed', 'failed', 'refunded'])->default('pending');
            $table->timestamps();
            $table->softDeletes(); // Thêm trường deleted_at để hỗ trợ Soft Deletes
            // Thêm các trường cho việc quản lý thanh toán
            $table->string('transaction_id')->nullable(); // ID giao dịch từ cổng thanh toán
            $table->string('currency')->default('USD'); // Tiền tệ thanh toán
            $table->string('payment_gateway')->nullable(); // Cổng thanh toán (Stripe, PayPal, etc.)        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
