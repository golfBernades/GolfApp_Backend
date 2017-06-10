<?php

namespace App\Http\Controllers;

use App\Http\Middleware\JugadorPartidoMiddleware;
use App\Http\Utils\JsonResponses;
use App\Models\Jugador;
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

        if (!$jugadorId) {
            return JsonResponses::parametrosIncompletosResponse(['jugador_id']);
        }

        $jugador = Jugador::find($jugadorId);

        if (!$jugador) {
            return JsonResponses::jsonResponse(200, [
                'ok' => false,
                'error_message' => 'El jugador con el id especificado no existe'
            ]);
        }

        $jugadorPartido = new JugadorPartido();
        $jugadorPartido->jugador_id = $jugadorId;
        $jugadorPartido->partido_id = $partidoId;

        try {
            $jugadorPartido->save();

            return JsonResponses::jsonResponse(200, [
                'ok' => true,
                'jugador_partido_id' => $jugadorPartido->id
            ]);
        } catch (\Exception $e) {
            return JsonResponses::jsonResponse(200, [
                'ok' => false,
                'error_message' => $e->getMessage()
            ]);
        }
    }

    public function removeJugador(Request $request)
    {
        $jugadorId = $request['jugador_id'];
        $partidoId = $request['partido_id'];

        $jugadorPartido = JugadorPartido::where('jugador_id', '=', $jugadorId)
            ->where('partido_id', '=', $partidoId);

        try {
            $eliminados = $jugadorPartido->delete();

            if ($eliminados > 0) {
                return JsonResponses::jsonResponse(200, [
                    'ok' => true
                ]);
            } else {
                return JsonResponses::jsonResponse(200, [
                    'ok' => false,
                    'error_message' => 'El jugador especificado no estaba '
                        . 'participando en el partido'
                ]);
            }
        } catch (\Exception $e) {
            return JsonResponses::jsonResponse(200, [
                'ok' => false,
                'error_message' => $e->getMessage()
            ]);
        }
    }

    public function getJugadoresEnPartido(Request $request)
    {
        $partidoId = $request['partido_id'];

        $jugadores = DB::table('jugador as ju')
            ->join('jugador_partido as jp', function ($join) {
                $join->on('ju.id', '=', 'jp.jugador_id');
            })
            ->select(['ju.id', 'nombre', 'handicap'])
            ->where('jp.partido_id', '=', $partidoId)
            ->get();

        return JsonResponses::jsonResponse(200, [
            'ok' => true,
            'jugadores' => $jugadores
        ]);
    }
}
