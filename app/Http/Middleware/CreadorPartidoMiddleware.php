<?php

namespace App\Http\Middleware;

use App\Http\Controllers\CreadorPartidoController;
use App\Http\Utils\JsonResponseParser;
use Closure;


/**
 * Class CreadorPartidoMiddleware
 *
 * Este middleware maneja las acciones de validación sobre la gestión de los
 * partidos que le pertenecen únicamente al organizador del partido, para
 * determinar si en realidad el usuario tiene los permisos para modificar los
 * datos sobre el juego.
 *
 * @package App\Http\Middleware
 */
class CreadorPartidoMiddleware
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
//        echo '<h1>CrearPartidoMiddleware</h1>';
        $creadorPartidoController = new CreadorPartidoController();
        $permisosResponse = $creadorPartidoController->autenticarUsuario
        ($request);
        $responseData = JsonResponseParser::parse($permisosResponse);
        if ($responseData->code == 200 and $responseData->message == 'OK')
            return $next($request);
        else return $permisosResponse;
    }
}
