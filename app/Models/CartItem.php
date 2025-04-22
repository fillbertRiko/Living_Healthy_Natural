<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class CartItem
 *
 * @property int      $id
 * @property int      $cart_id
 * @property int      $product_id
 * @property int      $quantity
 * @property float    $price
 * @property float    $discount_price
 * @property string   $currency
 * @property string   $status
 * @property string   $product_name
 * @property string   $product_sku
 * @property string   $product_image
 * @property string   $product_description
 * @property Cart     $cart
 * @property Product  $product
 *
 * @package App\Models
 */
class CartItem extends Model
{
    use SoftDeletes;

    protected $table = 'cart_items';

    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
        'price',
        'discount_price',
        'currency',
        'status',
        'product_name',
        'product_sku',
        'product_image',
        'product_description',
    ];

    /**
     * Các thuộc tính sẽ được ép kiểu tự động.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'quantity'        => 'integer',
        'price'           => 'decimal:2',
        'discount_price'  => 'decimal:2',
    ];

    /**
     * Quan hệ với Cart.
     *
     * @return BelongsTo
     */
    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * Quan hệ với Product.
     *
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
