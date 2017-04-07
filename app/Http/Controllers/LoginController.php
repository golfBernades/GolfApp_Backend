<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function autenticarUsuario(Request $request)
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
        return response()->json(['code' => 200, 'message' => 'OK']);
    }
}
