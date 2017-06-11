<?php

namespace App\Http\Controllers;

use App\Http\Utils\JsonResponses;
use App\Models\Apuesta;
use Illuminate\Http\Request;
use App\Models\ApuestaPartido;
use Illuminate\Support\Facades\DB;

class ApuestaPartidoController extends Controller
{
    public function addApuesta(Request $request)
    {
        $apuestaId = $request['apuesta_id'];
        $partidoId = $request['partido_id'];

        if (!$apuestaId) {
            return JsonResponses::parametrosIncompletosResponse(['apuesta_id']);
        }

        $apuesta = Apuesta::find($apuestaId);

        if (!$apuesta) {
            return JsonResponses::jsonResponse(200, [
                'ok' => false,
                'error_message' => 'La apuesta con el id especificado no existe'
            ]);
        }

        $apuestaPartido = new ApuestaPartido();
        $apuestaPartido->apuesta_id = $apuestaId;
        $apuestaPartido->partido_id = $partidoId;

        try {
            $apuestaPartido->save();
            return JsonResponses::jsonResponse(200, [
                'ok' => true,
                'apuesta_partido_id' => $apuestaPartido->id
            ]);
        } catch (\Exception $e) {
            return JsonResponses::jsonResponse(200, [
                'ok' => false,
                'error_message' => $e->getMessage()
            ]);
        }
    }

    public function removeApuesta(Request $request)
    {
        $apuestaId = $request['apuesta_id'];
        $partidoId = $request['partido_id'];

        if (!$apuestaId) {
            return JsonResponses::parametrosIncompletosResponse(['apuesta_id']);
        }

        $apuesta = Apuesta::find($apuestaId);

        if (!$apuesta) {
            return JsonResponses::jsonResponse(200, [
                'ok' => false,
                'error_message' => 'La apuesta con el id especificado no existe'
            ]);
        }

        $apuestaPartido = ApuestaPartido::where('apuesta_id', '=', $apuestaId)
            ->where('partido_id', '=', $partidoId)->first();

        try {
            if ($apuestaPartido) {
                $apuestaPartido->delete();
            }
            return JsonResponses::jsonResponse(200, [
                'ok' => true
            ]);
        } catch (\Exception $e) {
            return JsonResponses::jsonResponse(200, [
                'ok' => false,
                'error_message' => $e->getMessage()
            ]);
        }
    }

    public function getApuestasEnPartido(Request $request)
    {
        $partidoId = $request['partido_id'];

        $apuestas = DB::table('apuesta as ap')
            ->join('apuesta_partido as appa', function ($join) {
                $join->on('ap.id', '=', 'appa.apuesta_id');
            })
            ->select(['ap.id', 'nombre'])
            ->where('appa.partido_id', '=', $partidoId)
            ->get();

        return JsonResponses::jsonResponse(200, [
            'ok' => true,
            'apuestas' => $apuestas
        ]);
    }
}
