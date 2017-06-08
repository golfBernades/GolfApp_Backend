<?php

namespace App\Http\Controllers;

use App\Http\Utils\DateTimeOperations;
use App\Http\Utils\FieldValidator;
use App\Http\Utils\HttpResponses;
use App\Models\ApuestaPartido;
use App\Models\Campo;
use App\Models\Jugador;
use App\Models\JugadorPartido;
use App\Models\Partido;
use App\Models\Puntuaciones;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PartidoController extends Controller
{
    public function store(Request $request)
    {
        $partido = $this->crearPartido($request);
        if ($partido instanceof Partido) {
            try {
                $partido->save();
                return HttpResponses::partidoInsertadoOkResponse(
                    $partido->clave_consulta, $partido->clave_edicion,
                    $partido->id);
            } catch (\Exception $e) {
                return HttpResponses::insertadoErrorResponse('partido');
            }
        }
        return $partido;
    }

    public function getPartidoByClave(Request $request)
    {
        $claveConsulta = $request['clave_consulta'];
        $claveEdicion = $request['clave_edicion'];

        if(!$claveConsulta && !$claveEdicion) {

        }

        $campo = DB::table('campo as ca')
            ->join('partido as pa', function ($join) {
                $join->on('ca.id', '=', 'pa.campo_id');
            })
            ->select(['ca.id', 'ca.nombre', 'ca.par_hoyo_1', 'ca.par_hoyo_2',
                'ca.par_hoyo_3', 'ca.par_hoyo_4', 'ca.par_hoyo_5',
                'ca.par_hoyo_6', 'ca.par_hoyo_7', 'ca.par_hoyo_8',
                'ca.par_hoyo_9', 'ca.par_hoyo_10', 'ca.par_hoyo_11',
                'ca.par_hoyo_12', 'ca.par_hoyo_13', 'ca.par_hoyo_14',
                'ca.par_hoyo_15', 'ca.par_hoyo_16', 'ca.par_hoyo_17',
                'ca.par_hoyo_18', 'ca.par_hoyo_9', 'ca.ventaja_hoyo_1',
                'ca.ventaja_hoyo_2', 'ca.ventaja_hoyo_3', 'ca.ventaja_hoyo_4',
                'ca.ventaja_hoyo_5', 'ca.ventaja_hoyo_6', 'ca.ventaja_hoyo_7',
                'ca.ventaja_hoyo_8', 'ca.ventaja_hoyo_9', 'ca.ventaja_hoyo_10',
                'ca.ventaja_hoyo_11', 'ca.ventaja_hoyo_12', 'ca.ventaja_hoyo_13',
                'ca.ventaja_hoyo_14', 'ca.ventaja_hoyo_15', 'ca.ventaja_hoyo_16',
                'ca.ventaja_hoyo_17', 'ca.ventaja_hoyo_18', 'ca.owner_id'])
            ->where('pa.clave_consulta', '=', $request['clave_consulta'])
            ->orWhere('pa.clave_edicion', '=', $request['clave_edicion'])
            ->first();
        return response()->json($campo);

        return EntityByIdController::getPartidoById($request['partido_id']);
    }

    public function finalizarPartido(Request $request)
    {
        $partido = EntityByIdController::getPartidoById($request['partido_id']);
        if ($partido instanceof Partido) {
            if ($request['fin']) {
                $partido->fin = $request['fin'];
                try {
                    $partido->save();
                    return HttpResponses::actualizadoOkResponse('partido');
                } catch (\Exception $e) {
                    return HttpResponses::actualizadoErrorResponse('partido');
                }
            } else
                return HttpResponses::parametrosIncompletosReponse();
        }
    }

    public function destroy(Request $request)
    {
        $partido = $this->getPartidoById($request);
        if ($partido instanceof Partido) {
            $puntuacionesPartido = Puntuaciones::where('partido_id', '=',
                $request['partido_id']);
            $jugadoresPartido = JugadorPartido::where('partido_id', '=',
                $request['partido_id']);
            $apuestasPartido = ApuestaPartido::where('partido_id', '=',
                $request['partido_id']);
            DB::beginTransaction();
            try {
                $puntuacionesPartido->delete();
                $jugadoresPartido->delete();
                $apuestasPartido->delete();
                $partido->delete();
                DB::commit();
                return HttpResponses::partidoVaciadoOK();
            } catch (\Exception $e) {
                DB::rollBack();
                return HttpResponses::partidoVaciadoError();
            }
        }
        return $partido;
    }

    private function crearPartido(Request $request)
    {
        if ($request['partido_id']) {
            $partido = Partido::find($request['partido_id']);
            if (!$partido)
                return HttpResponses::noEncontradoResponse('partido');
        } else {
            $partido = new Partido();
            $claveController = new ClavePartidoController();
            $partido->clave_consulta = $claveController->obtenerClaveConsulta();
            $partido->clave_edicion = $claveController->obtenerClaveEdicion();
        }
        if ($request['inicio'])
            $partido->inicio = $request['inicio'];
        if ($request['fin'])
            $partido->fin = $request['fin'];
        if ($request['campo_id']) {
            $partido->campo_id = $request['campo_id'];
            $campo = Campo::find($partido->campo_id);
            if (!$campo)
                return HttpResponses::noEncontradoResponse('campo');
        }
        return $partido;
    }
}
