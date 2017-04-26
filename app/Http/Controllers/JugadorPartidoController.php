<?php

namespace App\Http\Controllers;

use App\Models\Puntuaciones;
use Illuminate\Http\Request;
use App\Http\Utils\HttpResponses;
use App\Models\JugadorPartido;
use App\Models\Partido;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class JugadorPartidoController extends Controller
{
    public function addJugador(Request $request)
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

    public function removeJugador(Request $request)
    {
        $jugadorId = $request['jugador_id'];
        $partidoId = $request['partido_id'];
        if (!$jugadorId || !$partidoId)
            return HttpResponses::parametrosIncompletosReponse();
        $jugador = EntityByIdController::getJugadorById($jugadorId);
        if ($jugador instanceof JsonResponse) return $jugador;
        $partido = EntityByIdController::getPartidoById($partidoId);
        if ($partido instanceof JsonResponse) return $partido;
        $jugadorPartido = JugadorPartido::where('jugador_id', '=', $jugadorId)
            ->where('partido_id', '=', $partidoId);
        $puntuacionesJugador = Puntuaciones::where('jugador_id', '=', $jugadorId)
            ->where('partido_id', '=', $partidoId);
        if (!$jugadorPartido) return HttpResponses::jugadorNoEnPartido();
        try {
            DB::beginTransaction();
            $puntuacionesJugador->delete();
            $jugadorPartido->delete();
            $jugador->delete();
            DB::commit();
            return HttpResponses::eliminadoOkResponse('jugador_partido');
        } catch (\Exception $e) {
            echo $e->getMessage() . '<br>';
            DB::rollBack();
            return HttpResponses::eliminadoErrorResponse('jugador_partido');
        }
    }

    public function getJugadoresEnPartido(Request $request)
    {
        $partidoController = new PartidoController();
        $partido = $partidoController->getPartidoById($request);
        if ($partido instanceof Partido) {
            $jugadoresDelPartido = DB::table('jugador as ju')
                ->join('jugador_partido as jp', function ($join) {
                    $join->on('ju.id', '=', 'jp.jugador_id');
                })
                ->select(['ju.id', 'nombre', 'handicap'])
                ->where('jp.partido_id', '=', $partido->id)
                ->get();
            return $jugadoresDelPartido;
        }
        return $partido;
    }
}
