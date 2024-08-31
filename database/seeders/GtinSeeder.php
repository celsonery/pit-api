<?php

namespace Database\Seeders;

use App\Models\Gtin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GtinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Gtin::factory()->create();
    }
}
