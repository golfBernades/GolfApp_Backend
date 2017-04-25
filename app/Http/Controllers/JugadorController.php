<?php

namespace App\Http\Controllers;

use App\Http\Utils\HttpResponses;
use App\Models\Jugador;
use App\Models\JugadorPartido;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JugadorController extends Controller
{
    public function getAllJugador(Request $request)
    {
        $partidoId = $request['partido_id'];
        if (!$partidoId)
            return HttpResponses::parametrosIncompletosReponse();
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

    public function getJugadorById(Request $request)
    {
        $jugadorId = $request['jugador_id'];
        $partidoId = $request['partido_id'];
        if (!$jugadorId || !$partidoId)
            return HttpResponses::parametrosIncompletosReponse();
        $jugadorPartido = JugadorPartido::where('jugador_id', '=', $jugadorId)
            ->where('partido_id', '=', $partidoId)->first();
        if (!$jugadorPartido) return HttpResponses::noEncontradoResponse('jugador');
        return Jugador::find($jugadorId);
    }

    public function store(Request $request)
    {
        $jugador = $this->crearJugador($request);
        if ($jugador instanceof Jugador) {
            try {
                $jugador->save();
                return HttpResponses::insertadoOkResponse('jugador');
            } catch (\Exception $e) {
                return HttpResponses::insertadoErrorResponse('jugador');
            }
        }
        return $jugador;
    }

    public function update(Request $request)
    {
        $jugador = $this->getJugadorById($request);
        if ($jugador instanceof Jugador) {
            $jugador = $this->crearJugador($request);
            if ($jugador instanceof Jugador) {
                try {
                    $jugador->save();
                    return HttpResponses::actualizadoOkResponse('jugador');
                } catch (\Exception $e) {
                    return HttpResponses::actualizadoErrorResponse('jugador');
                }
            }
        }
        return $jugador;
    }

    private function crearJugador(Request $request)
    {
        if (!$this->isJugadorCompleto($request))
            return HttpResponses::parametrosIncompletosReponse();
        if ($request['jugador_id']) {
            $jugador = Jugador::find($request['jugador_id']);
            if (!$jugador)
                return HttpResponses::noEncontradoResponse('jugador');
        } else
            $jugador = new Jugador();
        if ($request['nombre'])
            $jugador->nombre = $request['nombre'];
        if ($request['handicap'])
            $jugador->handicap = $request['handicap'];
        return $jugador;
    }

    private function isJugadorCompleto(Request $request)
    {
        $nombre = $request['nombre'];
        $handicap = $request['handicap'];
        if ($request['id']) return $nombre || $handicap;
        else return $nombre && $handicap;
    }
}
