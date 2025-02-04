<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Plane;
use App\Models\Flight;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FlightControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_list_all_flights()
    {
        $plane = Plane::create(['name' => 'Boeing 737', 'seats' => 180]);

        Flight::create([
            'date' => now()->addDays(5),
            'departure' => 'New York',
            'arrival' => 'London',
            'plane_id' => $plane->id,
            'status' => true
        ]);

        Flight::create([
            'date' => now()->addDays(10),
            'departure' => 'Paris',
            'arrival' => 'Tokyo',
            'plane_id' => $plane->id,
            'status' => true
        ]);

        $response = $this->getJson('/api/flights');

        $response->assertStatus(200)
                 ->assertJsonCount(2);
    }

    public function test_it_can_create_a_flight()
    {
        $plane = Plane::create(['name' => 'Airbus A320', 'seats' => 150]);

        $data = [
            'date' => now()->addDays(7)->toDateString(),
            'departure' => 'Los Angeles',
            'arrival' => 'Rome',
            'plane_id' => $plane->id,
            'status' => true
        ];

        $response = $this->postJson('/api/flights', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment(['departure' => 'Los Angeles']);

        $this->assertDatabaseHas('flights', $data);
    }

    public function test_it_cannot_create_a_flight_with_invalid_data()
    {
        $data = [
            'date' => '',
            'departure' => '',
            'arrival' => '',
            'plane_id' => null,
            'status' => true
        ];

        $response = $this->postJson('/api/flights', $data);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['date', 'departure', 'arrival', 'plane_id']);
    }

    public function test_it_can_show_a_specific_flight()
    {
        $plane = Plane::create(['name' => 'Boeing 747', 'seats' => 400]);

        $flight = Flight::create([
            'date' => now()->addDays(15),
            'departure' => 'Berlin',
            'arrival' => 'Los Angeles',
            'plane_id' => $plane->id,
            'status' => true
        ]);

        $response = $this->getJson("/api/flights/{$flight->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['departure' => 'Berlin']);
    }

    public function test_it_can_update_a_flight()
    {
        $plane = Plane::create(['name' => 'Embraer E190', 'seats' => 100]);

        $flight = Flight::create([
            'date' => now()->addDays(20),
            'departure' => 'Lisbon',
            'arrival' => 'Amsterdam',
            'plane_id' => $plane->id,
            'status' => true
        ]);

        $data = [
            'date' => now()->addDays(25)->toDateString(),
            'departure' => 'Lisbon',
            'arrival' => 'Brussels',
            'plane_id' => $plane->id,
            'status' => false
        ];

        $response = $this->putJson("/api/flights/{$flight->id}", $data);

        $response->assertStatus(200)
                 ->assertJsonFragment(['arrival' => 'Brussels']);

        $this->assertDatabaseHas('flights', $data);
    }

    public function test_it_can_delete_a_flight()
    {
        $plane = Plane::create(['name' => 'Boeing 777', 'seats' => 350]);

        $flight = Flight::create([
            'date' => now()->addDays(30),
            'departure' => 'Tokyo',
            'arrival' => 'Sydney',
            'plane_id' => $plane->id,
            'status' => true
        ]);

        $response = $this->deleteJson("/api/flights/{$flight->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('flights', ['id' => $flight->id]);
    }
}
