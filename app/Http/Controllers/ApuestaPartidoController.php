<?php

namespace App\Http\Controllers;

use App\Http\Utils\HttpResponses;
use App\Models\ApuestaPartido;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ApuestaPartidoController extends Controller
{
    public function allApuestaAllPartido()
    {
        $apuestasPartidos = DB::table('apuesta_partido as ap')
            ->join('apuesta as apu', function ($join) {
                $join->on('apu.id', '=', 'ap.apuesta_id');
            })
            ->join('partido as par', function ($join) {
                $join->on('par.id', '=', 'ap.partido_id');
            })
            ->select(['apu.id as apuesta_id', 'apu.nombre as nombre_apuesta',
                'par.id as partido_id', 'par.clave as clave_partido'])
            ->get();
        return response()->json($apuestasPartidos);
    }

    public function addApuesta($apuestaId, $partidoId)
    {
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
            return HttpResponses::errorGuardadoResponse('apuesta_partido');
        }
    }

    public function removeApuesta($apuestaId, $partidoId)
    {
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
            return HttpResponses::errorEliminadoResponse('apuesta_partido');
        }
    }

    public function getApuestasEnPartido($partidoId)
    {
        $partido = EntityByIdController::getPartidoById($partidoId);
        if ($partido instanceof JsonResponse) return $partido;
        $apuestasEnPartido = DB::table('apuesta as apu')
            ->join('apuesta_partido as ap', function ($join) {
                $join->on('apu.id', '=', 'ap.apuesta_id');
            })
            ->select(['apu.id', 'nombre'])
            ->where('partido_id', '=', $partidoId)
            ->get();
        return $apuestasEnPartido;
    }

    public function getPartidosConApuesta($apuestaId)
    {
        $apuesta = EntityByIdController::getApuestaById($apuestaId);
        if ($apuesta instanceof JsonResponse) return $apuesta;
        $partidosConApuesta = DB::table('partido as pa')
            ->join('apuesta_partido as ap', function ($join) {
                $join->on('pa.id', '=', 'ap.partido_id');
            })
            ->select(['pa.id', 'clave', 'inicio', 'fin', 'jugador_id',
                'campo_id'])
            ->where('apuesta_id', '=', $apuestaId)
            ->get();
        return $partidosConApuesta;
    }
}
