<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * Các trường được dùng để tạo mới và cập nhật bản ghi,
     * được phân nhóm theo nội dung, quan hệ, metadata, và thống kê.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        // Quan hệ
        'user_id',
        'product_id',
        'parent_comment_id',
        'comment_response_user_id',

        // Nội dung bình luận
        'content',
        'comment_type',
        'comment_title',
        'comment_image',
        'comment_video',
        'comment_url',

        // Trạng thái và phản hồi
        'is_approved',
        'comment_status',
        'comment_response',
        'comment_response_status',
        'comment_response_time',

        // Các trường liên quan đến kiểm duyệt và ngoại vi
        'likes_count',
        'ip_address',
        'user_agent',
        'is_spam',
        'is_featured',
        'is_verified',
        'is_helpful',
        'helpful_count',

        // Thông tin bổ sung: ngôn ngữ, vị trí, thiết bị,...
        'comment_language',
        'comment_location',
        'comment_device',
        'comment_platform',
        'comment_timezone',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_approved'            => 'boolean',
        'likes_count'            => 'integer',
        'is_spam'                => 'boolean',
        'is_featured'            => 'boolean',
        'comment_response_status' => 'boolean',
        'is_verified'            => 'boolean',
        'is_helpful'             => 'boolean',
        'helpful_count'          => 'integer',
        'comment_response_time'  => 'datetime',
    ];

    /**
     * Một bình luận thuộc về một người dùng.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Một bình luận thuộc về một sản phẩm.
     *
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        // Lưu ý: Nếu tên model cho sản phẩm là "Product", nên đổi lại cho phù hợp.
        return $this->belongsTo(Product::class);
    }

    /**
     * Bình luận cha - con (nested comments): Lấy danh sách reply cho bình luận này.
     *
     * @return HasMany
     */
    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_comment_id');
    }

    /**
     * Lấy bình luận cha của bình luận hiện tại.
     *
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_comment_id');
    }

    /**
     * Lấy người dùng phản hồi bình luận (nếu có).
     *
     * @return BelongsTo
     */
    public function responseUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'comment_response_user_id');
    }
}
