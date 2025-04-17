<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('parent_comment_id')->nullable();
            $table->text('content');
            $table->boolean('is_approved')->default(false);
            $table->integer('likes_count')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('parent_comment_id')->references('id')->on('comments')->onDelete('cascade');

            // Additional fields for comment management
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->boolean('is_spam')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->string('comment_type')->default('text');
            $table->string('comment_image')->nullable();
            $table->string('comment_video')->nullable();
            $table->string('comment_url')->nullable();
            $table->string('comment_title')->nullable();
            $table->enum('comment_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('comment_response')->nullable();
            $table->enum('comment_response_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamp('comment_response_time')->nullable();
            $table->foreignId('comment_response_user_id')->nullable()->constrained('users')->nullOnDelete();

            // Additional fields for analytics
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_helpful')->default(false);
            $table->integer('helpful_count')->default(0);
            $table->string('comment_language')->default('en');
            $table->string('comment_location')->nullable();
            $table->string('comment_device')->nullable();
            $table->string('comment_platform')->nullable();
            $table->string('comment_timezone')->nullable();
        });
    }

    public function down(): void {
        Schema::dropIfExists('comments');
    }
};
