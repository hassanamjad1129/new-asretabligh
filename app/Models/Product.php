<?php

namespace App\Models;

use App\Service;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function ProductProperties()
    {
        return $this->hasMany(ProductProperty::class, 'product_id');
    }


    public function services()
    {
        return $this->belongsToMany(Service::class, 'product_services');
    }
}
