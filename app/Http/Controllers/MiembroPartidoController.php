<?php

namespace App\Http\Controllers;

use App\Http\Utils\FieldValidator;
use App\Http\Utils\JsonResponseParser;
use App\Models\Partido;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MiembroPartidoController extends Controller
{
    public function autenticarUsuario(Request $request)
    {
        $partidoId = $request['partido_id'];
        $miembroId = $request['autenticado_id'];
        if (!$partidoId || !$miembroId)
            return HttpResponses::parametrosIncompletosReponse();
        $validation = FieldValidator::validateIntegerParameterURL($partidoId);
        if ($validation instanceof JsonResponse)
            return $validation;
        $validation = FieldValidator::validateIntegerParameterURL($miembroId);
        if ($validation instanceof JsonResponse)
            return $validation;
        $partido = Partido::find($partidoId);
        if (!$partido) return HttpResponses::noEncontradoResponse('partido');
        $jugadorPartidoController = new JugadorPartidoController();
        $partidos = JsonResponseParser::parse($jugadorPartidoController
            ->getPartidosDelJugador($miembroId));
        foreach ($partidos as $partidoGolf)
            if ($partidoGolf->id == $partido->id)
                return HttpResponses::okResponse();
        return HttpResponses::permisosPartidoErrorReponse();
    }
}
