<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Warehouse;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Tạo 10 warehouse mẫu
        for ($i = 0; $i < 10; $i++) {
            $name = $faker->unique()->company; // Tên của warehouse dựa trên tên công ty giả
            Warehouse::create([
                'name'              => $name,
                'location'          => $faker->city,
                'description'       => $faker->optional()->paragraph,
                'manager'           => $faker->optional()->name,
                'contact_number'    => $faker->optional()->phoneNumber,
                'email'             => $faker->optional()->safeEmail,
                'address'           => $faker->optional()->address,
                'capacity'          => $faker->optional()->numberBetween(1000, 10000) . ' units',
                'status'            => $faker->randomElement(['active', 'inactive']),
                'meta_title'        => $faker->optional()->sentence(3),
                'meta_description'  => $faker->optional()->sentence(10),
                'is_active'         => $faker->boolean(90),
                'is_featured'       => $faker->boolean(10),
                'is_on_sale'        => $faker->boolean(10),
                'is_new'            => $faker->boolean(20),
                'sku'               => strtoupper($faker->bothify('WH####')),
                'barcode'           => $faker->numerify('########'),
                'brand'             => $faker->optional()->company,
                'model'             => $faker->optional()->bothify('Model-##'),
                'color'             => $faker->optional()->safeColorName,
                'size'              => $faker->optional()->randomElement(['Small', 'Medium', 'Large']),
                'weight'            => $faker->optional()->randomFloat(2, 100, 1000) . ' kg',
                'dimensions'        => $faker->optional()->numberBetween(50, 200) . 'x' .
                    $faker->optional()->numberBetween(50, 200) . 'x' .
                    $faker->optional()->numberBetween(50, 200) . ' cm',
                'material'          => $faker->optional()->word,
                'warranty'          => $faker->optional()->randomElement(['1 year', '2 years', '3 years']),
                'origin'            => $faker->optional()->country,
                'tags'              => implode(', ', $faker->words(3)),
                'image'             => $faker->optional()->imageUrl(640, 480, 'warehouse', true),
                'slug'              => Str::slug($name),
            ]);
        }
    }
}
