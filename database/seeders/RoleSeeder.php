<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Phone;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::factory()->has(User::factory()
            ->has(Phone::factory())
            ->count(3)
            ->has(Address::factory()))
            ->create(['name' => 'admin']);

        Role::factory()->has(User::factory()
            ->has(Phone::factory())
            ->has(Address::factory()))
            ->create(['name' => 'owner']);

        Role::factory()->has(User::factory()
            ->has(Phone::factory())
            ->has(Address::factory()))
            ->create(['name' => 'manager']);

        Role::factory()->has(User::factory()
            ->has(Phone::factory())
            ->count(5)
            ->has(Address::factory()))
            ->create(['name' => 'costumer']);
    }
}
