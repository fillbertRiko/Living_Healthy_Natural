<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Settings;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $seeders = array(
            UserSeeder::class,
            CustomerSeeder::class,
            //SettingsSeeder::class,
            //CategorySeeder::class,
            //ProductSeeder::class,
            // WarehouseSeeder::class,
            // WarehouseStockSeeder::class,
            // CartSeeder::class,
            // CartItemSeeder::class,
            // OrderSeeder::class,
            // OrderItemSeeder::class,
            // PaymentSeeder::class,
            // ReviewSeeder::class,
            // CommentSeeder::class,
        );

        foreach ($seeders as $seeder) {
            $this->call($seeder);
        }
    }
}
