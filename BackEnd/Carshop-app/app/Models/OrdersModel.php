<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class OrdersModel extends Model
{
    //

    protected $table = "orders";
    protected $fillable = [ 

    "payment_method",
    "stage",
    "delivered"
    ];

      protected $casts = [ 
        "delivered" => "bool"
     ];

       public function orderItems(): HasMany{
        return $this->hasMany(OrderItemsModel::class, "order_id" );
    }
           public function orderLocationInfoes(): HasMany{
        return $this->hasMany(OrderLocationInfoesModel::class, "order_id");

    }

               public function orderPersonalInfoes(): HasMany{
        return $this->hasMany(OrderPersonalInfoesModel::class, "order_id");
        
    }

}
