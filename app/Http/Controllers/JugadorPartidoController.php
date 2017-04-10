<?php

namespace App\Http\Controllers;

use App\Http\Utils\FieldValidator;
use App\Http\Utils\HttpResponses;
use App\Models\Jugador;
use App\Models\JugadorPartido;
use App\Models\Partido;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class JugadorPartidoController extends Controller
{
    /**
     * Agrega un jugador a un partido.
     *
     * @param $jugadorId
     * @param $partidoId
     * @return \Illuminate\Http\JsonResponse|int
     */
    public function addJugador($jugadorId, $partidoId)
    {
        $validation1 = FieldValidator::validateIntegerParameterURL($jugadorId);
        $validation2 = FieldValidator::validateIntegerParameterURL($partidoId);
        if ($validation1 instanceof JsonResponse) return $validation1;
        else if ($validation2 instanceof JsonResponse) return $validation2;
        $jugador = Jugador::find($jugadorId);
        if (!$jugador) return HttpResponses::noEncontradoResponse('jugador');
        $partido = Partido::find($partidoId);
        if (!$partido) return HttpResponses::noEncontradoResponse('partido');
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
     */
    public function removeJugador($jugadorId, $partidoId)
    {

    }

    /**
     * Obtiene los jugadores que están jugando en el partido con el id
     * especificado.
     *
     * @param $partidoId
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

}
