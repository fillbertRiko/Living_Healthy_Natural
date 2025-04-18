<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Categories extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'active', 'image', 'meta_title', 'meta_description'];
    protected $casts = [
        'active' => 'boolean',
    ];
    protected $attributes = [
        'active' => true,
    ];

    // Một danh mục có nhiều sản phẩm
    public function products()
    {
        return $this->hasMany(Products::class);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->slug = Str::slug($model->name);
        });
        static::updating(function ($model) {
            $model->slug = Str::slug($model->name);
        });
    }
}
