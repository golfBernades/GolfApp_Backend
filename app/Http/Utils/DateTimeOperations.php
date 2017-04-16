<?php
/**
 * Created by PhpStorm.
 * User: porfirio
 * Date: 4/16/17
 * Time: 3:46 PM
 */

namespace App\Http\Utils;


class DateTimeOperations
{
    public static function getDifferenceInHours($datetime1, $datetime2)
    {
        $diferencia = strtotime($datetime1->format('Y-m-d H:i:s'))
            - strtotime($datetime2->format('Y-m-d H:i:s'));
        $diferencia = abs($diferencia / 3600);
        return $diferencia;
    }
}