<?php

namespace App;

use App\Models\ProductProperty;
use Illuminate\Database\Eloquent\Model;

class ServicePrice extends Model
{

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

}
