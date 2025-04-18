<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Cart
 *
 * @property int         $id
 * @property int|null    $customer_id
 * @property string|null $session_id
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @property string|null $status
 * @property int|null    $total_items
 * @property float|null  $total_price
 * @property string|null $discount_code
 * @property float|null  $discount_amount
 * @property string|null $currency
 * @property string|null $shipping_method
 * @property float|null  $shipping_cost
 * @property string|null $payment_status
 * @property string|null $payment_method
 * @property string|null $shipping_address
 * @property string|null $billing_address
 * @property string|null $notes
 * @property string|null $gift_message
 * @property bool        $gift_wrap
 * @property int|null    $loyalty_points_used
 * @property int|null    $loyalty_points_earned
 *
 * @package App\Models
 */
class Cart extends Model
{
    use SoftDeletes;

    /**
     * Tên bảng trong database.
     *
     * @var string
     */
    protected $table = 'carts';

    /**
     * Các trường được phép gán giá trị hàng loạt.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id',
        'session_id',
        'ip_address',
        'user_agent',
        'status',
        'total_items',
        'total_price',
        'discount_code',
        'discount_amount',
        'currency',
        'shipping_method',
        'shipping_cost',
        'payment_status',
        'payment_method',
        'shipping_address',
        'billing_address',
        'notes',
        'gift_message',
        'gift_wrap',
        'loyalty_points_used',
        'loyalty_points_earned',
    ];

    /**
     * Các thuộc tính sẽ được ép kiểu tự động.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'total_items'           => 'integer',
        'total_price'           => 'decimal:2',
        'discount_amount'       => 'decimal:2',
        'shipping_cost'         => 'decimal:2',
        'gift_wrap'             => 'boolean',
        'loyalty_points_used'   => 'integer',
        'loyalty_points_earned' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | Các quan hệ (Relationships)
    |--------------------------------------------------------------------------
    |
    | Bạn có thể bổ sung các quan hệ nếu cần, ví dụ:
    |
    | public function customer()
    | {
    |     return $this->belongsTo(User::class, 'customer_id');
    | }
    |
    */
}
