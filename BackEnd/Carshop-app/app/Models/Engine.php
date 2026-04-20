<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Engine extends Model
{
    //
    protected $table = 'engine';
          protected $fillable = [
        'name'

    ];


    public function Car(): HasMany{
        return $this->hasMany(Car::class);
    }
}
