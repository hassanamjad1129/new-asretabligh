<?php

namespace App;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_services');
    }

    public function ServiceProperties()
    {
        return $this->hasMany(ServiceProperty::class, 'service_id');
    }
}
