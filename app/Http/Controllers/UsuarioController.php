<?php

namespace App\Http\Controllers;

use App\Http\Utils\JsonResponses;
use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function usuarioExists(Request $request)
    {
        $email = $request['email'];
        if (!$email) return JsonResponses::parametrosIncompletosResponse(['email']);
        $usuario = Usuario::where('email', '=', $email)->first();
        return JsonResponses::jsonResponse(200, [
            'existe' => $usuario != null
        ]);
    }

    public function login(Request $request)
    {
        $email = $request['email'];
        $password = $request['password'];

        if (!$email || !$password)
            return JsonResponses::parametrosIncompletosResponse(['email',
                'password']);

        $usuario = Usuario::where('email', '=', $email)->first();

        return JsonResponses::jsonResponse(200, [
            'logueado' => $usuario && $usuario->password == sha1($password)
        ]);
    }

    public function store(Request $request)
    {
        $email = $request['email'];
        $password = $request['password'];

        if (!$email || !$password)
            return JsonResponses::parametrosIncompletosResponse(['email',
                'password']);

        $usuarioByEmail = Usuario::where('email', '=', $email)->first();
        $error_message = '';

        if ($usuarioByEmail) {
            $insertado = false;
            $error_message = 'El email ya está siendo utilizado';
        } else {
            try {
                $usuario = new Usuario();
                $usuario->email = $email;
                $usuario->password = sha1($password);
                $usuario->save();
                $insertado = true;
            } catch (\Exception $e) {
                $insertado = false;
                $error_message = $e->getMessage();
            }
        }

        if ($insertado) {
            return JsonResponses::jsonResponse(200, [
                'insertado' => true
            ]);
        } else {
            return JsonResponses::jsonResponse(200, [
                'insertado' => false,
                'error_message' => $error_message
            ]);
        }
    }

    public function update(Request $request)
    {
        $usuarioId = $request['usuario_id'];
        $email = $request['email'];
        $password = $request['password'];

        if (!$email || !$password || !$usuarioId)
            return JsonResponses::parametrosIncompletosResponse(['email',
                'password', 'usuario_id']);

        $actualizado = true;
        $usuario = Usuario::find($usuarioId);
        $error_message = '';

        if (!$usuario) {
            $actualizado = false;
            $error_message = 'No hay un usuario con el id especificado';
        } else {
            $usuarioByEmail = Usuario::where('email', '=', $email)->first();
            if ($usuarioByEmail) {
                if ($usuario->id != $usuarioByEmail->id) {
                    $actualizado = false;
                    $error_message = 'El email ya está siendo utilizado';
                }
            }
            if ($actualizado) {
                if (sha1($password) == $usuario->password) {
                    $usuario->email = $email;
                    if ($request['new_password'])
                        $usuario->password = sha1($request['new_password']);
                    try {
                        $usuario->save();
                        $actualizado = true;
                    } catch (\Exception $e) {
                        $actualizado = false;
                        $error_message = $e->getMessage();
                    }
                } else {
                    $actualizado = false;
                    $error_message = 'La contraseña del usuario es incorrecta';
                }
            }
        }
        if ($actualizado) {
            return JsonResponses::jsonResponse(200, [
                'actualizado' => true
            ]);
        } else {
            return JsonResponses::jsonResponse(200, [
                'actualizado' => false,
                'error_message' => $error_message
            ]);
        }
    }

    public function destroy(Request $request)
    {
        $email = $request['email'];
        $password = $request['password'];

        if (!$email || !$password)
            return JsonResponses::parametrosIncompletosResponse(['email',
                'password']);

        $usuario = Usuario::where('email', '=', $email)->first();
        $error_message = '';

        if ($usuario) {
            try {
                $usuario->delete();
                $eliminado = true;
            } catch (\Exception $e) {
                $eliminado = false;
                $error_message = $e->getMessage();
            }
        } else {
            $eliminado = false;
            $error_message = 'No existe el usuario con el email especificado';
        }

        if($eliminado) {
            return JsonResponses::jsonResponse(200, [
                'eliminado' => true
            ]);
        } else {
            return JsonResponses::jsonResponse(200, [
                'eliminado' => false,
                'error_message' => $error_message
            ]);
        }
    }
}
