<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'rating',
        'comment',
        'verified',
        'helpful',
        'helpful_count',
        'ip_address',
        'user_agent',
        'review_type',
        'review_image',
        'review_video',
        'review_url',
        'review_title',
        'review_status',
        'review_response',
        'review_response_status',
        'review_response_time',
        'review_response_user_id'
    ];

    // Một đánh giá thuộc về một người dùng
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Một đánh giá thuộc về một sản phẩm
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Người phản hồi đánh giá
    public function responseUser()
    {
        return $this->belongsTo(User::class, 'review_response_user_id');
    }
}
