<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class post extends Model
{
    public function categories()
    {
        return $this->belongsToMany(pCategory::class, 'category_posts', 'post_id', 'category_id');
    }
}
