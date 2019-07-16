<?php

namespace App;

use App\Models\ProductValue;
use Illuminate\Database\Eloquent\Model;

class OrderItemService extends Model
{
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function files()
    {
        return $this->hasOne(OrderItemServiceFile::class);
    }

    public function getData()
    {
        $values = explode('-', $this->data);
        foreach ($values as $value) {
            $value = ServiceValue::find($value);
            if (!$value)
                continue;
            echo ta_persian_num($value->property->name . " : " . $value->name . "<br />");
        }
    }

    public function getType()
    {
        return $this->type == "single" ? "یک رو" : "دو رو";
    }
}
