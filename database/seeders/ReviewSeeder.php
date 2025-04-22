<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\User;
use App\Models\Product;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Lấy danh sách id của người dùng và sản phẩm để đảm bảo khóa ngoại hợp lệ
        $userIds = User::pluck('id')->toArray();
        $productIds = Product::pluck('id')->toArray();

        // Nếu chưa có dữ liệu của Users hoặc Products, thông báo và dừng seeder
        if (empty($userIds) || empty($productIds)) {
            $this->command->info('Vui lòng seed bảng users và products trước khi seed reviews.');
            return;
        }

        // Tạo 50 đánh giá mẫu
        for ($i = 0; $i < 50; $i++) {
            Review::create([
                'user_id'                  => $faker->randomElement($userIds),
                'product_id'               => $faker->randomElement($productIds),
                'rating'                   => $faker->numberBetween(1, 5),
                'comment'                  => $faker->optional()->paragraph,
                'verified'                 => $faker->boolean(70), // 70% khả năng đánh giá đã được xác thực
                'helpful'                  => $faker->boolean(50),
                'helpful_count'            => $faker->numberBetween(0, 100),
                'ip_address'               => $faker->optional()->ipv4,
                'user_agent'               => $faker->optional()->userAgent,
                'review_type'              => $faker->randomElement(['text', 'video', 'image']),
                'review_image'             => $faker->optional()->imageUrl(640, 480, 'cats', true),
                'review_video'             => $faker->optional()->url,
                'review_url'               => $faker->optional()->url,
                'review_title'             => $faker->optional()->sentence,
                'review_status'            => $faker->randomElement(['pending', 'approved', 'rejected']),
                'review_response'          => $faker->optional()->sentence,
                'review_response_status'   => $faker->randomElement(['pending', 'approved', 'rejected']),
                'review_response_time'     => $faker->optional()->dateTimeBetween('-1 month', 'now'),
                'review_response_user_id'  => $faker->optional()->randomElement($userIds),
            ]);
        }
    }
}
