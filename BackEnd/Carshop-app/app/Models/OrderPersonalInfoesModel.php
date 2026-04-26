<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderPersonalInfoesModel extends Model
{
    /**
     * Define the table name
     */
    protected $table = "orderpersonalinfoes";

    /**
     * Mass assignable fields
     * These store the customer's personal information for an order
     */
    protected $fillable = [
        "order_id",   // Foreign key linking to the main order
        "firstName",  // Customer's first name
        "lastName",   // Customer's last name
    ];

    /**
     * Relationship: Each personal info record belongs to an order
     */
    public function Orders(): BelongsTo {
        return $this->belongsTo(OrdersModel::class, "order_id");
    }
}