<?php

namespace App\Http\Utils;

class RegexValidator
{
    public static function isIntegerNumber($data)
    {
        return preg_match('/^[0-9]+$/', $data);
    }
}