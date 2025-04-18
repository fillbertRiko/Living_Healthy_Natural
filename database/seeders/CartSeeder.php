<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $carts = [];
        for ($i = 1; $i <= 10; $i++) {
            $carts[] = [
                'customer_id' => $i,
                'session_id' => Str::random(10),
                'ip_address' => '192.168.1.' . $i,
                'user_agent' => 'Mozilla/5.0',
                'status' => 'active',
                'total_items' => rand(1, 10),
                'total_price' => rand(100000, 500000),
                'discount_code' => $i % 2 == 0 ? 'DISCOUNT' . $i : null,
                'discount_amount' => $i % 2 == 0 ? rand(10000, 50000) : 0,
                'currency' => 'VND',
                'shipping_method' => 'Standard',
                'shipping_cost' => rand(20000, 50000),
                'payment_status' => 'pending',
                'payment_method' => 'Credit Card',
                'shipping_address' => 'Address ' . $i,
                'billing_address' => 'Address ' . $i,
                'notes' => 'Note for cart ' . $i,
                'gift_message' => $i % 3 == 0 ? 'Gift message ' . $i : null,
                'gift_wrap' => $i % 3 == 0,
                'loyalty_points_used' => rand(0, 100),
                'loyalty_points_earned' => rand(0, 50),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('carts')->insert($carts);
    }
}
