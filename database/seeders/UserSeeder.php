<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Order;
use App\Models\Phone;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->has(Address::factory(), Phone::factory(), Order::factory())
            ->count(3)
            ->create();
    }
}
