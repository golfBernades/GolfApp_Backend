<?php

namespace App\Http\Middleware;

use App\Http\Controllers\AutenticacionController;
use App\Http\Utils\HttpResponses;
use App\Http\Utils\JsonResponseParser;
use Closure;

class LoginMiddleware
{
    public function handle($request, Closure $next)
    {
        $autenticacionController = new AutenticacionController();
        $email = $request['email'];
        $password = $request['password'];
        if (!$email || !$password)
            return HttpResponses::parametrosIncompletosReponse();
        $response = $autenticacionController->autenticarUsuario($request);
        $data = JsonResponseParser::parse($response);
        if ($data->code == 200) return $next($request);
        return $response;
    }
}
