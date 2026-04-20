<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Drive extends Model
{
    //
    protected $table = 'frame';
          protected $fillable = [
        'name'

    ];


    public function Car(): HasMany{
        return $this->hasMany(Car::class);
    }
}
