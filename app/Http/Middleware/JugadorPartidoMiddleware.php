<?php

namespace App\Http\Middleware;

use App\Http\Utils\JsonResponses;
use App\Models\Jugador;
use Closure;
use Illuminate\Support\Facades\DB;

class JugadorPartidoMiddleware
{
    public function handle($request, Closure $next)
    {
        $jugadorId = $request['jugador_id'];
        $partidoId = $request['partido_id'];

        if (!$jugadorId)
            return JsonResponses::parametrosIncompletosResponse(['jugador_id']);

        $jugador = Jugador::find($jugadorId);

        if (!$jugador) {
            return JsonResponses::jsonResponse(200, [
                'ok' => false,
                'error_message' => 'El jugador con el id especificado no existe'
            ]);
        }

        $jugador = DB::table('jugador as ju')
            ->join('jugador_partido as jp', function ($join) {
                $join->on('ju.id', '=', 'jp.jugador_id');
            })
            ->select(['ju.id', 'ju.nombre', 'ju.handicap'])
            ->where('jp.partido_id', '=', $partidoId)
            ->where('jp.jugador_id', '=', $jugadorId)
            ->first();

        if (!$jugador) {
            return JsonResponses::jsonResponse(200, [
                'ok' => false,
                'error_message' => 'El jugador especificado no pertenece al partido'
            ]);
        } else {
            return $next($request);
        }
    }
}
