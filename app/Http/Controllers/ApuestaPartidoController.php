<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Utils\HttpResponses;
use App\Models\ApuestaPartido;
use App\Models\Partido;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ApuestaPartidoController extends Controller
{
    public function addApuesta(Request $request)
    {
        $apuestaId = $request['apuesta_id'];
        $partidoId = $request['partido_id'];
        if (!$apuestaId || !$partidoId)
            return HttpResponses::parametrosIncompletosReponse();
        $apuesta = EntityByIdController::getApuestaById($apuestaId);
        if ($apuesta instanceof JsonResponse)
            return $apuesta;
        $partido = EntityByIdController::getPartidoById($partidoId);
        if ($partido instanceof JsonResponse)
            return $partido;
        $apuestaPartido = new ApuestaPartido();
        $apuestaPartido->apuesta_id = $apuestaId;
        $apuestaPartido->partido_id = $partidoId;
        try {
            $apuestaPartido->save();
            return HttpResponses::insertadoOkResponse('apuesta_partido');
        } catch (\Exception $e) {
            return HttpResponses::insertadoErrorResponse('apuesta_partido');
        }
    }

    public function removeApuesta(Request $request)
    {
        $apuestaId = $request['apuesta_id'];
        $partidoId = $request['partido_id'];
        if (!$apuestaId || !$partidoId)
            return HttpResponses::parametrosIncompletosReponse();
        $apuesta = EntityByIdController::getApuestaById($apuestaId);
        if ($apuesta instanceof JsonResponse)
            return $apuesta;
        $partido = EntityByIdController::getPartidoById($partidoId);
        if ($partido instanceof JsonResponse)
            return $partido;
        $apuestaPartido = ApuestaPartido::where('apuesta_id', '=', $apuestaId)
            ->where('partido_id', '=', $partidoId)->first();
        if (!$apuestaPartido) return HttpResponses::apuestaNoEnPartido();
        try {
            $apuestaPartido->delete();
            return HttpResponses::eliminadoOkResponse('apuesta_partido');
        } catch (\Exception $e) {
            return HttpResponses::eliminadoErrorResponse('apuesta_partido');
        }
    }

    public function getApuestasEnPartido(Request $request)
    {
        $partidoController = new PartidoController();
        $partido = $partidoController->getPartidoById($request);
        if ($partido instanceof Partido) {
            $apuestasEnPartido = DB::table('apuesta as ap')
                ->join('apuesta_partido as a_p', function ($join) {
                    $join->on('ap.id', '=', 'a_p.apuesta_id');
                })
                ->select(['ap.id', 'nombre'])
                ->where('a_p.partido_id', '=', $partido->id)
                ->get();
            return $apuestasEnPartido;
        }
        return $partido;
    }
}
