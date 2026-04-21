<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class OrderPersonalInfoesModel extends Model
{
    //
    protected $table = "orderpersonalinfoes";
       protected $fillable = [
        "order_id",
        "firstName",
        "lastName",
    
        ];


    public function Orders(): BelongsTo {
        return $this->belongsTo(OrdersModel::class, "order_id");
    }
}
