<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plane;

class PlaneSeeder extends Seeder
{
    public function run()
    {
        $planes = [
            ['name' => 'Boeing 737', 'seats' => 180],
            ['name' => 'Airbus A320', 'seats' => 160],
            ['name' => 'Embraer 190', 'seats' => 100],
            ['name' => 'Boeing 777', 'seats' => 396],
        ];

        foreach ($planes as $plane) {
            Plane::create($plane);
        }
    }
}
