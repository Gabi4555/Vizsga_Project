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
    //
          public function show(Request $request){
        $validated = $request->validate([
            'id' => ['required', 'integer', 'exists:orders,id']
        ]);
        $orders = OrdersModel::findOrFail($validated['id']);

        return response()->json([
            'data' => $orders
        ]);
    }

         public function store(Request $request) {
        $validated = $request->validate([
            'payment_method' => ['required', "string"],
            "country"=> ["required", "string"],
            "city" => ["required", "string"],
            "street"=> ["required", "string"],
            "house"=> ["required", "string"],
            "firstName"=> ["required", "string"],
            "lastName"=> ["required", "string"]
    
        ]);

    $createdata = $validated;

           $orders  = OrdersModel::create($validated);
      $createdata = array_merge($createdata, [
    'order_id' => $orders->id
]);

   $personal = OrderPersonalInfoesModel::create($createdata);
    $location = OrderLocationInfoesModel::create($createdata);

        return response()->json([
            'data' => collect($orders)
    ->merge($personal)
    ->merge($location)
    ->toArray()
        ], 201);}

}
