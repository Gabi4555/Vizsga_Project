<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItemsModel extends Model
{
    /**
     * Define the table name
     */
    protected $table = "orderitems";

    /**
     * Mass assignable fields
     * These can be filled using create() or update()
     */
    protected $fillable = [
        "order_id", // Foreign key to orders table
        "car_id",   // Foreign key to car table
        "quantity"  // Quantity of this car in the order
    ];

    /**
     * Relationship: Each order item belongs to an order
     */
    public function Orders(): BelongsTo {
        return $this->belongsTo(OrdersModel::class, "order_id");
    }

    /**
     * Relationship: Each order item belongs to a car
     */
    public function Weapons(): BelongsTo { 
        return $this->belongsTo(Car::class, "car_id");
    }
}