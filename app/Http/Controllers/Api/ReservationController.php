<?php

namespace App\Http\Controllers\Api;

use App\Models\Flight;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReservationController extends Controller
{
    public function index()
    {
        return response()->json(Reservation::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'flight_id' => 'required|exists:flights,id',
        ]);

        if (Reservation::where('user_id', $request->user_id)
                    ->where('flight_id', $request->flight_id)
                    ->exists()) {
            return response()->json(['error' => 'User already has a reservation for this flight.'], 422);
        }

        $flight = Flight::findOrFail($request->flight_id);
        $reservedSeats = Reservation::where('flight_id', $flight->id)->count();
        $planeSeats = optional($flight->plane)->seats ?? 0;

        if ($reservedSeats >= $planeSeats) {
            return response()->json(['error' => 'No seats available for this flight.'], 422);
        }

        $reservation = Reservation::create($request->all());

        return response()->json($reservation, 201);
    }


    public function show(Reservation $reservation)
    {
        return response()->json($reservation, 200);
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return response()->json(null, 204);
    }
}
