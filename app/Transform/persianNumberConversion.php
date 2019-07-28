<?php

namespace App\Transform;

use Illuminate\Foundation\Http\Middleware\TransformsRequest;

class persianNumberConversion extends TransformsRequest
{
    public function transform($key, $value)
    {
        $persian_num = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        $latin_num = range(0, 9);

        $string = str_replace($persian_num, $latin_num, $value);

        return $string;

    }


}
