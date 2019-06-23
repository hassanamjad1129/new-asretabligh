<?php

namespace App\Models;

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

    public function ProductFiles()
    {
        return $this->hasMany(ProductFile::class, 'product_id');
    }
}
