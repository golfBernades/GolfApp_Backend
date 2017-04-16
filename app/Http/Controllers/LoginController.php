<?php

namespace App\Http\Controllers;

use App\Http\Utils\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function autenticarUsuario(Request $request)
    {
        $email = $request['email'];
        $password = $request['password'];
        if (!$email || !$password)
            return HttpResponses::parametrosLoginIncompletosResponse();
        $jugador = DB::table('jugador')
            ->where('email', '=', $email)
            ->where('password', '=', $password)
            ->first();
        if (!$jugador) return HttpResponses::falloAutenticacionResponse();
        return response()->json(['code' => 200, 'message' => 'OK']);
    }
}
