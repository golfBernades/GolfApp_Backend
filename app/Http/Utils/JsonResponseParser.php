<?php
/**
 * Created by PhpStorm.
 * User: porfirio
 * Date: 4/12/17
 * Time: 7:06 PM
 */

namespace App\Http\Utils;


use Illuminate\Http\JsonResponse;

class JsonResponseParser
{
    public static function parse(JsonResponse $response)
    {
        $isArray = strpos($response, '[');

        if ($isArray === false)
            $keyIndex = strpos($response, '{');
        else
            $keyIndex = strpos($response, '[');

        // Extrae la subcadena con la respuesta JSON
        $jsonSubstring = substr($response, $keyIndex);
        // Parsea el JSON obtenido
        $responseData = json_decode($jsonSubstring);
        return $responseData;
    }
}