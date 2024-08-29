<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\Sku;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::factory()
            ->has(Product::factory(5)
                ->has(Sku::factory()
                    ->has(Image::factory(2))))
            ->count(5)
            ->create();
    }
}
