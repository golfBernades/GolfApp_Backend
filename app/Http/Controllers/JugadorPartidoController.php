<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Utils\HttpResponses;
use App\Models\Jugador;
use App\Models\JugadorPartido;
use App\Models\Partido;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class JugadorPartidoController extends Controller
{
    /**
     * Obtiene un Join de todos los jugadores que están jugando en cualquiera
     * de los partidos.
     *
     * @return JsonResponse
     */
    public function allJugadorAllPartido()
    {
        $jugadoresPartidos = DB::table('jugador_partido as jp')
            ->join('jugador as ju', function ($join) {
                $join->on('ju.id', '=', 'jp.jugador_id');
            })
            ->join('partido as pa', function ($join) {
                $join->on('pa.id', '=', 'jp.partido_id');
            })
            ->select(['jp.jugador_id', 'ju.nombre as nombre_jugador',
                'partido_id'])
            ->get();
        return response()->json($jugadoresPartidos);
    }

    /**
     * Agrega un jugador a un partido.
     *
     * @param $jugadorId
     * @param $partidoId
     * @return \Illuminate\Http\JsonResponse|int
     */
    public function addJugador($jugadorId, $partidoId)
    {
        $jugador = EntityByIdController::getJugadorById($jugadorId);
        if ($jugador instanceof JsonResponse)
            return $jugador;
        $partido = EntityByIdController::getPartidoById($partidoId);
        if ($partido instanceof JsonResponse)
            return $partido;
        $jugadorPartido = new JugadorPartido();
        $jugadorPartido->jugador_id = $jugadorId;
        $jugadorPartido->partido_id = $partidoId;
        try {
            $jugadorPartido->save();
            return HttpResponses::insertadoOkResponse('jugador_partido');
        } catch (\Exception $e) {
            return HttpResponses::insertadoErrorResponse('jugador_partido');
        }
    }

    /**
     * Elimina un jugador de un partido.
     *
     * @param $jugadorId
     * @param $partidoId
     * @return JsonResponse|int
     */
    public function removeJugador($jugadorId, $partidoId)
    {
        $jugador = EntityByIdController::getJugadorById($jugadorId);
        if ($jugador instanceof JsonResponse) return $jugador;
        $partido = EntityByIdController::getPartidoById($partidoId);
        if ($partido instanceof JsonResponse) return $partido;
        $jugadorPartido = JugadorPartido::where('jugador_id', '=', $jugadorId)
            ->where('partido_id', '=', $partidoId)->first();
        if (!$jugadorPartido) return HttpResponses::jugadorNoEnPartido();
        try {
            $jugadorPartido->delete();
            $jugador->delete();
            return HttpResponses::eliminadoOkResponse('jugador_partido');
        } catch (\Exception $e) {
            return HttpResponses::eliminadoErrorResponse('jugador_partido');
        }
    }

    /**
     * Obtiene los jugadores que están jugando en el partido con el id
     * especificado.
     *
     * @param $partidoId
     * @return Jugador|JsonResponse
     */
    public function getJugadoresEnPartido($partidoId)
    {
        $partido = EntityByIdController::getPartidoById($partidoId);
        if ($partido instanceof JsonResponse) return $partido;
        $jugadoresEnPartido = DB::table('jugador as ju')
            ->join('jugador_partido as jp', function ($join) {
                $join->on('ju.id', '=', 'jp.jugador_id');
            })
            ->select(['ju.id', 'nombre', 'handicap'])
            ->where('partido_id', '=', $partidoId)
            ->get();
        return response()->json($jugadoresEnPartido);
    }

    /**
     * Obtiene los partidos en los que está jugando el jugador con el id
     * especificado.
     *
     * @param $jugadorId
     * @return Partido|JsonResponse
     */
    public function getPartidosDelJugador($jugadorId)
    {
        $jugador = EntityByIdController::getJugadorById($jugadorId);
        if ($jugador instanceof JsonResponse) return $jugador;
        $partidosDelJugador = DB::table('partido as pa')
            ->join('jugador_partido as jp', function ($join) {
                $join->on('pa.id', '=', 'jp.partido_id');
            })
            ->select(['pa.id', 'inicio', 'fin', 'campo_id'])
            ->where('jp.jugador_id', '=', $jugadorId)
            ->get();
        return response()->json($partidosDelJugador);
    }

    /**
     * Vacía todos los registros del partido con el id especificado.
     *
     * @param $partidoId
     * @return JsonResponse|int
     */
    public function vaciarPartido($partidoId)
    {
        $partido = EntityByIdController::getPartidoById($partidoId);
        if ($partido instanceof JsonResponse) return $partido;
        $jugadoresPartidos = JugadorPartido::where('partido_id', '=',
            $partidoId);
        if ($jugadoresPartidos->get()->count() == 0)
            return HttpResponses::noRegistrosDePartido();
        try {
            $jugadoresPartidos->delete();
            return HttpResponses::partidoVaciadoOK();
        } catch (\Exception $e) {
            return HttpResponses::partidoVaciadoError();
        }
    }

    /**
     * Verifica si un jugador está incluido a un partido, tanto el id del
     * jugador como el id del partido son pasados en la request.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function jugadorEnPartido(Request $request)
    {
        $jugadorId = $request['jugador_id'];
        $partidoId = $request['partido_id'];
        if (!$jugadorId || !$partidoId)
            return HttpResponses::parametrosIncompletosReponse();
        $jugador = EntityByIdController::getJugadorById($jugadorId);
        if ($jugador instanceof JsonResponse)
            return $jugador;
        $partido = EntityByIdController::getPartidoById($partidoId);
        if ($partido instanceof JsonResponse)
            return $partido;
        $jugadorPartido = DB::table('jugador_partido')
            ->select(['jugador_id', 'partido_id'])
            ->where('jugador_id', '=', $jugadorId)
            ->where('partido_id', '=', $partidoId)
            ->get();
        if ($jugadorPartido) return HttpResponses::jugadorEnPartidoOk();
        return HttpResponses::jugadorNoEnPartido();
    }

}
