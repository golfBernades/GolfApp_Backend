<?php

namespace App\Http\Controllers;

use App\Http\Utils\HttpResponses;
use App\Http\Utils\JsonResponseParser;
use App\Models\Partido;
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

    public function autenticarUsuario(Request $request)
    {
        $usuarioController = new UsuarioController();
        return $usuarioController->login($request);
    }

    public function autenticarUsuarioCampo(Request $request)
    {
        $campoId = $request['campo_id'];
        if (!$campoId) return HttpResponses::parametrosIncompletosReponse();
        $campo = EntityByIdController::getCampoById($campoId);
        if ($campo instanceof JsonResponse) return $campo;
        $usuarioController = new UsuarioController();
        $response = $usuarioController->login($request);
        $data = JsonResponseParser::parse($response);
        if ($data->code == 200) {
            $usuario = $usuarioController->getUsuarioByEmail($request);
            if ($campo->owner_id == $usuario->id)
                return HttpResponses::propietarioCampoOkResponse();
            else
                return HttpResponses::propietarioCampoErrorResponse();

        }
        return $response;
    }
}
