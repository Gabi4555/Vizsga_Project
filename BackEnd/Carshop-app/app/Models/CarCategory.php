<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CarCategory extends Model
{
    /**
     * Define the table name
     * (Laravel would normally expect "car_categories")
     */
    protected $table = 'car_category';

    /**
     * Mass assignable fields
     * These fields can be filled using create() or update()
     */
    protected $fillable = [
        'name' // Category name (e.g., SUV, Sedan, Coupe)
    ];

    /**
     * Relationship: A category has many cars
     */
    public function Car(): HasMany {
        return $this->hasMany(Car::class);
    }
}