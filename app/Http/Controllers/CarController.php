<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index()
    {
        return response()->json(Car::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'friend_name' => 'required',
            'car_type' => 'required',
            'car_cost' => 'required|numeric',
            'date_bought' => 'required|date',
        ]);

        Car::create($request->all());
        return response()->json(['message' => 'Car added successfully.'], 201); // Return JSON for API
    }

    public function show($id)
    {
        $car = Car::find($id);
        return response()->json($car); // Return JSON for API
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'friend_name' => 'required|string|max:255',
            'car_type' => 'required|string|max:255',
            'car_cost' => 'required|string', // Validate as string, will clean and convert
            'date_bought' => 'required|date',
        ]);

        $car = Car::find($id);

        $carCost = $request->input('car_cost');
        $carCost = str_replace(['R', ',', ' '], '', $carCost); // Remove 'R', commas, and spaces
        $carCost = (float) $carCost; // Convert to float

        $car->friend_name = $request->input('friend_name');
        $car->car_type = $request->input('car_type');
        $car->car_cost = $carCost;
        $car->date_bought = $request->input('date_bought');

        $car->save();

        return response()->json(['message' => 'Car updated successfully.']);
    }

    public function destroy($id)
    {
        $car = Car::findOrFail($id);
        $car->delete();

        return response()->json(['message' => 'Car deleted successfully.']);
    }

    public function deleteAllCars()
{
    Car::truncate(); // Delete all records and reset the auto-increment ID
    
    return response()->json(['message' => 'All cars deleted successfully.'], 200);
}

}
