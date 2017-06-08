<?php

namespace App\Http\Utils;

use Illuminate\Http\JsonResponse;

class JsonResponses
{
    public static function jsonResponse($code, $params)
    {
        $jsonResponse = response()->json($params);
        $jsonResponse->setStatusCode($code);
        return $jsonResponse;
    }

    public static  function parametrosIncompletosResponse($requiredParams)
    {
        return JsonResponses::jsonResponse(400, [
            'error_message' => 'Parámetros incompletos, se requieren los '
                . 'siguientes parámetros: ['
                . implode(', ', $requiredParams)
                . ']'
        ]);
    }

    public static  function codigoDesconocidoResponse(JsonResponse $response)
    {
        return JsonResponses::jsonResponse($response->getStatusCode(), [
            'error_message' => 'Error de tipo '
                . $response->getStatusCode()
        ]);
    }
}