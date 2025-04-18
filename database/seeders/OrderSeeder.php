<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;
use Faker\Factory as Faker;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $userIds = User::pluck('id')->toArray();

        $statuses = ['pending', 'processing', 'shipped', 'delivered', 'canceled'];
        $paymentMethods = ['credit_card', 'paypal', 'bank_transfer'];
        $shippingMethods = ['standard', 'express'];
        $couponCodes = [null, 'SUMMER2025', 'WINTER2025'];

        $orders = [];

        for ($i = 0; $i < 50; $i++) {
            $orders[] = [
                'user_id'          => $faker->randomElement($userIds),
                'order_date'       => $faker->dateTimeBetween('-1 years', 'now'),
                'status'           => $faker->randomElement($statuses),
                'total'            => $faker->randomFloat(2, 100, 1000),
                'shipping_address' => $faker->address,
                'payment_method'   => $faker->randomElement($paymentMethods),
                'tracking_number'  => $faker->bothify('TRK###??'),
                'shipping_method'  => $faker->randomElement($shippingMethods),
                'shipping_cost'    => $faker->randomFloat(2, 10, 100),
                'billing_address'  => $faker->address,
                'coupon_code'      => $faker->randomElement($couponCodes),
                'discount'         => $faker->randomFloat(2, 0, 100),
                'notes'            => $faker->sentence,
            ];
        }

        Order::insert($orders);
    }
}
