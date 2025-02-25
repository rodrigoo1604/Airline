<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\User;
use App\Models\Plane;
use App\Models\Flight;
use App\Models\Reservation;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReservationControllerTest extends TestCase
{
    use RefreshDatabase; // Cleans database after each test

    public function test_it_can_list_all_reservations()
    {
        $user = User::factory()->create();
        $plane = Plane::create(['name' => 'Boeing 737', 'seats' => 180]);

        $flight = Flight::create([
            'date' => now()->addDays(10),
            'departure' => 'New York',
            'arrival' => 'London',
            'plane_id' => $plane->id,
            'status' => true
        ]);

        Reservation::create([
            'user_id' => $user->id,
            'flight_id' => $flight->id
        ]);

        $response = $this->getJson('/api/reservations');

        $response->assertStatus(200)
                 ->assertJsonCount(1);
    }

    public function test_it_can_create_a_reservation()
    {
        $user = User::factory()->create();
        $plane = Plane::create(['name' => 'Airbus A320', 'seats' => 150]);

        $flight = Flight::create([
            'date' => now()->addDays(5),
            'departure' => 'Los Angeles',
            'arrival' => 'Rome',
            'plane_id' => $plane->id,
            'status' => true
        ]);

        $data = [
            'user_id' => $user->id,
            'flight_id' => $flight->id
        ];

        $response = $this->postJson('/api/reservations', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment(['user_id' => $user->id]);

        $this->assertDatabaseHas('reservations', $data);
    }
/*
    public function test_it_cannot_create_a_reservation_if_flight_is_full()
    {
        $user = User::factory()->create();
        $plane = Plane::create(['name' => 'Small Jet', 'seats' => 1]);

        $flight = Flight::create([
            'date' => now()->addDays(3),
            'departure' => 'Chicago',
            'arrival' => 'Toronto',
            'plane_id' => $plane->id,
            'status' => true
        ]);

        Reservation::create(['user_id' => $user->id, 'flight_id' => $flight->id]);

        $anotherUser = User::factory()->create();
        $data = ['user_id' => $anotherUser->id, 'flight_id' => $flight->id];

        $response = $this->postJson('/api/reservations', $data);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['flight_id']);
    }

    public function test_it_cannot_create_duplicate_reservation_for_same_user_and_flight()
    {
        $user = User::factory()->create();
        $plane = Plane::create(['name' => 'Boeing 747', 'seats' => 400]);

        $flight = Flight::create([
            'date' => now()->addDays(7),
            'departure' => 'Berlin',
            'arrival' => 'Dubai',
            'plane_id' => $plane->id,
            'status' => true
        ]);

        Reservation::create(['user_id' => $user->id, 'flight_id' => $flight->id]);

        $data = ['user_id' => $user->id, 'flight_id' => $flight->id];

        $response = $this->postJson('/api/reservations', $data);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['user_id']);
    }
*/
    public function test_it_can_show_a_specific_reservation()
    {
        $user = User::factory()->create();
        $plane = Plane::create(['name' => 'Embraer E190', 'seats' => 100]);

        $flight = Flight::create([
            'date' => now()->addDays(15),
            'departure' => 'Miami',
            'arrival' => 'San Francisco',
            'plane_id' => $plane->id,
            'status' => true
        ]);

        $reservation = Reservation::create(['user_id' => $user->id, 'flight_id' => $flight->id]);

        $response = $this->getJson("/api/reservations/{$reservation->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['user_id' => $user->id]);
    }

    public function test_it_can_delete_a_reservation()
    {
        $user = User::factory()->create();
        $plane = Plane::create(['name' => 'Boeing 777', 'seats' => 350]);

        $flight = Flight::create([
            'date' => now()->addDays(20),
            'departure' => 'Tokyo',
            'arrival' => 'Sydney',
            'plane_id' => $plane->id,
            'status' => true
        ]);

        $reservation = Reservation::create(['user_id' => $user->id, 'flight_id' => $flight->id]);

        $response = $this->deleteJson("/api/reservations/{$reservation->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('reservations', ['id' => $reservation->id]);
    }
}