<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Car extends Model
{
    //
 protected $table = 'car';
     protected $fillable = [
        'weaponcategories_Id',
        'name'
        

       // 'is_available'

/*

*/

    ];

 public function Agility(): BelongsTo{
        return $this->belongsTo(Agility::class );
    }

        public function Brand(): BelongsTo{
        return $this->belongsTo(Brand::class);
    }

         public function CarCategory(): BelongsTo{
        return $this->belongsTo(CarCategory::class);
    }

    public function Engine(): BelongsTo{ 
        return $this->belongsTo(Engine::class);
    }

     public function Drive(): BelongsTo{ 
        return $this->belongsTo(Drive::class);
    }

}
