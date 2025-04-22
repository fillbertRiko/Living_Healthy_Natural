<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class WarehouseStock extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'warehouse_id',
        'product_id',
        'quantity',
        'cost_price',
        'selling_price',
        'reorder_level',
        'reorder_quantity',
        'status',
        'discount_price',
        'minimum_order_quantity',
        'maximum_order_quantity',
        'notes',
    ];

    /**
     * Relationship with Warehouse model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    /**
     * Relationship with Product model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class); // Fixed class name to singular for consistency
    }
}
