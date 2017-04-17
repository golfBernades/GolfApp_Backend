<?php

namespace App\Http\Controllers;

use App\Http\Utils\FieldValidator;
use App\Http\Utils\HttpResponses;
use App\Models\Partido;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CreadorPartidoController extends Controller
{
    public function autenticarUsuario(Request $request)
    {
        $partidoId = $request['partido_id'];
        $creadorId = $request['autenticado_id'];
        if (!$partidoId || !$creadorId)
            return HttpResponses::parametrosIncompletosReponse();
        $validation = FieldValidator::validateIntegerParameterURL($partidoId);
        if ($validation instanceof JsonResponse)
            return $validation;
        $validation = FieldValidator::validateIntegerParameterURL($creadorId);
        if ($validation instanceof JsonResponse)
            return $validation;
        $partido = Partido::find($partidoId);
        if (!$partido) return HttpResponses::noEncontradoResponse('partido');

        if ($partido->jugador_id == $creadorId)
            return HttpResponses::okResponse();
        else return HttpResponses::permisosPartidoErrorReponse();
    }
}
