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
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
            $table->timestamps();
            $table->softDeletes(); // Thêm trường deleted_at để hỗ trợ Soft Deletes
            // Thêm các trường cho việc quản lý phiên làm việc
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
        Schema::dropIfExists('sessions');
    }
};
