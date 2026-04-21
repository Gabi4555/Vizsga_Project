<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItemsModel extends Model
{
    //

    protected $table = "orderitems";

    protected $fillable = [
        "order_id",
        "car_id",
        "quantity"
    

     ];

   


    public function Orders(): BelongsTo {
        return $this->belongsTo(OrdersModel::class, "order_id");
    }

    public function Weapons(): BelongsTo { 
        return $this->belongsTo(Car::class, "weapon_id");
    }
}
