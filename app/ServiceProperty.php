<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceProperty extends Model
{
    public function ServiceValues()
    {
        return $this->hasMany(ServiceValue::class, 'property_id', 'id');
    }

    public function GetServiceValue($id)
    {

        return ServiceValue::find($id);
    }

    public function GetNameOfServiceValue($id)
    {
        return $this->GetServiceValue($id)->name;
    }

    public function GetNameOfServicePropertyName($id)
    {
        $property_id = $this->GetServiceValue($id)->property_id;
        return ServiceProperty::find($property_id)->name;
    }
}
