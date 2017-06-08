<?php

namespace App\Http\Controllers;

use App\Http\Utils\HttpResponses;
use App\Models\Usuario;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    private function jsonResponse($code, $params)
    {
        return response()->json($params)->setStatusCode($code);
    }

    private function parametrosIncompletosResponse($requiredParams)
    {
        return $this->jsonResponse(400, [
            'error_message' => 'Parámetros incompletos, se requieren los '
                . 'siguientes parámetros: ['
                . implode(', ', $requiredParams)
                . ']'
        ]);
    }

    private function codigoDesconocidoResponse(JsonResponse $response)
    {
        return $this->jsonResponse($response->getStatusCode(), [
            'error_message' => 'Error de tipo '
                . $response->getStatusCode()
        ]);
    }

    public function usuarioExists(Request $request)
    {
        $response = $this->getUsuarioByEmail($request);
        if ($response->getStatusCode() == 200) {
            $usuario = $response->getData()->usuario;
            return $this->jsonResponse(200, [
                'existe' => $usuario != null
            ]);
        } else if ($response->getStatusCode() == 400) {
            return $response;
        } else {
            return $this->codigoDesconocidoResponse($response);
        }
    }

    public function getUsuarioByEmail(Request $request)
    {
        $email = $request['email'];
        if (!$email) return $this->parametrosIncompletosResponse(['email']);
        $usuario = Usuario::where('email', '=', $email);
        if ($usuario->count()) return $this->jsonResponse(200, [
            'usuario' => $usuario->first()
        ]);
        return $this->jsonResponse(200, [
            'usuario' => null
        ]);
    }

    public function login(Request $request)
    {
        $email = $request['email'];
        $password = $request['password'];
        if (!$email || !$password)
            return $this->parametrosIncompletosResponse(['email', 'password']);
        $response = $this->getUsuarioByEmail($request);
        if ($response->getStatusCode() == 200) {
            $usuario = $response->getData()->usuario;
            return $this->jsonResponse(200, [
                'logueado' => $usuario && $usuario->password == sha1($password)
            ]);
        } else if ($response->getStatusCode() == 400) {
            return $response;
        } else {
            return $this->codigoDesconocidoResponse($response);
        }
    }

//    public function login(Request $request)
//    {
//        $email = $request['email'];
//        $password = $request['password'];
//        if (!$email || !$password)
//            return HttpResponses::parametrosIncompletosReponse();
//        $usuario = $this->getUsuarioByEmail($request);
//        if ($usuario instanceof JsonResponse)
//            return $usuario;
//        if ($usuario->password == sha1($password))
//            return HttpResponses::loginOkResponse($usuario->id);
//        else return HttpResponses::loginErrorResponse();
//    }

    public function store(Request $request)
    {
        $email = $request['email'];
        $password = $request['password'];
        if (!$email || !$password)
            return HttpResponses::parametrosIncompletosReponse();
        $byEmail = $this->getUsuarioByEmail($request);
        if ($byEmail instanceof Usuario) return HttpResponses::emailEnUso();
        try {
            $usuario = new Usuario();
            $usuario->email = $email;
            $usuario->password = sha1($password);
            $usuario->save();
            return HttpResponses::insertadoOkResponse('usuario', $usuario->id);
        } catch (\Exception $e) {
            return HttpResponses::insertadoErrorResponse('usuario');
        }
    }

    public function update(Request $request)
    {
        $email = $request['email'];
        $password = $request['password'];
        $usuarioId = $request['usuario_id'];
        if (!$email || !$password || !$usuarioId)
            return HttpResponses::parametrosIncompletosReponse();
        $usuario = EntityByIdController::getUsuarioById($usuarioId);
        if ($usuario instanceof JsonResponse) return $usuario;
        $byEmail = $this->getUsuarioByEmail($request);
        if ($byEmail instanceof Usuario && $usuario->id != $byEmail->id
            && $email == $byEmail->email
        ) return HttpResponses::emailEnUso();
        if (sha1($password) == $usuario->password) {
            $newPassword = $request['new_password'];
            if ($newPassword) $usuario->password = sha1($newPassword);
        } else return HttpResponses::loginErrorResponse();
        if ($email) $usuario->email = $email;
        try {
            $usuario->save();
            return HttpResponses::actualizadoOkResponse('usuario');
        } catch (\Exception $e) {
            return HttpResponses::actualizadoErrorResponse('usuario');
        }
    }

    public function destroy(Request $request)
    {
        $email = $request['email'];
        $password = $request['password'];
        if (!$email || !$password)
            return HttpResponses::parametrosIncompletosReponse();
        $usuario = $this->getUsuarioByEmail($request);
        if ($usuario instanceof JsonResponse) return $usuario;
        if ($usuario->password != sha1($password))
            return HttpResponses::loginErrorResponse();
        try {
            $usuario->delete();
            return HttpResponses::eliminadoOkResponse('usuario');
        } catch (\Exception $e) {
            return HttpResponses::eliminadoErrorResponse('usuario');
        }
    }
}
