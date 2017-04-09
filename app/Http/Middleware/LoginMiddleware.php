<?php

namespace App\Http\Middleware;

use App\Http\Controllers\LoginController;
use Closure;

class LoginMiddleware
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
        // Crea instancia del controller del login
        $loginController = new LoginController();
        // Guarda la response de la autenticación
        $loginResponse = $loginController->autenticarUsuario($request);
        // Obtiene el índice de la cadena donde comienza la respuesta JSON
        $keyIndex = strpos($loginResponse, '{');
        // Extrae la subcadena con la respuesta JSON
        $jsonSubstring = substr($loginResponse, $keyIndex);
        // Parsea el JSON obtenido
        $responseData = json_decode($jsonSubstring);
        // Si la autenticación es correcta, continúa con la request
        if ($responseData->code == 200 and $responseData->message == 'OK')
            return $next($request);
        // Si hay errores en autenticación se devuelve la response original
        else
            return $loginResponse;
    }
}
