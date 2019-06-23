<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function allCategories()
    {
        $categories = Category::all();
        return $categories;
    }
}
