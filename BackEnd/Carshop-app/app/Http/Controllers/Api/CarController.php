<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Car;
use Illuminate\Support\Facades\DB;

class CarController extends Controller
{
    /**
     * Get all cars filtered by category name
     */
    public function allcategory(Request $request) {
        // Validate that category name exists in car_category table
        $validated = $request->validate([
            'name' => ['required', 'string', 'exists:car_category,name']
        ]);

        // Fetch cars with related models, filtered by category name
        $cars = Car::with('carCategory', 'brand', 'Engine', 'drive')
            ->whereHas('carCategory', function ($query) use ($validated) {
                $query->where('name', $validated['name']);
            })
            ->get();

        // Return result as JSON
        return response()->json($cars);
    }

    /**
     * Get a single car by ID
     */
    public function show(Request $request) {
        // Validate request
        $validated = $request->validate([
            'id' => ['required', 'integer', 'exists:car,id']
        ]);

        // Find car with relationships or fail
        $item = Car::with('carCategory', 'brand', 'Engine', 'drive')
            ->findOrFail($validated['id']);

        // Return car data
        return response()->json([
            $item
        ]);
    }

    /**
     * Get all cars with related data
     */
    public function all() {
        // Fetch all cars with relationships
        $cars = Car::with('carCategory', 'brand', 'Engine', 'drive')->get();

        // Return as JSON
        return response()->json($cars);
    }

    /**
     * Get only IDs of all cars
     */
    public function listallid() {
        // Fetch all cars
        $cars = Car::with('carCategory', 'brand', 'Engine', 'drive')->get();
        
        // Extract IDs
        $ids = $cars->pluck('id');

        // Return IDs
        return response()->json($ids);
    }

    /**
     * Get only names of all cars
     */
    public function listallname() {
        // Fetch all cars
        $cars = Car::with('carCategory', 'brand', 'Engine', 'drive')->get();
        
        // Extract names
        $names = $cars->pluck('name');

        // Return names
        return response()->json($names);
    }                  

    /**
     * Update an existing car
     */
    public function update(Request $request) {
        // Validate incoming data
        $validated = $request->validate([
            'id' => ['required', 'integer', 'exists:car,id'],
            'car_category_id' => ['required', 'integer', 'exists:car_category,id'],
            'brand_id' => ['required', 'integer', 'exists:brand,id'],
            'engine_id' => ['required', 'integer', 'exists:engine,id'],
            'drive_id' => ['required', 'integer', 'exists:drive,id'],
            'name' => ['required', 'string'],
            'year' => ['required', 'digits:4'],
            'fuel_efficiency' => ['required', 'string'],
            'price' => ['required', 'string'],
            'speed' => ['required', 'string'],
            'acceleration' => ['required', 'string']
        ]);

        // Find the car or fail
        $cars = Car::findOrFail($validated['id']);

        // Update car with validated data
        $cars->update($validated);
        
        // Return updated (fresh) record
        return response()->json([
            'data' => $cars->fresh()
        ]);
    }

    /**
     * Create a new car
     */
    public function store(Request $request) {
        // Validate input data
        $validated = $request->validate([
            'car_category_id' => ['required', 'integer', 'exists:car_category,id'],
            'brand_id' => ['required', 'integer', 'exists:brand,id'],
            'engine_id' => ['required', 'integer', 'exists:engine,id'],
            'drive_id' => ['required', 'integer', 'exists:drive,id'],
            'name' => ['required', 'string'],
            'year' => ['required', 'digits:4', 'integer', 'between:1901,2155'],
            'fuel_efficiency' => ['required', 'string'],
            'price' => ['required', 'string'],
            'speed' => ['required', 'string'],
            'acceleration' => ['required', 'string'],
        ]);

        // Create new car
        $cars = Car::create($validated);

        // Return created car with 201 status
        return response()->json([
            'data' => $cars 
        ], 201);
    }

    /**
     * Search cars by name (partial match)
     */
    public function search(Request $request) { 
        // Validate search input
        $validated = $request->validate([
            'name' => ['required', 'string']
        ]);

        // Perform LIKE query for partial name match
        $cars = Car::with('carCategory', 'brand', 'Engine', 'drive')
            ->where('name', 'LIKE', '%' . $request['name'] . '%')
            ->get();

        // Return matching cars
        return response()->json($cars);
    }

    /**
     * Delete a car by ID
     */
    public function destroy(Request $request){
        // Validate request
        $validated = $request->validate([
            'id' => ['required', 'integer', 'exists:car,id']
        ]);

        // Find car or fail
        $weaponcategory = Car::findOrFail($validated['id']);

        // Delete car
        $weaponcategory->delete();

        // Return response (204 = No Content)
        return response()->json([
            'messege' => 'Deleted'
        ], 204);
    }
}