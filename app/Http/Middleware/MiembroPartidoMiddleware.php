<?php

namespace App\Http\Middleware;

use App\Http\Controllers\MiembroPartidoController;
use App\Http\Utils\JsonResponseParser;
use Closure;

/**
 * Class MiembroPartidoMiddleware
 *
 * Este middleware maneja las acciones de validación sobre la gestión de los
 * partidos a las que pueden acceder únicamente los miembros del partido, para
 * determinar si en realidad el usuario tiene los permisos para ver los datos
 * sobre el juego.
 *
 * @package App\Http\Middleware
 */
class MiembroPartidoMiddleware
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
        $miebroPartidoController = new MiembroPartidoController();
        $permisosResponse = $miebroPartidoController->autenticarUsuario
        ($request);
        $responseData = JsonResponseParser::parse($permisosResponse);
        if ($responseData->code == 200 and $responseData->message == 'OK')
            return $next($request);
        else return $permisosResponse;
    }
}
