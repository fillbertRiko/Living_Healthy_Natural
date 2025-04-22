<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\User;
use App\Models\Product;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Lấy danh sách các khóa ngoại cần thiết
        $userIds    = User::pluck('id')->toArray();
        $productIds = Product::pluck('id')->toArray();

        if (empty($userIds) || empty($productIds)) {
            $this->command->info('Vui lòng seed bảng users và products trước khi seed comments.');
            return;
        }

        $baseCommentIds = [];

        // Tạo 50 bình luận gốc (không có parent_comment_id)
        for ($i = 0; $i < 50; $i++) {
            $commentType = $faker->randomElement(['text', 'video', 'image']);

            $comment = Comment::create([
                'user_id'                 => $faker->randomElement($userIds),
                'product_id'              => $faker->randomElement($productIds),
                'parent_comment_id'       => null,
                'content'                 => $faker->paragraph,
                'is_approved'             => $faker->boolean(30), // khoảng 30% được duyệt
                'likes_count'             => $faker->numberBetween(0, 50),

                // Quản lý bình luận
                'ip_address'              => $faker->ipv4,
                'user_agent'              => $faker->userAgent,
                'is_spam'                 => $faker->boolean(10),
                'is_featured'             => $faker->boolean(10),
                'comment_type'            => $commentType,
                'comment_image'           => $commentType === 'image' ? $faker->imageUrl(640, 480, 'cats', true) : null,
                'comment_video'           => $commentType === 'video' ? $faker->url : null,
                'comment_url'             => $faker->optional()->url,
                'comment_title'           => $faker->optional()->sentence(6),
                'comment_status'          => $faker->randomElement(['pending', 'approved', 'rejected']),
                'comment_response'        => $faker->optional()->sentence,
                'comment_response_status' => $faker->randomElement(['pending', 'approved', 'rejected']),
                'comment_response_time'   => $faker->optional()->dateTimeBetween('-1 month', 'now'),
                'comment_response_user_id' => $faker->optional()->randomElement($userIds),

                // Analytics
                'is_verified'             => $faker->boolean(50),
                'is_helpful'              => $faker->boolean(50),
                'helpful_count'           => $faker->numberBetween(0, 100),
                'comment_language'        => 'en',
                'comment_location'        => $faker->optional()->city,
                'comment_device'          => $faker->optional()->randomElement(['mobile', 'desktop', 'tablet']),
                'comment_platform'        => $faker->optional()->word,
                'comment_timezone'        => $faker->optional()->timezone,
            ]);

            $baseCommentIds[] = $comment->id;
        }

        // Tạo 20 bình luận trả lời (reply) với parent_comment_id được gán ngẫu nhiên từ các bình luận gốc
        for ($i = 0; $i < 20; $i++) {
            $parentCommentId = $faker->randomElement($baseCommentIds);
            $commentType     = $faker->randomElement(['text', 'video', 'image']);

            Comment::create([
                'user_id'                 => $faker->randomElement($userIds),
                'product_id'              => $faker->randomElement($productIds),
                'parent_comment_id'       => $parentCommentId,
                'content'                 => $faker->paragraph,
                'is_approved'             => $faker->boolean(50), // tỷ lệ được duyệt cao hơn cho câu trả lời
                'likes_count'             => $faker->numberBetween(0, 20),

                // Quản lý bình luận
                'ip_address'              => $faker->ipv4,
                'user_agent'              => $faker->userAgent,
                'is_spam'                 => $faker->boolean(10),
                'is_featured'             => $faker->boolean(10),
                'comment_type'            => $commentType,
                'comment_image'           => $commentType === 'image' ? $faker->imageUrl(640, 480, 'cats', true) : null,
                'comment_video'           => $commentType === 'video' ? $faker->url : null,
                'comment_url'             => $faker->optional()->url,
                'comment_title'           => $faker->optional()->sentence(6),
                'comment_status'          => $faker->randomElement(['pending', 'approved', 'rejected']),
                'comment_response'        => $faker->optional()->sentence,
                'comment_response_status' => $faker->randomElement(['pending', 'approved', 'rejected']),
                'comment_response_time'   => $faker->optional()->dateTimeBetween('-1 month', 'now'),
                'comment_response_user_id' => $faker->optional()->randomElement($userIds),

                // Analytics
                'is_verified'             => $faker->boolean(50),
                'is_helpful'              => $faker->boolean(50),
                'helpful_count'           => $faker->numberBetween(0, 50),
                'comment_language'        => 'en',
                'comment_location'        => $faker->optional()->city,
                'comment_device'          => $faker->optional()->randomElement(['mobile', 'desktop', 'tablet']),
                'comment_platform'        => $faker->optional()->word,
                'comment_timezone'        => $faker->optional()->timezone,
            ]);
        }
    }
}
