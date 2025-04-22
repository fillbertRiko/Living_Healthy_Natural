<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Tạo 10 danh mục mẫu
        for ($i = 0; $i < 10; $i++) {
            // Tạo một tên danh mục ngẫu nhiên và đảm bảo tính duy nhất
            $name = ucfirst($faker->unique()->word);

            Category::create([
                'name'              => $name,
                'slug'              => Str::slug($name),
                'description'       => $faker->sentence(10),
                'active'            => $faker->boolean(90), // Tỷ lệ active cao (90%)
                'image'             => $faker->optional()->imageUrl(640, 480, 'business', true), // Có thể null
                'meta_title'        => $faker->optional()->sentence(5),
                'meta_description'  => $faker->optional()->sentence(10),
            ]);
        }
    }
}
