<?php

namespace App\Http\Controllers;

use App\Http\Utils\HttpResponses;
use App\Models\Partido;
use Illuminate\Http\Request;

class AutenticacionPartidoController extends Controller
{
    public function autenticarPermisoAcceso(Request $request)
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

    public function autenticarPermisoEdicion(Request $request)
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
}
