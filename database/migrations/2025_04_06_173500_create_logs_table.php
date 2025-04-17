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
        Schema::create('logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Ai đã thực hiện hành động
            $table->text('action'); // Nội dung hành động
            $table->timestamps(); // Tạo cả created_at và updated_at
            $table->softDeletes(); // Thêm trường deleted_at để hỗ trợ Soft Deletes
            // Thêm các trường cho việc quản lý nhật ký
            $table->string('ip_address', 45)->nullable(); // Địa chỉ IP
            $table->string('user_agent')->nullable(); // Thông tin trình duyệt
            $table->string('device')->nullable(); // Thiết bị
            $table->string('browser')->nullable(); // Trình duyệt
            $table->string('platform')->nullable(); // Nền tảng
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};