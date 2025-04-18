<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Lấy danh sách user_id từ bảng users (nếu có)
        $userIds = User::pluck('id')->toArray();

        // Tạo 50 bản ghi khách hàng mẫu
        for ($i = 0; $i < 50; $i++) {
            Customer::create([
                // Nếu có user, chọn ngẫu nhiên; nếu không, sẽ trả về null
                'user_id'                   => $faker->optional()->randomElement($userIds),
                'full_name'                 => $faker->name,
                'email'                     => $faker->unique()->safeEmail,
                'phone'                     => $faker->optional()->phoneNumber,
                'address'                   => $faker->optional()->address,
                'loyalty_card_number'       => $faker->optional()->bothify('LC####'),
                'date_of_birth'             => $faker->optional()->date('Y-m-d', '2000-01-01'),
                'gender'                    => $faker->randomElement(['male', 'female', 'other']),
                'status'                    => $faker->randomElement(['active', 'inactive', 'blacklisted']),
                'customer_type'             => $faker->randomElement(['regular', 'premium', 'vip']),
                'loyalty_points'            => $faker->numberBetween(0, 1000),
                'membership_level'          => $faker->randomElement(['basic', 'silver', 'gold', 'platinum']),
                'referral_code'             => $faker->optional()->bothify('REF####'),
                'referral_source'           => $faker->optional()->company,
                'preferred_contact_method'  => $faker->randomElement(['email', 'phone', 'sms']),
                'preferred_language'        => $faker->randomElement(['en', 'vn', 'fr', 'es']),
                'preferred_currency'        => $faker->randomElement(['USD', 'VND', 'EUR']),
                'notes'                     => $faker->optional()->sentence,
                'profile_picture'           => $faker->optional()->imageUrl(640, 480, 'people', true),
                'social_media_links'        => json_encode([
                    'facebook'  => $faker->optional()->url,
                    'twitter'   => $faker->optional()->url,
                    'instagram' => $faker->optional()->url,
                ]),
            ]);
        }
    }
}
