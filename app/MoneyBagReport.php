<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MoneyBagReport extends Model
{
    public function getOperation()
    {
        if ($this->operation == 'increase')
            return "افزایش";
        else
            return "کاهش";

    }
}
