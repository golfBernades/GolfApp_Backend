<?php
/**
 * Created by PhpStorm.
 * User: porfirio
 * Date: 4/8/17
 * Time: 6:12 PM
 */

namespace App\Http\Utils;


class HttpResponses
{
    private static function createResponse($code, $message)
    {
        return response()->json(['code' => $code, 'message' => $message]);
    }

    public static function parametrosIncompletosReponse()
    {
        return self::createResponse(400, 'Parámetros incompletos');
    }

    public static function insertadoOkResponse($entidad)
    {
        return self::createResponse(200, 'Registro de ' . $entidad
            . ' insertado');
    }

    public static function eliminadoOkResponse($entidad)
    {
        return self::createResponse(200, 'Registro de ' . $entidad
            . ' eliminado');
    }

    public static function actualizadoOkResponse($entidad)
    {
        return self::createResponse(200, 'Registro de ' . $entidad
            . ' actualizado');
    }

    public static function noEncontradoResponse($entidad)
    {
        return self::createResponse(400, 'Registro de ' . $entidad
            . ' no encontrado');
    }

    public static function errorGuardadoResponse($entidad)
    {
        return self::createResponse(400, 'Error al guardar el registro de ' .
            $entidad);
    }

    public static function errorEliminadoResponse($entidad)
    {
        return self::createResponse(400, 'Error al eliminar el registro de ' .
            $entidad);
    }

    public static function rutaInexistenteResponse()
    {
        return self::createResponse(400, 'Ruta no existente');
    }

    public static function passwordIncorrectaResponse()
    {
        return self::createResponse(400, 'Contraseña incorrecta');
    }

    public static function passwordActualizadaResponse()
    {
        return self::createResponse(200, 'Contraseña actualizada');
    }

    public static function emailExistente()
    {
        return self::createResponse(400, 'El email ya está en uso');
    }
}