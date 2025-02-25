<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Plane;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlaneControllerTest extends TestCase
{
    use RefreshDatabase; 

    public function test_it_can_list_all_planes()
    {
        Plane::create(['name' => 'Boeing 737', 'seats' => 180]);
        Plane::create(['name' => 'Airbus A320', 'seats' => 150]);

        $response = $this->getJson('/api/planes');

        $response->assertStatus(200)
                 ->assertJsonCount(2);
    }

    public function test_it_can_create_a_plane()
    {
        $data = [
            'name' => 'Boeing 747',
            'seats' => 350,
        ];

        $response = $this->postJson('/api/planes', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment(['name' => 'Boeing 747']);

        $this->assertDatabaseHas('planes', $data);
    }

    public function test_it_cannot_create_a_plane_with_invalid_data()
    {
        $data = [
            'name' => '',
            'seats' => -5,
        ];

        $response = $this->postJson('/api/planes', $data);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name', 'seats']);
    }

    public function test_it_can_show_a_specific_plane()
    {
        $plane = Plane::create(['name' => 'Cessna 172', 'seats' => 4]);

        $response = $this->getJson("/api/planes/{$plane->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => 'Cessna 172']);
    }

    public function test_it_can_update_a_plane()
    {
        $plane = Plane::create(['name' => 'Boeing 757', 'seats' => 220]);

        $data = ['name' => 'Boeing 767', 'seats' => 250];

        $response = $this->putJson("/api/planes/{$plane->id}", $data);

        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => 'Boeing 767']);

        $this->assertDatabaseHas('planes', $data);
    }

    public function test_it_can_delete_a_plane()
    {
        $plane = Plane::create(['name' => 'Embraer E190', 'seats' => 100]);

        $response = $this->deleteJson("/api/planes/{$plane->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('planes', ['id' => $plane->id]);
    }
}