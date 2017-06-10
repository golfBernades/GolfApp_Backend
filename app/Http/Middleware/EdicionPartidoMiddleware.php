<?php

namespace App\Http\Middleware;

use App\Http\Controllers\AutenticacionController;
use App\Http\Utils\JsonResponseParser;
use App\Http\Utils\JsonResponses;
use App\Models\Partido;
use Closure;

class EdicionPartidoMiddleware
{
    public function handle($request, Closure $next)
    {
        $partidoId = $request['partido_id'];
        $claveEdicion = $request['clave_edicion'];

        if (!$partidoId || !$claveEdicion)
            return JsonResponses::parametrosIncompletosResponse(['partido_id',
                'clave_edicion']);

        $partido = Partido::find($partidoId);

        if (!$partido) {
            return JsonResponses::jsonResponse(200, [
                'ok' => false,
                'error_message' => 'No existe el partido con el id especificado'
            ]);
        } else {
            if ($partido->clave_edicion == $claveEdicion) {
                return $next($request);
            } else {
                return JsonResponses::jsonResponse(200, [
                    'ok' => false,
                    'error_message' => 'La clave de edición del partido es '
                        . 'incorrecta'
                ]);
            }
        }
    }
}
