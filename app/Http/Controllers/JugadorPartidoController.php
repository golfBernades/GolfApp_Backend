<?php

namespace App\Http\Controllers;

use App\Models\Jugador;
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
     */
    public function addJugador($jugadorId, $partidoId)
    {
        $jugador = Jugador::find($jugadorId);
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
