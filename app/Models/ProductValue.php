<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductValue extends Model
{
    public function property()
    {
        return $this->belongsTo(ProductProperty::class,'property_id');
    }
}
