<?php

namespace App\Http\Middleware;

use App\Http\Controllers\AutenticacionController;
use App\Http\Utils\HttpResponses;
use App\Http\Utils\JsonResponseParser;
use Closure;

class PropietarioCampoMiddleware
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
        $email = $request['email'];
        $password = $request['password'];
        $campoId = $request['campo_id'];
        if (!$email || !$password)
            return HttpResponses::parametrosIncompletosReponse();
        if ($campoId)
            $response = $autenticacionController
                ->autenticarUsuarioCampo($request);
        else
            $response = $autenticacionController
                ->autenticarUsuario($request);
        $data = JsonResponseParser::parse($response);
        if ($data->code == 200) return $next($request);
        return $response;
    }
}
