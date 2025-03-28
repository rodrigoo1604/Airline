<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    public function index()
    {
        $this->updateFlightAvailability();

        $flights = Flight::where('status', true)
            ->orderBy('date', 'asc')
            ->get();

        return view('flights', compact('flights'));
    }

    private function updateFlightAvailability()
    {
        $flights = Flight::all();

        foreach ($flights as $flight) {
            $reservedSeats = $flight->reservations()->count();
            $totalSeats = $flight->plane->seats;

            $isAvailable = ($flight->date >= now()) && ($reservedSeats < $totalSeats);

            if ($flight->availability !== $isAvailable) {
                $flight->update(['status' => $isAvailable]);
            }
        }
    }
}