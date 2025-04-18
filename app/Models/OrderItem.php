<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'sku',
        'product_name',
        'product_image'
    ];

    // Một sản phẩm thuộc về một đơn hàng
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Một sản phẩm trong đơn hàng liên kết với một sản phẩm cụ thể
    public function product()
    {
        return $this->belongsTo(Products::class);
    }
}
