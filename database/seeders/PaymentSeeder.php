<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payments;
use App\Models\Order;
use Faker\Factory as Faker;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Lấy danh sách các order id từ bảng orders để đảm bảo khóa ngoại hợp lệ
        $orderIds = Order::pluck('id')->toArray();

        if (empty($orderIds)) {
            $this->command->info('Vui lòng seed bảng orders trước khi seed payments.');
            return;
        }

        // Tạo 50 bản ghi mẫu cho bảng payments
        for ($i = 0; $i < 50; $i++) {
            Payments::create([
                // Chọn ngẫu nhiên một order_id từ danh sách
                'order_id'       => $faker->randomElement($orderIds),
                // Ngày thanh toán nằm trong khoảng 1 năm gần đây
                'payment_date'   => $faker->dateTimeBetween('-1 years', 'now'),
                // Sinh giá trị amount với độ chính xác 2 chữ số thập phân
                'amount'         => $faker->randomFloat(2, 10, 500),
                // Chọn ngẫu nhiên phương thức thanh toán
                'payment_method' => $faker->randomElement(['credit_card', 'paypal', 'bank_transfer', 'cash']),
                // Chọn trạng thái thanh toán ngẫu nhiên
                'status'         => $faker->randomElement(['pending', 'completed', 'failed', 'refunded']),
                // Sinh transaction_id ngẫu nhiên (80% khả năng có giá trị)
                'transaction_id' => $faker->optional(0.8)->bothify('TRX####??'),
                // Giá trị currency mặc định, có thể được dùng hoặc thay đổi nếu cần
                'currency'       => 'USD',
                // Chọn ngẫu nhiên cổng thanh toán, nếu có
                'payment_gateway' => $faker->optional()->randomElement(['Stripe', 'PayPal', 'Square']),
            ]);
        }
    }
}
