<?php

namespace App\Http\Controllers;

use App\Http\Utils\FieldValidator;
use App\Http\Utils\HttpResponses;
use App\Models\Jugador;
use App\Models\JugadorPartido;
use App\Models\Partido;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Psy\Util\Json;

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
        $jugadores_partidos = DB::table('jugador_partido as jp')
            ->join('jugador as ju', function ($join) {
                $join->on('ju.id', '=', 'jp.jugador_id');
            })
            ->join('partido as pa', function ($join) {
                $join->on('pa.id', '=', 'jp.partido_id');
            })
            ->select(['jp.jugador_id', 'ju.nombre as nombre_jugador',
                'ju.apodo as apodo_jugador',
                'partido_id', 'pa.clave as clave_partido'])
            ->get();
        return response()->json($jugadores_partidos);
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
        $jugador = $this->getJugadorById($jugadorId);
        if ($jugador instanceof JsonResponse)
            return $jugador;
        $partido = $this->getPartidoById($partidoId);
        if ($partido instanceof JsonResponse)
            return $partido;
        $jugadorPartido = new JugadorPartido();
        $jugadorPartido->jugador_id = $jugadorId;
        $jugadorPartido->partido_id = $partidoId;
        try {
            $jugadorPartido->save();
            return HttpResponses::insertadoOkResponse('jugador_partido');
        } catch (\Exception $e) {
            return HttpResponses::errorGuardadoResponse('jugador_partido');
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
        $jugador = $this->getJugadorById($jugadorId);
        if ($jugador instanceof JsonResponse) return $jugador;
        $partido = $this->getPartidoById($partidoId);
        if ($partido instanceof JsonResponse) return $partido;
        $jugadorPartido = JugadorPartido::where('jugador_id', '=', $jugadorId)
            ->where('partido_id', '=', $partidoId)->first();
        if (!$jugadorPartido) return HttpResponses::jugadorNoEnPartido();
        try {
            $jugadorPartido->delete();
            return HttpResponses::eliminadoOkResponse('jugador_partido');
        } catch (\Exception $e) {
            return HttpResponses::errorEliminadoResponse('jugador_partido');
        }
    }

    /**
     * Obtiene los jugadores que están jugando en el partido con el id
     * especificado.
     *
     * @param $partidoId
     * @return JsonResponse|int
     */
    public function getJugadoresEnPartido($partidoId)
    {

    }

    /**
     * Obtiene los partidos en los que está jugando el jugador con el id
     * especificado.
     *
     * @param $jugadorId
     */
    public function getPartidosDelJugador($jugadorId)
    {

    }

    /**
     * Vacía todos los registros del partido con el id especificado.
     *
     * @param $partidoId
     */
    public function vaciarPartido($partidoId)
    {

    }

    /**
     * Obtiene el jugador con el id especificado o bien una JsonResponse con
     * el mensaje de error ya sea de que el id tiene un formato inválido o
     * que el registro no existe.
     *
     * @param $jugadorId
     * @return JsonResponse|Jugador
     */
    private function getJugadorById($jugadorId)
    {
        $validation = FieldValidator::validateIntegerParameterURL($jugadorId);
        if ($validation instanceof JsonResponse) return $validation;
        $jugador = Jugador::find($jugadorId);
        if (!$jugador) return HttpResponses::noEncontradoResponse('jugador');
        return $jugador;
    }

    /**
     * Obtiene el partido con el id especificado o bien una JsonResponse con
     * el mensaje de error ya sea de que el id tiene un formato inválido o
     * que el registro no existe.
     *
     * @param $partidoId
     * @return JsonResponse|Partido
     */
    private function getPartidoById($partidoId)
    {
        $validation = FieldValidator::validateIntegerParameterURL($partidoId);
        if ($validation instanceof JsonResponse) return $validation;
        $partido = Partido::find($partidoId);
        if (!$partido) return HttpResponses::noEncontradoResponse('partido');
        return $partido;
    }

}
