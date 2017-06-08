<?php

namespace App\Http\Controllers;

use App\Http\Utils\FieldValidator;
use App\Http\Utils\HttpResponses;
use App\Models\Apuesta;
use App\Models\Campo;
use App\Models\Jugador;
use App\Models\Partido;
use App\Models\Usuario;
use Illuminate\Http\JsonResponse;

/**
 * Contiene métodos para obtener instancias de los modelos de la base de
 * datos a partir de su id validando si éste viene con un formato correcto y
 * si el recurso solicitado existe, lo que devuelve cada uno de estos métodos
 * es la instancia del modelo o bien la JsonResponse con la respuesta del
 * error encontrado.
 *
 * Class EntityByIdController
 * @package App\Http\Controllers
 */
class EntityByIdController extends Controller
{
    public static function getJugadorById($jugadorId)
    {
        $validation = FieldValidator::validateIntegerParameterURL($jugadorId);
        if ($validation instanceof JsonResponse) return $validation;
        $jugador = Jugador::find($jugadorId);
        if (!$jugador) return HttpResponses::noEncontradoResponse('jugador');
        return $jugador;
    }

    public static function getPartidoById($partidoId)
    {
        $validation = FieldValidator::validateIntegerParameterURL($partidoId);
        if ($validation instanceof JsonResponse) return $validation;
        $partido = Partido::find($partidoId);
        if (!$partido) return HttpResponses::noEncontradoResponse('partido');
        return $partido;
    }

    public static function getApuestaById($apuestaId)
    {
        $validation = FieldValidator::validateIntegerParameterURL($apuestaId);
        if ($validation instanceof JsonResponse) return $validation;
        $apuesta = Apuesta::find($apuestaId);
        if (!$apuesta) return HttpResponses::noEncontradoResponse('apuesta');
        return $apuesta;
    }

    public static function getCampoById($campoId)
    {
        $campo = Campo::find($campoId);
        if (!$campo) return HttpResponses::noEncontradoResponse('campo');
        return $campo;
    }

    public static function getUsuarioById($usuarioId)
    {
        $validation = FieldValidator::validateIntegerParameterURL($usuarioId);
        if ($validation instanceof JsonResponse) return $validation;
        $usuario = Usuario::find($usuarioId);
        if (!$usuario) return HttpResponses::noEncontradoResponse('usuario');
        return $usuario;
    }
}
