<?php

namespace App;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }


}
