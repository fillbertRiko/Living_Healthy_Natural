<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WarehouseStock;
use App\Models\Products;
use App\Models\Warehouse;
use Faker\Factory as Faker;

class WarehouseStockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Lấy danh sách product và warehouse để đảm bảo khóa ngoại hợp lệ
        $productIds   = Products::pluck('id')->toArray();
        $warehouseIds = Warehouse::pluck('id')->toArray();

        if (empty($productIds) || empty($warehouseIds)) {
            $this->command->info('Vui lòng seed bảng products và warehouses trước khi seed warehouse_stocks.');
            return;
        }

        // Tạo 50 bản ghi mẫu cho warehouse_stocks
        for ($i = 0; $i < 50; $i++) {
            WarehouseStock::create([
                'product_id'             => $faker->randomElement($productIds),
                'warehouse_id'           => $faker->randomElement($warehouseIds),
                'quantity'               => $faker->numberBetween(0, 1000),
                'cost_price'             => $faker->randomFloat(2, 1, 100),   // giá nhập: từ 1 đến 100
                'selling_price'          => $faker->randomFloat(2, 1, 150),   // giá bán: từ 1 đến 150
                'reorder_level'          => $faker->numberBetween(5, 20),
                'reorder_quantity'       => $faker->numberBetween(10, 50),
                'status'                 => $faker->randomElement(['active', 'inactive', 'out_of_stock']),
                'discount_price'         => $faker->optional()->randomFloat(2, 1, 100),
                'minimum_order_quantity' => $faker->numberBetween(1, 10),
                'maximum_order_quantity' => $faker->numberBetween(10, 100),
                'notes'                  => $faker->optional()->sentence,
            ]);
        }
    }
}
