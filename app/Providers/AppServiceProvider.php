<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Đăng ký các dịch vụ hoặc binding tại đây
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Thiết lập độ dài mặc định cho chuỗi ký tự trong cơ sở dữ liệu
        Schema::defaultStringLength(191);
    }
}
