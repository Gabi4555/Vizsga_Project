<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CarCategory;



class CarCategoryController extends Controller
{
    //
 public function all() {

         $carCategory = CarCategory::get();

      

        return response()->json($carCategory);

    }
  public function listallid() {
        $carCategory = CarCategory::get();
        
        $ids = $carCategory->pluck('id') ;
        return response()->json( $ids        );

    }
      public function listallname() {
        $carCategory = CarCategory::get();
        
        $names = $carCategory->pluck('name') ;
        return response()->json( $names );

    }      
    


        public function show(Request $request){
        $validated = $request->validate([
            'id' => ['required', 'integer', 'exists:car_category,id']
        ]);
        $carCategory = CarCategory::findOrFail($validated['id']);

        return response()->json([
            'data' => $carCategory
        ]);
    }
     public function store(Request $request) {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:car_category,name']//,
     //       'is_active'=>['boolean']
        ]);
        $carCategory  = CarCategory::create($validated);
        return response()->json([
            'data' => $carCategory 
        ], 201);
    }
     public function update(Request $request) {
        $validated = $request->validate([
            'id' => ['required', 'integer', 'exists:car_category,id'],
            'name' => ['required', 'string', 'max:255'],
          //  'is_active' => ['boolean']
        ]);
            $carCategory = CarCategory::findOrFail($validated['id']);

        $carCategory->update($validated);
        
        return response()->json([
            'data' => $carCategory->fresh()
        ]);
    }
     public function destroy(Request $request){
        $validated = $request->validate([
            'id' => ['required', 'integer', 'exists:car_category,id'],
        ]);

        $carCategory = CarCategory::findOrFail($validated['id']);

        $carCategory->delete();

        return response()->json([
            'messege' => 'Deleted'
        ], 204);
       }


 
}
