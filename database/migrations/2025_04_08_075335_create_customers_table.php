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
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
            $table->softDeletes(); // Thêm trường deleted_at để hỗ trợ Soft Deletes

            // Thêm các trường cho việc quản lý khách hàng
            $table->string('loyalty_card_number')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('gender')->nullable();
            $table->string('status')->default('active'); // Trạng thái khách hàng (active, inactive, blacklisted)
            $table->string('customer_type')->default('regular'); // Loại khách hàng (regular, premium, vip)
            $table->integer('loyalty_points')->default(0); // Điểm khách hàng
            $table->string('membership_level')->default('basic'); // Cấp độ thành viên (basic, silver, gold, platinum)
            $table->string('referral_code')->nullable(); // Mã giới thiệu
            $table->string('referral_source')->nullable(); // Nguồn giới thiệu
            $table->string('preferred_contact_method')->default('email'); // Phương thức liên hệ ưa thích (email, phone, sms)
            $table->string('preferred_language')->default('en'); // Ngôn ngữ ưa thích (en, vn, fr, es)
            $table->string('preferred_currency')->default('USD'); // Tiền tệ ưa thích (USD, VND, EUR)
            $table->text('notes')->nullable(); // Ghi chú cho khách hàng
            $table->string('profile_picture')->nullable(); // Hình ảnh đại diện
            $table->text('social_media_links')->nullable(); // Liên kết mạng xã hội
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
