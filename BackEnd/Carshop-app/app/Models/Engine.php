<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Engine extends Model
{
    /**
     * Define the table name
     * (Laravel would normally expect "engines")
     */
    protected $table = 'engine';

    /**
     * Mass assignable fields
     * These can be set via create() or update()
     */
    protected $fillable = [
        'name' // Engine type/name (e.g., V6, V8, Electric, Hybrid)
    ];

    /**
     * Relationship: An engine can be used in many cars
     */
    public function Car(): HasMany {
        return $this->hasMany(Car::class);
    }
}