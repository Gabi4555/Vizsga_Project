<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Car extends Model
{
    //
 
    protected $table = 'car';
     protected $fillable = [
        'car_category_id',
        'name',
        'brand_id',
        'engine_id',
        'drive_id',
        'year',
        'fuel_efficiency',
        'price',
        'speed',
        'acceleration'

        

       // 'is_available'

/*

*/

    ];



        public function Brand(): BelongsTo{
        return $this->belongsTo(Brand::class);
    }

         public function carCategory(): BelongsTo{
        return $this->belongsTo(CarCategory::class);
    }

    public function Engine(): BelongsTo{ 
        return $this->belongsTo(Engine::class);
    }

     public function Drive(): BelongsTo{ 
        return $this->belongsTo(Drive::class);
    }

}
