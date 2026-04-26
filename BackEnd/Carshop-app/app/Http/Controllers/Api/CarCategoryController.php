<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CarCategory;

class CarCategoryController extends Controller
{
    /**
     * Get all car categories
     */
    public function all() {
        // Retrieve all records from car_category table
        $carCategory = CarCategory::get();

        // Return as JSON response
        return response()->json($carCategory);
    }

    /**
     * Get only IDs of all car categories
     */
    public function listallid() {
        // Get all categories
        $carCategory = CarCategory::get();
        
        // Extract only the 'id' column values
        $ids = $carCategory->pluck('id');

        // Return IDs as JSON
        return response()->json($ids);
    }

    /**
     * Get only names of all car categories
     */
    public function listallname() {
        // Get all categories
        $carCategory = CarCategory::get();
        
        // Extract only the 'name' column values
        $names = $carCategory->pluck('name');

        // Return names as JSON
        return response()->json($names);
    }      

    /**
     * Show a single car category by ID
     */
    public function show(Request $request){
        // Validate incoming request
        $validated = $request->validate([
            'id' => ['required', 'integer', 'exists:car_category,id']
        ]);

        // Find the category or fail with 404
        $carCategory = CarCategory::findOrFail($validated['id']);

        // Return the found category
        return response()->json([
            'data' => $carCategory
        ]);
    }

    /**
     * Store a new car category
     */
    public function store(Request $request) {
        // Validate input data
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:car_category,name']
            // 'is_active' => ['boolean'] // Optional field (currently disabled)
        ]);

        // Create new category
        $carCategory  = CarCategory::create($validated);

        // Return created resource with 201 status
        return response()->json([
            'data' => $carCategory 
        ], 201);
    }

    /**
     * Update an existing car category
     */
    public function update(Request $request) {
        // Validate input data
        $validated = $request->validate([
            'id' => ['required', 'integer', 'exists:car_category,id'],
            'name' => ['required', 'string', 'max:255'],
            // 'is_active' => ['boolean'] // Optional field
        ]);

        // Find category or fail
        $carCategory = CarCategory::findOrFail($validated['id']);

        // Update category with validated data
        $carCategory->update($validated);
        
        // Return updated (fresh) data
        return response()->json([
            'data' => $carCategory->fresh()
        ]);
    }

    /**
     * Delete a car category
     */
    public function destroy(Request $request){
        // Validate request
        $validated = $request->validate([
            'id' => ['required', 'integer', 'exists:car_category,id'],
        ]);

        // Find category or fail
        $carCategory = CarCategory::findOrFail($validated['id']);

        // Delete the category
        $carCategory->delete();

        // Return response (204 = No Content)
        return response()->json([
            'messege' => 'Deleted'
        ], 204);
    }
}