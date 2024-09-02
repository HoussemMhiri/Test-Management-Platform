<?php

use Illuminate\Support\Facades\DB;

if (!function_exists('toHumanDate')) {
    function toHumanDate($date, $with_time = false)
    {
        $format = 'dddd D MMMM YYYY';
        if ($with_time) {
            $format .= ', HH:mm';
        }

        return $date->isoFormat($format);
    }
}

if (!function_exists('toSimpleHumanDate')) {
    function toSimpleHumanDate($date, $with_time = false)
    {
        $format = 'D MMMM YYYY';
        if ($with_time) {
            $format .= ' HH:mm';
        }

        return $date->isoFormat($format);
    }
}

if (!function_exists('imageToBase64')) {
    function imageToBase64($image_path)
    {
        $data = file_get_contents($image_path);

        $type = pathinfo($image_path, PATHINFO_EXTENSION);

        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }
}

if (!function_exists('convertNumberToWords')) {
    function convertNumberToWords($number, $locale)
    {
        $digits = new NumberFormatter($locale, NumberFormatter::SPELLOUT);

        return $digits->format($number);
    }
}

if (!function_exists('diffDate')) {
    function diffDate($date)
    {
        return $date->diffForHumans();
    }
}

if (!function_exists('generateRandomPassword')) {
    function generateRandomPassword($length = 8)
    {

        $chars =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz' . '0123456789`-=~!@#$%^&*()_+,./<>?;:[]{}\|';

        $str = '';
        $max = strlen($chars) - 1;

        for ($i = 0; $i < $length; $i++) {
            $str .= $chars[random_int(0, $max)];
        }

        return $str;
    }
}

function renderInlineError($key, $errors = null)
{
    if ($errors == null)
        $errors = view()->shared('errors');

    if ($errors->has($key))
        return new \Illuminate\Support\HtmlString('<small class="error-message">' . $errors->first($key) . '</small>');

    return '';
}

if (!function_exists('generateRandomCode')) {
    function generateRandomCode($length = 5)
    {
        $digits = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = '';
        for ($i = 0; $i < $length; $i++) {
            $code .= $digits[rand(0, strlen($digits) - 1)];
        }
        return $code;
    }
}

if (!function_exists('generateUniqueRandomCode')) {
    function generateUniqueRandomCode($table, $column, $length = 5)
    {
        do {
            $code = generateRandomCode($length);
            $exists = DB::table($table)->where($column, $code)->exists();
        } while ($exists);

        return $code;
    }
}
