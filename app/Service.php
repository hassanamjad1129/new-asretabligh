<?php

namespace App;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function haveProductPaper($product, $paper)
    {
        return !!DB::table('product_services')->where('service_id', $this->id)->where('paper_id', $paper)->where('product_id', $product)->count();
    }

    public function Papers()
    {
        return $this->belongsToMany(Paper::class, 'product_services');
    }
}
