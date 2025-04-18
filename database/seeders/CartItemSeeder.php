<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CartItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cartItems = [];
        for ($i = 1; $i <= 10; $i++) {
            $cartItems[] = [
                'cart_id' => rand(1, 5),
                'product_id' => $i,
                'quantity' => rand(1, 5),
                'price' => rand(50000, 500000),
                'discount_price' => rand(0, 1) ? rand(40000, 499999) : null,
                'currency' => 'VND',
                'status' => 'active',
                'product_name' => 'Product ' . Str::random(5),
                'product_sku' => 'SKU' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'product_image' => 'product_' . $i . '.jpg',
                'product_description' => 'Description for Product ' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('cart_items')->insert($cartItems);
    }
}
