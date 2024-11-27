<?php

namespace Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_if_the_new_user_can_be_registered(): void
    {
        Role::factory()->create()->count(4);
        User::factory()->create();

        $this->assertDatabaseCount('users', 1);
    }

    public function test_if_can_be_created_four_users_with_a_role(): void
    {
        Role::factory()->create()
            ->has(User::factory()->count(4));

        $this->assertDatabaseCount('users', 4);
    }

    public function test_if_user_can_login(): void
    {
        $role = Role::factory()->create();
        $user = $role->users()->create();

        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200);
    }
}
