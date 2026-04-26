<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderLocationInfoesModel extends Model
{
    /**
     * Define the table name
     */
    protected $table = "orderlocationinfoes";

    /**
     * Mass assignable fields
     * These fields store delivery/location information for an order
     */
    protected $fillable = [ 
        "order_id", // Foreign key linking to the main order
        "country",  // Customer country
        "city",     // Customer city
        "street",   // Street address
        "house"     // House/building number
    ];

    /**
     * Relationship: Each location info record belongs to an order
     */
    public function Orders(): BelongsTo {
        return $this->belongsTo(OrdersModel::class, "order_id");
    }
}