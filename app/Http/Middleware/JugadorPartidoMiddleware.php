<?php

namespace App\Http\Middleware;

use App\Http\Controllers\JugadorPartidoController;
use App\Http\Utils\JsonResponseParser;
use Closure;

class JugadorPartidoMiddleware
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
        $jugadorPartidoController = new JugadorPartidoController();
        $response = $jugadorPartidoController->jugadorEnPartido($request);
        $data = JsonResponseParser::parse($response);
        if ($data->code == 200) return $next($request);
        return $response;
    }
}