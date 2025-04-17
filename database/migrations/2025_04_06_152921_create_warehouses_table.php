<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('warehouses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('location');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes(); // Thêm trường deleted_at để hỗ trợ Soft Deletes

            // Thêm các trường cho việc quản lý kho
            $table->string('manager')->nullable(); // Người quản lý kho
            $table->string('contact_number')->nullable(); // Số điện thoại liên hệ
            $table->string('email')->nullable(); // Email liên hệ
            $table->string('address')->nullable(); // Địa chỉ kho
            $table->string('capacity')->nullable(); // Sức chứa kho
            $table->string('status')->default('active'); // Trạng thái kho (active, inactive)
            $table->string('meta_title')->nullable(); // Tiêu đề SEO
            $table->string('meta_description')->nullable(); // Mô tả SEO

            // Thêm 4 cột trạng thái dạng true/false
            $table->boolean('is_active')->default(true);   // Kho có hoạt động không?
            $table->boolean('is_featured')->default(false); // Kho nổi bật?
            $table->boolean('is_on_sale')->default(false); // Kho đang giảm giá?
            $table->boolean('is_new')->default(false); // Kho mới ra mắt?

            // Thêm các trường khác
            $table->string('sku')->nullable(); // Mã kho
            $table->string('barcode')->nullable(); // Mã vạch kho
            $table->string('brand')->nullable(); // Thương hiệu kho
            $table->string('model')->nullable(); // Mẫu kho
            $table->string('color')->nullable(); // Màu sắc kho
            $table->string('size')->nullable(); // Kích thước kho
            $table->string('weight')->nullable(); // Trọng lượng kho
            $table->string('dimensions')->nullable(); // Kích thước kho
            $table->string('material')->nullable(); // Chất liệu kho
            $table->string('warranty')->nullable(); // Bảo hành kho
            $table->string('origin')->nullable(); // Xuất xứ kho
            $table->string('tags')->nullable(); // Thẻ kho
            $table->string('image')->nullable(); // Ảnh kho
            $table->string('slug')->unique(); // Thêm slug
        });
    }

    public function down(): void {
        Schema::dropIfExists('warehouses');
    }
};
