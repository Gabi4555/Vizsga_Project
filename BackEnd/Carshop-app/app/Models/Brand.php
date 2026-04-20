<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Brand extends Model
{
    //
 protected $table = 'brand';
          protected $fillable = [
        'name'
        

    ];


    public function Car(): HasMany{
        return $this->hasMany(Car::class);
    }
}
