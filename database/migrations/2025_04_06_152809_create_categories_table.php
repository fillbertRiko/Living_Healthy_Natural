<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->boolean('active')->default(true);
            $table->string('image')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
        });
    }

    public function down(): void {
        Schema::dropIfExists('categories');
    }
};
