<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Logs;
use App\Models\Order;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    // Các thuộc tính có thể gán hàng loạt
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'avatar',
    ];

    // Các thuộc tính ẩn khi chuyển đổi thành mảng
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Chuyển đổi kiểu dữ liệu của thuộc tính
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Quan hệ: Một User có nhiều đơn hàng
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Kiểm tra vai trò
     */
    public function isSuperAdmin()
    {
        return $this->role === 'super_admin';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }

    /**
     * Phương thức boot để xử lý các sự kiện của model
     */
    public static function boot()
    {
        parent::boot();

        // Xử lý sự kiện "creating"
        static::creating(function ($user) {
            // Ngăn chặn tạo thêm tài khoản Super Admin
            if ($user->role === 'super_admin' && self::where('role', 'super_admin')->exists()) {
                throw new \Exception('Chỉ được phép có một tài khoản Super Admin trong hệ thống.');
            }

            // Ngăn chặn tạo tài khoản Admin trừ khi bởi Super Admin
            if ($user->role === 'admin' && Auth::user()?->role !== 'super_admin') {
                throw new \Exception('Chỉ Super Admin mới có thể tạo tài khoản Admin.');
            }
        });

        // Xử lý sự kiện "deleting"
        static::deleting(function ($user) {
            // Ngăn chặn xóa tài khoản Super Admin
            if ($user->role === 'super_admin') {
                throw new \Exception('Không thể xóa tài khoản Super Admin.');
            }
        });

        // Xử lý sự kiện "created"
        static::created(function ($user) {
            Logs::create([
                'user_id' => Auth::user()?->id,
                'action'  => "Đã tạo tài khoản: {$user->name} ({$user->role})",
            ]);
        });

        // Xử lý sự kiện "updated"
        static::updated(function ($user) {
            Logs::create([
                'user_id' => Auth::user()?->id,
                'action'  => "Đã cập nhật tài khoản: {$user->name} ({$user->role})",
            ]);
        });

        // Xử lý sự kiện "deleted"
        static::deleted(function ($user) {
            Logs::create([
                'user_id' => Auth::user()?->id,
                'action'  => "Đã xóa tài khoản: {$user->name} ({$user->role})",
            ]);
        });
    }
}
