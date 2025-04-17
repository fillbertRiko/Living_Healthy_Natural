<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Logs;
use App\Models\Order;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Quan hệ: Một User có nhiều đơn hàng
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Kiểm tra quyền
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

    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            // Kiểm tra nếu đã có Super Admin, ngăn chặn tạo thêm
            if ($user->role === 'super_admin' && self::where('role', 'super_admin')->exists()) {
                throw new \Exception('Hệ thống chỉ cho phép một tài khoản Super Admin.');
            }

            // Ngăn chặn tạo admin nếu không phải Super Admin
            if ($user->role === 'admin' && Auth::user()?->role !== 'super_admin') {
                throw new \Exception('Chỉ Super Admin mới có quyền tạo Admin.');
            }
        });

        static::deleting(function ($user) {
            // Ngăn chặn xóa tài khoản Super Admin
            if ($user->role === 'super_admin') {
                throw new \Exception('Không thể xóa Super Admin.');
            }
        });

        // Ghi log khi tạo tài khoản
        static::created(function ($user) {
            Logs::create([
                'user_id' => Auth::user()?->id,
                'action'  => "Tạo tài khoản: {$user->name} ({$user->role})",
            ]);
        });

        // Ghi log khi cập nhật tài khoản
        static::updated(function ($user) {
            Logs::create([
                'user_id' => Auth::user()?->id,
                'action'  => "Chỉnh sửa tài khoản: {$user->name} ({$user->role})",
            ]);
        });

        // Ghi log khi xóa tài khoản
        static::deleted(function ($user) {
            Logs::create([
                'user_id' => Auth::user()?->id,
                'action'  => "Xóa tài khoản: {$user->name} ({$user->role})",
            ]);
        });
    }
}