<?php

namespace App\Http\Middleware;

use App\Http\Controllers\LoginController;
use App\Http\Utils\JsonResponseParser;
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
//        echo '<h1>LoginMiddleware</h1>';
        $loginController = new LoginController();
        $loginResponse = $loginController->autenticarUsuario($request);
        $responseData = JsonResponseParser::parse($loginResponse);
        if ($responseData->code == 200 and $responseData->message == 'OK')
            return $next($request);
        else return $loginResponse;
    }
}
