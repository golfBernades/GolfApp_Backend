<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Au;
use App\Http\Controllers\AutenticacionController;
use App\Http\Utils\HttpResponses;
use App\Http\Utils\JsonResponseParser;
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
        $autenticacionController = new AutenticacionController();
        if ($request['clave_consulta']) {
            $response = $autenticacionController->autenticarPermisoAccesoPartido($request);
            $data = JsonResponseParser::parse($response);
            if ($data->code == 200) return $next($request);
        } else if ($request['clave_edicion']) {
            $response = $autenticacionController->autenticarPermisoEdicionPartido($request);
            $data = JsonResponseParser::parse($response);
            if ($data->code == 200) return $next($request);
        } else return HttpResponses::parametrosIncompletosReponse();
        return $response;
    }
}
