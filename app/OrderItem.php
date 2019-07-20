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

    public function user()
    {
        return $this->belongsTo(Customer::class, 'user_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
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

    public function files()
    {
        return $this->hasOne(OrderItemFile::class);
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

    public function getStatusOptions()
    {
        return [
            'در انتظار پرداخت',
            'تایید مالی',
            'در حال چاپ',
            'آماده تحویل',
            'تحویل داده شده',
        ];
    }

    public function getPaymentType()
    {
        switch ($this->order->payment_method) {
            case "online":
                return "درگاه اینترنتی";
                break;
            case "money_bag":
                return "کیف پول";
                break;
        }
    }

    public function getDeliveryType()
    {
        return $this->order->delivery->name;
    }

    public function getAddress()
    {
        return $this->order->address;
    }

    public function getDeliveries()
    {
        return shipping::all()->pluck('name', 'id');
    }

    public function getLastUpdateDate()
    {
        return jdate(strtotime($this->updated_at))->format('H:i Y/m/d');
    }

}
