<?php

namespace App\Http\Utils;


class FieldValidator
{
    public static function validateIntegerParameterURL($name, $value)
    {
        if (RegexValidator::isIntegerNumber($value)) {
            return JsonResponses::jsonResponse(200, [
                'parametro_valido' => true
            ]);
        } else {
            return JsonResponses::jsonResponse(400, [
                'error_message' => 'El parámetro "' . $name
                    . '" debe ser un entero'
            ]);
        }
    }
}