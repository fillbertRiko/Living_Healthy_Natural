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
        Schema::create('setting', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key')->unique();
            $table->text('value');
            $table->string('type')->default('string'); // Loại dữ liệu: string, integer, boolean, json
            $table->string('description')->nullable(); // Mô tả cho từng cài đặt
            $table->boolean('is_visible')->default(true); // Có hiển thị trong giao diện người dùng hay không
            $table->boolean('is_editable')->default(true); // Có thể chỉnh sửa hay không
            $table->boolean('is_required')->default(false); // Có bắt buộc hay không
            $table->boolean('is_default')->default(false); // Có phải là giá trị mặc định hay không
            $table->string('default_value')->nullable(); // Giá trị mặc định
            $table->string('group')->nullable(); // Nhóm cài đặt (ví dụ: general, seo, payment)
            $table->string('category')->nullable(); // Danh mục cài đặt (ví dụ: site, user, product)
            $table->string('section')->nullable(); // Phần cài đặt (ví dụ: header, footer, sidebar)
            $table->string('subsection')->nullable(); // Phân nhóm cài đặt (ví dụ: social, analytics, payment)
            $table->string('icon')->nullable(); // Biểu tượng cho cài đặt
            $table->string('image')->nullable(); // Hình ảnh cho cài đặt
            $table->string('url')->nullable(); // Đường dẫn liên kết cho cài đặt
            $table->string('color')->nullable(); // Màu sắc cho cài đặt
            $table->string('font')->nullable(); // Phông chữ cho cài đặt
            $table->string('size')->nullable(); // Kích thước cho cài đặt
            $table->string('style')->nullable(); // Kiểu dáng cho cài đặt
            $table->string('position')->nullable(); // Vị trí cho cài đặt
            $table->string('alignment')->nullable(); // Căn chỉnh cho cài đặt
            $table->string('animation')->nullable(); // Hiệu ứng cho cài đặt
            $table->string('transition')->nullable(); // Chuyển tiếp cho cài đặt
            $table->string('visibility')->nullable(); // Tính khả dụng cho cài đặt
            $table->string('access_level')->nullable(); // Cấp độ truy cập cho cài đặt
            $table->string('access_group')->nullable(); // Nhóm truy cập cho cài đặt
            $table->string('access_role')->nullable(); // Vai trò truy cập cho cài đặt
            $table->string('access_permission')->nullable(); // Quyền truy cập cho cài đặt
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
