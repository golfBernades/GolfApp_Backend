<?php

namespace App\Http\Controllers;

use App\Http\Utils\HttpResponses;
use App\Http\Utils\JsonResponseParser;
use App\Http\Utils\JsonResponses;
use App\Models\Campo;
use App\Models\Partido;
use App\Models\Usuario;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AutenticacionController extends Controller
{
    public function autenticarPermisoAccesoPartido(Request $request)
    {
        $partidoId = $request['partido_id'];
        $claveConsulta = $request['clave_consulta'];
        if (!$partidoId || !$claveConsulta)
            return HttpResponses::parametrosIncompletosReponse();
        $partido = Partido::find($partidoId);
        if (!$partido)
            return HttpResponses::noEncontradoResponse('partido');
        if ($partido->clave_consulta == $claveConsulta)
            return HttpResponses::claveConsultaOkResponse();
        return HttpResponses::claveConsultaErrorResponse();
    }

    public function autenticarPermisoEdicionPartido(Request $request)
    {
        $partidoId = $request['partido_id'];
        $claveEdicion = $request['clave_edicion'];
        if (!$partidoId || !$claveEdicion)
            return HttpResponses::parametrosIncompletosReponse();
        $partido = Partido::find($partidoId);
        if (!$partido)
            return HttpResponses::noEncontradoResponse('partido');
        if ($partido->clave_edicion == $claveEdicion)
            return HttpResponses::claveEdicionEOkResponse();
        return HttpResponses::claveEdicionErrorResponse();
    }

//    public function autenticarUsuario(Request $request)
//    {
//        $usuarioController = new UsuarioController();
//        return $usuarioController->login($request);
//    }

//    public function autenticarUsuarioCampo(Request $request)
//    {
//        $campoId = $request['campo_id'];
//        $email = $request['email'];
//
//        if (!$campoId)
//            return JsonResponses::parametrosIncompletosResponse(['campo_id']);
//
//        $campo = Campo::find($campoId);
//
//        if (!$campo) {
//            return JsonResponses::jsonResponse(200, [
//                'ok' => false,
//                'error_message' => 'El campo con el id especificado no existe'
//            ]);
//        } else {
//            $usuario = Usuario::where('email', '=', $email)->first();
//
//            if ($campo->owner_id == $usuario->id) {
//                return JsonResponses::jsonResponse(200, [
//                    'ok' => true,
//                ]);
//            }
//        }
//    }

}
