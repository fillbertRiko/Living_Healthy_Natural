<?php

namespace Database\Seeders;

use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Product;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Lấy danh sách id của orders (đảm bảo các đơn hàng đã được seed)
        $orderIds = Order::pluck('id')->toArray();

        // Lấy tất cả sản phẩm từ bảng products (đảm bảo đã có dữ liệu)
        $products = Product::all();

        // Kiểm tra xem có dữ liệu đủ để seed không
        if (empty($orderIds) || $products->isEmpty()) {
            $this->command->info('Vui lòng seed bảng orders và products trước khi seed order_items.');
            return;
        }

        // Tạo 100 order items mẫu
        for ($i = 0; $i < 100; $i++) {
            $orderId = $faker->randomElement($orderIds);
            // Chọn ngẫu nhiên một sản phẩm từ collection
            $product = $products->random();

            // Số lượng mua
            $quantity = $faker->numberBetween(1, 5);

            // Giá được lấy từ sản phẩm (hoặc có thể nhân với số lượng nếu cần)
            $price = $product->price;

            OrderItem::create([
                'order_id'      => $orderId,
                'product_id'    => $product->id,
                'quantity'      => $quantity,
                'price'         => $price,
                'sku'           => $product->sku ?? strtoupper($faker->bothify('SKU-####')),
                'product_name'  => $product->name,
                'product_image' => $product->image,
            ]);
        }
    }
}
