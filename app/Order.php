<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function delivery()
    {
        return $this->belongsTo(shipping::class, 'delivery_method');
    }

}
