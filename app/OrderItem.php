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
            echo ta_persian_num($value->property->name . " : " . $value->name . "<br />");
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

    public function getStatus()
    {
        switch ($this->status) {
            case 1:
                return "تایید مالی";
                break;
            case 2:
                return "در حال انجام";
                break;
            case 3:
                return "آماده تحویل";
                break;
            case 4:
                return "تحویل داده شده";
                break;
        }
    }

    public function getPaperName()
    {
        return ta_persian_num($this->paper->name);
    }

    public function getOrderDate()
    {
        return ta_persian_num(jdate(strtotime($this->created_at))->format('H:i Y/m/d'));
    }

}
