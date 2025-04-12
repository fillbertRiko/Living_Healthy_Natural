<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'location', 'description'];

    // Một kho có nhiều sản phẩm tồn kho
    public function stocks()
    {
        return $this->hasMany(WarehouseStock::class);
    }
}