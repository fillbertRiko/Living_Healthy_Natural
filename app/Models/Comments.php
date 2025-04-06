<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id', 'parent_comment_id', 'content'];

    // Một bình luận thuộc về một người dùng
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Một bình luận thuộc về một sản phẩm
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Bình luận cha - con (nested comments)
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_comment_id');
    }
}