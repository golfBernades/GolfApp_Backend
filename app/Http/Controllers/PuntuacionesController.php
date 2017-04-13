<?php

namespace App\Http\Controllers;

use App\Http\Utils\FieldValidator;
use App\Http\Utils\HttpResponses;
use App\Http\Utils\JsonResponseParser;
use App\Models\Puntuaciones;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PuntuacionesController extends Controller
{
    /**
     * Obtiene un Join con las puntuaciones de todos los jugadores en todos
     * los partidos.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPuntuacionesAllJugadorAllPartido()
    {
        $allPuntuaciones = DB::table('puntuaciones as pu')
            ->join('jugador as ju', function ($join) {
                $join->on('ju.id', '=', 'pu.jugador_id');
            })
            ->join('partido as pa', function ($join) {
                $join->on('pa.id', '=', 'pu.partido_id');
            })
            ->select(['pu.id as puntuaciones_id', 'hoyo', 'golpes', 'unidades',
                'pu.jugador_id', 'ju.nombre as nombre_jugador',
                'pa.clave as clave_partido'])
            ->get();
        return response()->json($allPuntuaciones);
    }

    /**
     * Devuelve una lista con los puntos que ha realizado el jugador en el
     * partido cuyos id's se pasaron como parámetro.
     *
     * @param $jugadorId
     * @param $partidoId
     * @return JsonResponse
     */
    public function getPuntuacionesJugadorPartido($jugadorId, $partidoId)
    {
        $jugador = EntityByIdController::getJugadorById($jugadorId);
        if ($jugador instanceof JsonResponse) return $jugador;
        $partido = EntityByIdController::getPartidoById($partidoId);
        if ($partido instanceof JsonResponse) return $partido;
        $puntosJugadorPartido = Puntuaciones::where('jugador_id', '=',
            $jugadorId)
            ->where('partido_id', '=', $partidoId)
            ->get();
        return response()->json($puntosJugadorPartido);
    }

    /**
     * Obtiene el registro de la tabla puntuaciones para el jugador en el
     * partido dentro de determinado hoyo, siendo pasados estos tres aspectos
     * como parámetros.
     *
     * @param $jugadorId
     * @param $partidoId
     * @param $hoyo
     * @return JsonResponse
     */
    public function getPuntuacionesJugadorPartidoHoyo($jugadorId, $partidoId,
                                                      $hoyo)
    {
        $jugador = EntityByIdController::getJugadorById($jugadorId);
        if ($jugador instanceof JsonResponse) return $jugador;
        $partido = EntityByIdController::getPartidoById($partidoId);
        if ($partido instanceof JsonResponse) return $partido;
        $validation = FieldValidator::validateIntegerParameterURL($hoyo);
        if ($validation instanceof JsonResponse) return $validation;
        if ($hoyo < 1 || $hoyo > 18) return HttpResponses::hoyoRangoInvalido();
        $puntosJugadorPartidoHoyo = Puntuaciones::where('jugador_id', '=',
            $jugadorId)
            ->where('partido_id', '=', $partidoId)
            ->where('hoyo', '=', $hoyo)
            ->first();
        if (!$puntosJugadorPartidoHoyo)
            return HttpResponses::noPuntosJugadorPartidoHoyo();
        return response()->json($puntosJugadorPartidoHoyo);
    }

    /**
     * @param Request $request
     * @return Puntuaciones|JsonResponse|int
     */
    public function registrarPuntuaciones(Request $request)
    {
        $puntuaciones = $this->crearPuntuaciones($request);
        if ($puntuaciones instanceof JsonResponse)
            return $puntuaciones;
        $nuevo = $puntuaciones->id;
        try {
            $puntuaciones->save();
            if ($nuevo)
                return HttpResponses::actualizadoOkResponse('puntuaciones');
            else
                return HttpResponses::insertadoOkResponse('puntuaciones');
        } catch (\Exception $e) {
            if ($nuevo)
                return HttpResponses::errorActualizadoResponse('puntuaciones');
            else
                return HttpResponses::errorGuardadoResponse('puntuaciones');
        }
    }

    /**
     * @param Request $request
     * @return Puntuaciones|\Illuminate\Http\JsonResponse|int
     */
    private function crearPuntuaciones(Request $request)
    {
        $jugadorId = $request['jugador_id'];
        $partidoId = $request['partido_id'];
        $hoyo = $request['hoyo'];
        $golpes = $request['golpes'];
        $unidades = $request['unidades'];
        if (!$jugadorId || !$partidoId || !$hoyo || !$golpes || !$unidades)
            return HttpResponses::parametrosIncompletosReponse();
        $jugador = EntityByIdController::getJugadorById($jugadorId);
        if ($jugador instanceof JsonResponse) return $jugador;
        $partido = EntityByIdController::getPartidoById($partidoId);
        if ($partido instanceof JsonResponse) return $partido;
        if ($hoyo < 1 || $hoyo > 18) return HttpResponses::hoyoRangoInvalido();
        if ($golpes < 0) return HttpResponses::golpesValorInvalido();
        if ($unidades < 0) return HttpResponses::unidadesValorInvalido();
        $puntuaciones = $this->getPuntuacionesJugadorPartidoHoyo(
            $jugadorId, $partidoId, $hoyo);
        $puntuacionesDecoded = JsonResponseParser::parse($puntuaciones);
        if (isset($puntuacionesDecoded->code) && $puntuacionesDecoded->code
            == 400
        )
            $puntuaciones = new Puntuaciones();
        else
            $puntuaciones = Puntuaciones::find($puntuacionesDecoded->id);
        $puntuaciones->jugador_id = $jugadorId;
        $puntuaciones->partido_id = $partidoId;
        $puntuaciones->hoyo = $hoyo;
        $puntuaciones->golpes = $golpes;
        $puntuaciones->unidades = $unidades;
        return $puntuaciones;
    }

}
