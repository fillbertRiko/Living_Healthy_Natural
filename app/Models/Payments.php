<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payments extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_id',
        'payment_date',
        'amount',
        'payment_method',
        'status',
        'transaction_id',
        'currency',
        'payment_gateway',
    ];

    // Định nghĩa các giá trị mặc định cho các trường enum
    const PAYMENT_METHODS = ['credit_card', 'paypal', 'bank_transfer', 'cash'];
    const STATUSES = ['pending', 'completed', 'failed', 'refunded'];

    // Nếu cần, bạn có thể thêm các quan hệ
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
