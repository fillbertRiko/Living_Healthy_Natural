<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Products extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'quantity',
        'category_id',
        'image',
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
        'meta_title',
        'meta_description',
        'is_active',
        'is_featured',
        'is_on_sale',
        'is_new',
    ];

    protected $casts = [
        'price' => 'float',
        'quantity' => 'integer',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_on_sale' => 'boolean',
        'is_new' => 'boolean',
    ];

    protected $attributes = [
        'is_active' => true,
        'is_featured' => false,
        'is_on_sale' => false,
        'is_new' => false,
    ];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected $appends = ['image_url'];
    protected $with = ['category'];
    protected $table = 'products';
    protected $primaryKey = 'id';

    // Relationships
    public function cartItems()
    {
        return $this->hasMany(CartItems::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function warehouses()
    {
        return $this->belongsToMany(Warehouse::class, 'warehouse_stocks');
    }

    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }

    // Boot method for model events
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    // Accessor for image_url
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }
}
