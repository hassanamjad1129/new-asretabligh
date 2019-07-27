<?php

namespace App;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class discount extends Model
{

    public function customers(){
        return $this->belongsToMany(Customer::class,'customer_discount');
    }

    public function products(){
        return $this->belongsToMany(Product::class,'discount_product');
    }

    public function changeDate($date){
        $dateTime = explode(' ',$date);

        $date = explode('-', $dateTime[0]);

        $shDate = \Morilog\Jalali\CalendarUtils::toJalali($date[0], $date[1], $date[2]);

        return $shDate[0].'/'.$shDate[1].'/'.$shDate[2].' '.$dateTime[1];
    }

    public function hasCustomer(Customer $customer){
        $discountCustomer_id = $this->customers->pluck('id')->toArray();
        if(in_array($customer->id,$discountCustomer_id))
            return 'checked';
    }

    public function hasProducts(Product $product){
        $discountProduct_id = $this->Products->pluck('id')->toArray();
        if(in_array($product->id,$discountProduct_id))
            return 'checked';
    }
}
