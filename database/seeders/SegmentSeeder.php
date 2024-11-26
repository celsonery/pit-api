<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Segment;
use App\Models\Store;
use Illuminate\Database\Seeder;

class SegmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Segment::factory()
            ->has(Company::factory(2)
                ->has(Store::factory(2)))
            ->count(2)
            ->create();
    }
}
