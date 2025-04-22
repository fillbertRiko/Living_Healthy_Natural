<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Warehouse extends Model
{
    use HasFactory;

    // Các thuộc tính có thể gán hàng loạt
    protected $fillable = [
        // Thông tin cơ bản
        'name',
        'location',
        'description',
        'manager',
        'contact_number',
        'email',
        'address',

        // Thông tin kho
        'capacity',
        'status',
        'is_active',
        'is_featured',
        'is_on_sale',
        'is_new',

        // Thông tin sản phẩm
        'sku',
        'barcode',
        'brand',
        'model',
        'color',
        'size',
        'weight',
        'dimensions',
        'material',
        'warranty',
        'origin',
        'tags',
        'image',
        'slug',

        // SEO
        'meta_title',
        'meta_description',
    ];

    /**
     * Một kho có nhiều sản phẩm tồn kho
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stocks(): object
    {
        return $this->hasMany(WarehouseStock::class);
    }
}
