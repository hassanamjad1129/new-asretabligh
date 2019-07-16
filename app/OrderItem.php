<?php

namespace App;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductValue;
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

    public function paper()
    {
        return $this->belongsTo(Paper::class);
    }

    public function services()
    {
        return $this->hasMany(OrderItemService::class);
    }

    public function getData()
    {
        $values = explode('-', $this->data);
        foreach ($values as $value) {
            $value = ProductValue::find($value);
            if (!$value)
                continue;
            echo $value->property->name . " : " . $value->name . "<br />";
        }
    }

    public function getTotalPrice()
    {
        $sum = $this->price;
        foreach ($this->services as $service)
            $sum += $service->price;
        return $sum;
    }

    public function getType()
    {
        return $this->type == 'single' ? "یک رو" : "دو رو";
    }

}
