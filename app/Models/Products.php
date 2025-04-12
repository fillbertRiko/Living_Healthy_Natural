<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Products extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'price', 'quantity', 'category_id', 'image'];

    // Một sản phẩm thuộc về một danh mục
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Một sản phẩm có nhiều đánh giá
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Một sản phẩm có nhiều bình luận
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Một sản phẩm có thể xuất hiện trong nhiều đơn hàng
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Một sản phẩm có thể được lưu trữ ở nhiều kho
    public function warehouses()
    {
        return $this->belongsToMany(Warehouse::class, 'warehouse_stocks');
    }

    public function categories()
    {
        return $this->belongsTo(Categories::class);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if(!$product->slug)
            {
                $product->slug = Categories::find($product->category_id)?->slug ?? '';
            }
        });
    }
}