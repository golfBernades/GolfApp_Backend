<?php

namespace App\Http\Middleware;

use App\Http\Controllers\AutenticacionPartidoController;
use App\Http\Utils\JsonResponseParser;
use Closure;

class EdicionPartidoMiddleware
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
        $autenticacionController = new AutenticacionPartidoController();
        $response = $autenticacionController->autenticarPermisoEdicion($request);
        $data = JsonResponseParser::parse($response);
        if ($data->code == 200) return $next($request);
        return $response;
    }
}
