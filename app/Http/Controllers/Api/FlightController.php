<?php

namespace App\Http\Controllers\Api;

use App\Models\Flight;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FlightController extends Controller
{
    public function index()
    {
        return response()->json(Flight::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'departure' => 'required|string|max:255',
            'arrival' => 'required|string|max:255',
            'plane_id' => 'required|exists:planes,id',
            'status' => 'boolean'
        ]);

        $flight = Flight::create($request->all());

        return response()->json($flight, 201);
    }

    public function show(Flight $flight)
    {
        return response()->json($flight, 200);
    }

    public function update(Request $request, Flight $flight)
    {
        $request->validate([
            'date' => 'sometimes|required|date',
            'departure' => 'sometimes|required|string|max:255',
            'arrival' => 'sometimes|required|string|max:255',
            'plane_id' => 'sometimes|required|exists:planes,id',
            'status' => 'sometimes|boolean'
        ]);

        $flight->update($request->all());

        return response()->json($flight, 200);
    }

    public function destroy(Flight $flight)
    {
        $flight->delete();

        return response()->json(null, 204);
    }
}