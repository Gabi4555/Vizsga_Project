<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrdersModel;
use App\Models\OrderItemsModel;
use App\Models\OrderLocationInfoesModel;
use App\Models\OrderPersonalInfoesModel;

class OrderController extends Controller
{
    /**
     * Show a single order by ID
     */
    public function show(Request $request){
        // Validate request to ensure ID exists in orders table
        $validated = $request->validate([
            'id' => ['required', 'integer', 'exists:orders,id']
        ]);

        // Retrieve order or fail with 404
        $orders = OrdersModel::findOrFail($validated['id']);

        // Return order data
        return response()->json([
            'data' => $orders
        ]);
    }

    /**
     * Create a new order with related data (personal info, location, items)
     */
    public function store(Request $request) {
        // Validate incoming request data
        $validated = $request->validate([
            'payment_method' => ['required', 'string'],
            'country' => ['required', 'string'],
            'city' => ['required', 'string'],
            'street' => ['required', 'string'],
            'cars' => 'required|array', 
            'data*' => 'integer', 
            'house' => ['required', 'string'],
            'firstName' => ['required', 'string'],
            'lastName' => ['required', 'string']
        ]);

        // Copy validated data for reuse
        $createdata = $validated;

        // Create main order record
        $orders = OrdersModel::create($validated);

        // Add order_id to data for related tables
        $createdata = array_merge($createdata, [
            'order_id' => $orders->id
        ]);

        // Create personal info record linked to order
        $personal = OrderPersonalInfoesModel::create($createdata);

        // Create location info record linked to order
        $location = OrderLocationInfoesModel::create($createdata);

        // Prepare array to store created order items
        $items = [];

        // Loop through cars array (car_id => quantity)
        foreach ($validated['cars'] as $car_id => $quantity) {

            // Merge order_id with item-specific data
            $itemcreate = array_merge($createdata, [
                'car_id' => $car_id,
                'quantity' => $quantity,
            ]);

            // Create order item record
            $items[] = OrderItemsModel::create($itemcreate);
        }

        // Return combined response of all created data
        return response()->json([
            'data' => collect($orders)
                ->merge($personal)
                ->merge($location)
                ->merge($items)
                ->toArray()
        ], 201);
    }
}