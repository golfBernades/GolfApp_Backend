<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

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
        $email = $request['email'];
        $password = $request['password'];
        if (!$email)
            return response()->json(['code' => 400,
                'message' => 'Falta el email para autenticar el usuario']);
        if (!$password)
            return response()->json(['code' => 400,
                'message' => 'Falta la contraseña para autenticar el usuario']);
        $jugador = DB::table('jugador')
            ->where('email', '=', $email)
            ->where('password', '=', $password)
            ->first();
        if (!$jugador)
            return response()->json(['code' => 400,
                'message' => 'Falló la autenticación del usuario']);
        else
            return $next($request);
    }
}
