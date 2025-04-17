<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->unsignedTinyInteger('rating')->checkBetween(1, 5); // Đánh giá từ 1 đến 5
            $table->text('comment')->nullable();
            $table->timestamps();
            $table->softDeletes(); // Thêm trường deleted_at để hỗ trợ Soft Deletes

            // Thêm các trường cho việc quản lý đánh giá
            $table->boolean('verified')->default(false); // Đánh dấu đánh giá đã được xác thực
            $table->boolean('helpful')->default(false); // Đánh dấu đánh giá hữu ích
            $table->unsignedInteger('helpful_count')->default(0); // Số lượng người thấy đánh giá hữu ích
            $table->ipAddress('ip_address')->nullable(); // Địa chỉ IP của người dùng
            $table->string('user_agent')->nullable(); // Thông tin trình duyệt của người dùng
            $table->enum('review_type', ['text', 'video', 'image'])->default('text'); // Loại đánh giá (text, video, image)
            $table->string('review_image')->nullable(); // Ảnh đánh giá
            $table->string('review_video')->nullable(); // Video đánh giá
            $table->string('review_url')->nullable(); // URL đánh giá
            $table->string('review_title')->nullable(); // Tiêu đề đánh giá
            $table->enum('review_status', ['pending', 'approved', 'rejected'])->default('pending'); // Trạng thái đánh giá
            $table->text('review_response')->nullable(); // Phản hồi từ người quản lý
            $table->enum('review_response_status', ['pending', 'approved', 'rejected'])->default('pending'); // Trạng thái phản hồi
            $table->timestamp('review_response_time')->nullable(); // Thời gian phản hồi
            $table->foreignId('review_response_user_id')->nullable()->constrained('users')->nullOnDelete(); // ID người phản hồi

        });
    }

    public function down(): void {
        Schema::dropIfExists('reviews');
    }
};
