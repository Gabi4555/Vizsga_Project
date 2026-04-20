<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Agility extends Model
{
    //
 protected $table = 'agility';
      protected $fillable = [
        'name'

    ];


    public function Car(): HasMany{
        return $this->hasMany(Car::class);
    }
}
