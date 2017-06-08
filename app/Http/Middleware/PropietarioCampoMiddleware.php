<?php

namespace App\Http\Middleware;

use App\Http\Controllers\AutenticacionController;
use App\Http\Utils\HttpResponses;
use App\Http\Utils\JsonResponseParser;
use Closure;

class PropietarioCampoMiddleware
{
    public function handle($request, Closure $next)
    {
        $autenticacionController = new AutenticacionController();
        $response = $autenticacionController->autenticarUsuarioCampo($request);
        $data = JsonResponseParser::parse($response);
        if ($data->code == 200) return $next($request);
        return $response;
    }
}