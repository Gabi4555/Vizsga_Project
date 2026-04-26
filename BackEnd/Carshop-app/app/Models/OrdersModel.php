<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrdersModel extends Model
{
    /**
     * Define the table name
     */
    protected $table = "orders";

    /**
     * Mass assignable fields
     * These represent the main order data
     */
    protected $fillable = [ 
        "payment_method", // Payment type used (e.g. card, cash)
        "stage",          // Order status stage (e.g. pending, processing, completed)
        "delivered"       // Whether the order has been delivered
    ];

    /**
     * Attribute casting
     * Ensures "delivered" is always treated as a boolean
     */
    protected $casts = [ 
        "delivered" => "bool"
    ];

    /**
     * Relationship: An order has many order items
     */
    public function orderItems(): HasMany {
        return $this->hasMany(OrderItemsModel::class, "order_id");
    }

    /**
     * Relationship: An order has one or more location info records
     */
    public function orderLocationInfoes(): HasMany {
        return $this->hasMany(OrderLocationInfoesModel::class, "order_id");
    }

    /**
     * Relationship: An order has one or more personal info records
     */
    public function orderPersonalInfoes(): HasMany {
        return $this->hasMany(OrderPersonalInfoesModel::class, "order_id");
    }
}