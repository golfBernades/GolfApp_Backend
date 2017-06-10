<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Au;
use App\Http\Controllers\AutenticacionController;
use App\Http\Utils\HttpResponses;
use App\Http\Utils\JsonResponseParser;
use App\Http\Utils\JsonResponses;
use App\Models\Partido;
use Closure;

class ConsultaEdicionPartidoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $partidoId = $request['partido_id'];
        $claveEdicion = $request['clave_edicion'];
        $claveConsulta = $request['clave_consulta'];

        if (!$partidoId || (!$claveEdicion && !$claveConsulta))
            return JsonResponses::parametrosIncompletosResponse(['partido_id',
                'clave_edicion', 'clave_consulta']);

        $partido = Partido::find($partidoId);

        if (!$partido) {
            return JsonResponses::jsonResponse(200, [
                'ok' => false,
                'error_message' => 'No existe el partido con el id especificado'
            ]);
        } else {
            $claveCorrecta = false;

            if ($claveEdicion) {
                if ($partido->clave_edicion == $claveEdicion) {
                    $claveCorrecta = true;
                }
            } else {
                if ($partido->clave_consulta == $claveConsulta) {
                    $claveCorrecta = true;
                }
            }

            if ($claveCorrecta) {
                return $next($request);
            } else {
                return JsonResponses::jsonResponse(200, [
                    'ok' => false,
                    'error_message' => 'La clave de consulta o edición del '
                        . 'partido es incorrecta'
                ]);
            }
        }
    }
}
