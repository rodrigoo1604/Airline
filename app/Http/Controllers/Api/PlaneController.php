<?php

namespace App\Http\Controllers\Api;

use App\Models\Plane;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlaneController extends Controller
{
    public function index()
    {
        return response()->json(Plane::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'seats' => 'required|integer|min:1',
        ]);

        $plane = Plane::create($request->all());

        return response()->json($plane, 201);
    }

    public function show(Plane $plane)
    {
        return response()->json($plane, 200);
    }

    public function update(Request $request, Plane $plane)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'seats' => 'sometimes|required|integer|min:1',
        ]);

        $plane->update($request->all());

        return response()->json($plane, 200);
    }

    public function destroy(Plane $plane)
    {
        $plane->delete();

        return response()->json(null, 204);
    }
}