<?php

namespace App\Http\Middleware;

use App\Http\Controllers\AutenticacionController;
use App\Http\Utils\HttpResponses;
use App\Http\Utils\JsonResponseParser;
use App\Http\Utils\JsonResponses;
use App\Models\Campo;
use App\Models\Usuario;
use Closure;

class PropietarioCampoMiddleware
{
    public function handle($request, Closure $next)
    {
        $campoId = $request['campo_id'];

        if (!$campoId)
            return JsonResponses::parametrosIncompletosResponse(['campo_id']);

        $campo = Campo::find($campoId);

        if (!$campo) {
            return JsonResponses::jsonResponse(200, [
                'ok' => false,
                'error_message' => 'El campo con el id especificado no existe'
            ]);
        } else {
            $email = $request['email'];
            $usuario = Usuario::where('email', '=', $email)->first();

            if ($campo->owner_id == $usuario->id) {
                return $next($request);
            } else {
                return JsonResponses::jsonResponse(200, [
                    'ok' => false,
                    'error_message' => 'El usuario especificado no es el propietario del campo'
                ]);
            }
        }
    }
}
