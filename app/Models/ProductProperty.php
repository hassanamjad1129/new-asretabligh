<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductProperty extends Model
{
    public function ProductValues()
    {
        return $this->hasMany(ProductValue::class, 'property_id', 'id');
    }

    public function GetProductValue($id)
    {

        return ProductValue::find($id);
    }

    public function GetNameOfProductValue($id)
    {
        return $this->GetProductValue($id)->name;
    }

    public function GetNameOfProductPropertyName($id)
    {
        $property_id = $this->GetProductValue($id)->property_id;
        return ProductProperty::find($property_id)->name;
    }
}
