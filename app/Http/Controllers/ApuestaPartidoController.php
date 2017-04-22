<?php

namespace App\Http\Controllers;

use App\Http\Utils\HttpResponses;
use App\Models\ApuestaPartido;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ApuestaPartidoController extends Controller
{
    /**
     * Obtiene un Join de todas las apuestas que se están llevando a cabo en
     * cualquiera de los partidos.
     *
     * @return JsonResponse
     */
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
                'par.id as partido_id'])
            ->get();
        return response()->json($apuestasPartidos);
    }

    /**
     * Agrega una apuesta a un partido.
     *
     * @param $apuestaId
     * @param $partidoId
     * @return JsonResponse|int
     */
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
            return HttpResponses::insertadoErrorResponse('apuesta_partido');
        }
    }

    /**
     * Elimina una apuesta de un partido.
     *
     * @param $apuestaId
     * @param $partidoId
     * @return JsonResponse|int
     */
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
            return HttpResponses::eliminadoErrorResponse('apuesta_partido');
        }
    }

    /**
     * Obtiene una lista con las apuestas que se están llevando a cabo en el
     * partido con el id dado.
     *
     * @param $partidoId
     * @return JsonResponse|int
     */
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
        return response()->json($apuestasEnPartido);
    }

    /**
     * Obtiene una lista con los partidos donde se está llevando a cabo la
     * apuesta con el id dado.
     *
     * @param $apuestaId
     * @return JsonResponse|int
     */
    public function getPartidosConApuesta($apuestaId)
    {
        $apuesta = EntityByIdController::getApuestaById($apuestaId);
        if ($apuesta instanceof JsonResponse) return $apuesta;
        $partidosConApuesta = DB::table('partido as pa')
            ->join('apuesta_partido as ap', function ($join) {
                $join->on('pa.id', '=', 'ap.partido_id');
            })
            ->select(['pa.id', 'inicio', 'fin', 'campo_id'])
            ->where('apuesta_id', '=', $apuestaId)
            ->get();
        return response()->json($partidosConApuesta);
    }

    /**
     * Vacía todos los registros del partido con el id especificado.
     *
     * @param $partidoId
     * @return JsonResponse|int
     */
    public function vaciarPartido($partidoId)
    {
        $partido = EntityByIdController::getPartidoById($partidoId);
        if ($partido instanceof JsonResponse) return $partido;
        $apuestasPartido = ApuestaPartido::where('partido_id', '=',
            $partidoId);
        if ($apuestasPartido->get()->count() == 0)
            return HttpResponses::noRegistrosDePartido();
        try {
            $apuestasPartido->delete();
            return HttpResponses::partidoVaciadoOK();
        } catch (\Exception $e) {
            return HttpResponses::partidoVaciadoError();
        }
    }
}
