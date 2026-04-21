<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderLocationInfoesModel extends Model
{
    //
    protected $table = "orderlocationinfoes";
       protected $fillable = [ 
        "order_id",
        "country",
        "city",
        "street",
        "house"

       ];


    public function Orders(): BelongsTo {
        return $this->belongsTo(OrdersModel::class, "order_id");
    }
}
