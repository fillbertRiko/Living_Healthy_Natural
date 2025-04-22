<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Logs extends Model
{
    use HasFactory, SoftDeletes;

    // Cho phép mass assignment cho các trường trong bảng
    protected $fillable = [
        'user_id',
        'action',
        'ip_address',
        'user_agent',
        'device',
        'browser',
        'platform',
    ];

    // Quan hệ với model User
    public static function create(array $array)
    {
    }

    public static function latest()
    {
        return Logs::latest()->first();
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
