<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\OrderItem;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'status',
        'total',
        'shipping_address',
        'order_date',
        'payment_method',
        'tracking_number',
        'shipping_method',
        'shipping_cost',
        'billing_address',
        'coupon_code',
        'discount',
        'notes',
        'created_at',
        'updated_at'
    ];

    // Một đơn hàng thuộc về một người dùng
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Một đơn hàng có nhiều sản phẩm
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
