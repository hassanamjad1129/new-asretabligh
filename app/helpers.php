<?php
if (!function_exists('ta_persian_num')) {
    function ta_persian_num($string)
    {
        $persian_num = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        $latin_num = range(0, 9);
        $string = str_replace($latin_num, $persian_num, $string);
        return $string;
    }

}