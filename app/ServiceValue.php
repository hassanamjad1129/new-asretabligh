<?php

namespace App;

use App\Models\ProductProperty;
use Illuminate\Database\Eloquent\Model;

class ServiceValue extends Model
{
    public function property()
    {
        return $this->belongsTo(ServiceProperty::class, 'property_id');
    }
}
