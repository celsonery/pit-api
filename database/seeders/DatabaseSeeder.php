<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            SegmentSeeder::class,
//            CompanySeeder::class,
//            StoreSeeder::class,
            CategorySeeder::class,
            BrandSeeder::class,
            ProductSeeder::class,
//            SkuSeeder::class,
//            ImageSeeder::class,
//            OrderSeeder::class,
            PaymentMethodSeeder::class,
            DeliveryMethodSeeder::class
        ]);
    }
}
