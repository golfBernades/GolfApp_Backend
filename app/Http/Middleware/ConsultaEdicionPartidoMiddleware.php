<?php

namespace App\Http\Middleware;

use App\Http\Controllers\AutenticacionPartidoController;
use App\Http\Utils\HttpResponses;
use App\Http\Utils\JsonResponseParser;
use Closure;

class ConsultaEdicionPartidoMiddleware
{
    /**
     * @param $request
     * @param Closure $next
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function handle($request, Closure $next)
    {
        $autenticacionController = new AutenticacionPartidoController();
        if ($request['clave_consulta']) {
            $response = $autenticacionController->autenticarPermisoAcceso($request);
            $data = JsonResponseParser::parse($response);
            if ($data->code == 200) return $next($request);
        } else if ($request['clave_edicion']) {
            $response = $autenticacionController->autenticarPermisoEdicion($request);
            $data = JsonResponseParser::parse($response);
            if ($data->code == 200) return $next($request);
        } else return HttpResponses::parametrosIncompletosReponse();
        return $response;
    }
}
