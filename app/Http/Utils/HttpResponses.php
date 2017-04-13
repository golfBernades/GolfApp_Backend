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

    public static function errorActualizadoResponse($entidad)
    {
        return self::createResponse(400, 'Error al actualizar  el registro de ' .
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

    public static function jugadorNoEnPartido()
    {
        return self::createResponse(400,
            'El jugador no está participando en el partido');
    }

    public static function partidoVaciadoOk()
    {
        return self::createResponse(200,
            'Se vaciaron los registros asociados al partido');
    }

    public static function partidoVaciadoError()
    {
        return self::createResponse(400,
            'Error al vaciar los registros asociados al partido');
    }

    public static function noRegistrosDePartido()
    {
        return self::createResponse(400,
            'No hay registros asociados al partido');
    }

    public static function apuestaNoEnPartido()
    {
        return self::createResponse(400,
            'La apuesta no se está llevando a cabo en el partido');
    }

    public static function hoyoRangoInvalido()
    {
        return self::createResponse(400,
            'El hoyo especificado está fuera del rango');
    }

    public static function golpesValorInvalido()
    {
        return self::createResponse(400,
            'El valor de los golpes es inválido');
    }

    public static function unidadesValorInvalido()
    {
        return self::createResponse(400,
            'El valor de las unidades es inválido');
    }

    public static function noPuntosJugadorPartidoHoyo()
    {
        return self::createResponse(400,
            'No hay puntuaciones registradas con los parámetros dados');
    }
}