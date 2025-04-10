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
            $table->timestamps();

            $table->foreign('parent_comment_id')->references('id')->on('comments')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('comments');
    }
};
