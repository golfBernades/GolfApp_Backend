<?php

namespace App\Http\Middleware;

use App\Http\Controllers\AutenticacionController;
use App\Http\Controllers\UsuarioController;
use App\Http\Utils\HttpResponses;
use App\Http\Utils\JsonResponseParser;
use App\Http\Utils\JsonResponses;
use Closure;

class LoginMiddleware
{
    public function handle($request, Closure $next)
    {
        $email = $request['email'];
        $password = $request['password'];

        if (!$email || !$password)
            return JsonResponses::parametrosIncompletosResponse(['email',
                'password']);

        $usuarioController = new UsuarioController();
        $response = $usuarioController->login($request);

        if ($response->getStatusCode() == 200) {
            return $response->getData()->logueado ? $next($request) : $response;
        } else {
            return $response;
        }
    }
}
