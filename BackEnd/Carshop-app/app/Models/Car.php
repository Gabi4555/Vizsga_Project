<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Car extends Model
{
    /**
     * Define the table associated with the model
     * (since Laravel would normally expect "cars")
     */
    protected $table = 'car';

    /**
     * Mass assignable fields
     * These fields can be filled using create() or update()
     */
    protected $fillable = [
        'car_category_id',   // Foreign key to car_category table
        'name',              // Car name/model
        'brand_id',          // Foreign key to brand table
        'engine_id',         // Foreign key to engine table
        'drive_id',          // Foreign key to drive table
        'year',              // Production year
        'fuel_efficiency',   // Fuel consumption info
        'price',             // Car price
        'speed',             // Top speed
        'acceleration'       // Acceleration performance (e.g., 0-100 km/h)

    
        
    ];

    /**
     * Relationship: Car belongs to a Brand
     */
    public function Brand(): BelongsTo {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Relationship: Car belongs to a Category
     */
    public function carCategory(): BelongsTo {
        return $this->belongsTo(CarCategory::class);
    }

    /**
     * Relationship: Car belongs to an Engine
     */
    public function Engine(): BelongsTo { 
        return $this->belongsTo(Engine::class);
    }

    /**
     * Relationship: Car belongs to a Drive type
     */
    public function Drive(): BelongsTo { 
        return $this->belongsTo(Drive::class);
    }
}