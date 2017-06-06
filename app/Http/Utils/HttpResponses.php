<?php

namespace App\Http\Utils;


class HttpResponses
{
    /*
    ----------------------------------------------------------------------------
    Responses generales
    ----------------------------------------------------------------------------
    */

    private static function createResponse($code, $message)
    {
        return response()->json(['code' => $code, 'message' => $message]);
    }

    public static function parametrosIncompletosReponse()
    {
        return self::createResponse(400, 'Parámetros incompletos');
    }

    public static function rutaInexistenteResponse()
    {
        return self::createResponse(400, 'Ruta inexistente');
    }

    public static function parametroTipoInvalido()
    {
        return self::createResponse(400, 'El parámetro es de un tipo inválido');
    }

    public static function okResponse()
    {
        return self::createResponse(200, 'OK');
    }


    /*
    ----------------------------------------------------------------------------
    Responses de CRUDS simples
    ----------------------------------------------------------------------------
    */

    public static function partidoInsertadoOkResponse($claveConsulta,
                                                      $claveEdicion)
    {
        return response()->json(['code' => 200,
            'message' => 'El partido fue creado correctamente',
            'clave_consulta' => $claveConsulta,
            'clave_edicion' => $claveEdicion
        ]);
    }

    public static function noEncontradoResponse($entidad)
    {
        return self::createResponse(400, 'Registro de ' . $entidad
            . ' no encontrado');
    }

    public static function insertadoOkResponse($entidad, $id)
    {
        return response()->json(['code' => 200, 'message' => 'Registro de '
            . $entidad . ' insertado correctamente', 'id' => $id]);
    }

    public static function insertadoErrorResponse($entidad)
    {
        return self::createResponse(400, 'Error al guardar el registro de ' .
            $entidad);
    }

    public static function actualizadoOkResponse($entidad)
    {
        return self::createResponse(200, 'Registro de ' . $entidad
            . ' actualizado');
    }

    public static function actualizadoErrorResponse($entidad)
    {
        return self::createResponse(400, 'Error al actualizar el registro de ' .
            $entidad);
    }

    public static function eliminadoOkResponse($entidad)
    {
        return self::createResponse(200, 'Registro de ' . $entidad
            . ' eliminado');
    }

    public static function eliminadoErrorResponse($entidad)
    {
        return self::createResponse(400, 'Error al eliminar el registro de ' .
            $entidad);
    }

    /*
    ----------------------------------------------------------------------------
    Responses de autenticación y validación de usuarios
    ----------------------------------------------------------------------------
    */

    public static function claveConsultaErrorResponse()
    {
        return self::createResponse(400,
            'La clave de consulta del partido es incorrecta');
    }

    public static function claveEdicionErrorResponse()
    {
        return self::createResponse(400,
            'La clave de edición del partido es incorrecta');
    }

    public static function claveConsultaOkResponse()
    {
        return self::createResponse(200,
            'La clave de consulta del partido es correcta');
    }

    public static function claveEdicionEOkResponse()
    {
        return self::createResponse(200,
            'La clave de edición del partido es correcta');
    }

    public static function loginOkResponse()
    {
        return self::createResponse(200,
            'El usuario se logueó correctamente');
    }

    public static function loginErrorResponse()
    {
        return self::createResponse(400,
            'Los datos de loguin son incorrectos');
    }

    public static function emailEnUso()
    {
        return self::createResponse(400, 'El email ya se está usando');
    }

    public static function propietarioCampoErrorResponse()
    {
        return self::createResponse(400,
            'El usuario dado no es el propietario del campo');
    }

    public static function propietarioCampoOkResponse()
    {
        return self::createResponse(200,
            'El usuario está logueado y es el propietario del campo');
    }

    public static function emailInexistente()
    {
        return self::createResponse(400,
            'No hay usuarios con el email especificado');
    }

    /*
    ----------------------------------------------------------------------------
    Responses de la gestión de los jugadores y apuestas de los partidos
    ----------------------------------------------------------------------------
    */

    public static function jugadorEnPartidoOk()
    {
        return self::createResponse(200,
            'El jugador está participando en el partido');
    }

    public static function jugadorNoEnPartido()
    {
        return self::createResponse(400,
            'El jugador no está participando en el partido');
    }

    public static function partidosFinalizadosVaciados($countExito, $countFallo)
    {
        return self::createResponse(200,
            'Partidos finalizados vaciados. Éxito: ' . $countExito
            . ', fallo: ' . $countFallo);
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

    /*
    ----------------------------------------------------------------------------
    Responses de la gestión de las puntuaciones de los partidos
    ----------------------------------------------------------------------------
    */

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