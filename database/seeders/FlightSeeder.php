<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Flight;
use App\Models\Plane;
use Carbon\Carbon;

class FlightSeeder extends Seeder
{
    public function run()
    {
        $planes = Plane::all();

        if ($planes->isEmpty()) {
            $this->command->info('No planes found. Run `php artisan db:seed --class=PlaneSeeder` first.');
            return;
        }

        $flights = [
            ['date' => Carbon::now()->addDays(2), 'departure' => 'New York', 'arrival' => 'Los Angeles', 'plane_id' => $planes->random()->id, 'status' => true],
            ['date' => Carbon::now()->addDays(5), 'departure' => 'London', 'arrival' => 'Paris', 'plane_id' => $planes->random()->id, 'status' => true],
            ['date' => Carbon::now()->subDays(1), 'departure' => 'Berlin', 'arrival' => 'Madrid', 'plane_id' => $planes->random()->id, 'status' => false], // Vuelo pasado
            ['date' => Carbon::now()->addDays(7), 'departure' => 'Tokyo', 'arrival' => 'Seoul', 'plane_id' => $planes->random()->id, 'status' => true],
        ];

        foreach ($flights as $flight) {
            Flight::create($flight);
        }
    }
}
