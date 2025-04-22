<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Lấy tất cả các category id để đảm bảo khóa ngoại hợp lệ
        $categoryIds = Category::pluck('id')->toArray();

        // Tạo 50 sản phẩm mẫu
        for ($i = 0; $i < 50; $i++) {
            // Sinh tên sản phẩm
            $name = $faker->words(3, true);

            Product::create([
                'name'              => $name,
                // Thêm một số ngẫu nhiên vào slug để đảm bảo tính duy nhất
                'slug'              => Str::slug($name) . '-' . $faker->unique()->numberBetween(1, 10000),
                'description'       => $faker->optional()->paragraph(),
                'price'             => $faker->randomFloat(2, 10, 1000),
                'quantity'          => $faker->numberBetween(1, 100),
                // Chọn ngẫu nhiên category từ danh sách đã seed
                'category_id'       => $faker->randomElement($categoryIds),
                'image'             => $faker->optional(0.7)->imageUrl(640, 480, 'technics', true),
                // Các trường bổ sung
                'sku'               => strtoupper($faker->bothify('SKU-####')),
                'barcode'           => $faker->optional()->numerify('############'),
                'brand'             => $faker->optional()->company,
                'model'             => $faker->optional()->bothify('Model-###'),
                'color'             => $faker->optional()->safeColorName,
                'size'              => $faker->optional()->randomElement(['S', 'M', 'L', 'XL', 'XXL']),
                'weight'            => $faker->optional()->randomFloat(2, 0.5, 10), // Khối lượng (kg)
                'dimensions'        => $faker->optional()->numerify('##x##x## cm'),
                'material'          => $faker->optional()->word,
                'warranty'          => $faker->optional()->randomElement(['1 year', '2 years', '3 years', 'None']),
                'origin'            => $faker->optional()->country,
                'tags'              => implode(', ', $faker->words(3)),
                'meta_title'        => $faker->optional()->sentence(3),
                'meta_description'  => $faker->optional()->sentence(10),
                // Trạng thái sản phẩm
                'is_active'         => $faker->boolean(90),
                'is_featured'       => $faker->boolean(10),
                'is_on_sale'        => $faker->boolean(10),
                'is_new'            => $faker->boolean(20),
            ]);
        }
    }
}
