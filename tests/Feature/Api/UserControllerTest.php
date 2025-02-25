<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_list_users()
    {
        User::factory()->count(3)->create();

        $response = $this->getJson('/api/users');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    public function test_it_can_create_a_user()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123'
        ];

        $response = $this->postJson('/api/users', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment(['name' => 'John Doe', 'email' => 'john@example.com']);

        $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
    }

    public function test_it_cannot_create_a_user_with_existing_email()
    {
        User::factory()->create(['email' => 'existing@example.com']);

        $data = [
            'name' => 'Jane Doe',
            'email' => 'existing@example.com',
            'password' => 'password123'
        ];

        $response = $this->postJson('/api/users', $data);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['email']);
    }

    public function test_it_can_show_a_user()
    {
        $user = User::factory()->create();

        $response = $this->getJson("/api/users/{$user->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['id' => $user->id, 'email' => $user->email]);
    }

    public function test_it_can_update_a_user()
    {
        $user = User::factory()->create();
        $data = ['name' => 'Updated Name'];

        $response = $this->putJson("/api/users/{$user->id}", $data);

        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => 'Updated Name']);

        $this->assertDatabaseHas('users', ['id' => $user->id, 'name' => 'Updated Name']);
    }

    public function test_it_cannot_update_a_user_with_existing_email()
    {
        User::factory()->create(['email' => 'unique@example.com']);
        $user = User::factory()->create();

        $data = ['email' => 'unique@example.com'];

        $response = $this->putJson("/api/users/{$user->id}", $data);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['email']);
    }

    public function test_it_can_delete_a_user()
    {
        $user = User::factory()->create();

        $response = $this->deleteJson("/api/users/{$user->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['message' => 'User deleted successfully.']);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}