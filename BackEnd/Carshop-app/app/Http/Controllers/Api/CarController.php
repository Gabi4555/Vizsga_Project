<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Car;
use Illuminate\Support\Facades\DB;
class CarController extends Controller
{
    //

    
public function allcategory(Request $request) {
    $validated = $request->validate([
        'name' => ['required', 'string', 'exists:car_category,name']
    ]);

    

    $cars = Car::with('carCategory', 'brand' ,'Engine' ,'drive')
        ->whereHas('carCategory', function ($query) use ($validated) {
            $query->where('name', $validated['name']);
        })
        ->get();

    return response()->json($cars);
}


        public function show(Request $request) {
        $validated = $request->validate([
            'id' => ['required', 'integer' , 'exists:car,id']
        ]);
        $item = Car::with('carCategory', 'brand' ,'Engine' ,'drive')->findOrFail($validated['id']);
        return response()->json([
          $item
        ]);
    }

    public function all() {

        $cars = Car::with('carCategory' , 'brand' ,'Engine' ,'drive') ->get();

      

        return response()->json($cars);

    }

    public function listallid() {
        $cars = Car::with('carCategory' , 'brand' ,'Engine' ,'drive') ->get();
        
        $ids = $cars->pluck('id') ;
        return response()->json( $ids        );

    }
        public function listallname() {
        $cars = Car::with('carCategory' , 'brand' ,'Engine' ,'drive') ->get();
        
        $names = $cars->pluck('name') ;
        return response()->json( $names );

    }                  

     public function update(Request $request) {
        $validated = $request->validate([
            'id' => ['required', 'integer', 'exists:car,id'],
            'car_category_id' => ['required', 'integer', 'exists:car_category,id'],
             'brand_id' => ['required', 'integer', 'exists:brand,id'],
               'engine_id' => ['required', 'integer', 'exists:engine,id'],
               'drive_id' => ['required', 'integer', 'exists:drive,id'],
            'name' => ['required', 'string' ],
           'year' => ['required', 'digits:4'],
            'fuel_efficiency' =>  ['required', 'string' ],
             'price' => ['required', 'string'],
             'speed' => ['required', 'string'],
             'acceleration' => ['required', 'string']
     
        ]);
            $cars = Car::findOrFail($validated['id']);

        $cars->update($validated);
        
        return response()->json([
            'data' => $cars->fresh()
        ]);
     }

 public function store(Request $request) {
        $validated = $request->validate([
           'car_category_id' => ['required', 'integer', 'exists:car_category,id'],
             'brand_id' => ['required', 'integer', 'exists:brand,id'],
               'engine_id' => ['required', 'integer', 'exists:engine,id'],
               'drive_id' => ['required', 'integer', 'exists:drive,id'],
            'name' => ['required', 'string' ],
           'year' => ['required', 'digits:4', 'integer', 'between:1901,2155'],
            'fuel_efficiency' =>  ['required', 'string' ],
             'price' => ['required', 'string'],
             'speed' => ['required', 'string'],
             'acceleration' => ['required', 'string'],

        ]);
        $cars  = Car::create($validated);
        return response()->json([
            'data' => $cars 
        ], 201);
    }



     public function search(Request $request) { 
  $validated = $request->validate([
        'name' => ['required', 'string']
    ]);

    

    $cars = Car::with('carCategory' , 'brand' ,'Engine' ,'drive')
        ->where('name','LIKE','%'. $request['name'] .'%')
        
        ->get();

    return response()->json($cars);

     }

        public function destroy(Request $request){
            $validated = $request->validate([
            'id' => ['required', 'integer' , 'exists:car,id']
        ]);

        $weaponcategory = Car::findOrFail($validated['id']);

        $weaponcategory->delete();

        return response()->json([
            'messege' => 'Deleted'
        ], 204);
       }

}
