<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Drive extends Model
{
    /**
     * Define the table name
     * (Laravel would normally expect "drives")
     */
    protected $table = 'drive';

    /**
     * Mass assignable fields
     * These fields can be filled using create() or update()
     */
    protected $fillable = [
        'name' // Drive type (e.g., FWD, RWD, AWD)
    ];

    /**
     * Relationship: A drive type has many cars
     */
    public function Car(): HasMany {
        return $this->hasMany(Car::class);
    }
}