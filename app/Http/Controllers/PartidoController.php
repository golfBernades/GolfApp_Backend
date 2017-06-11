<?php

namespace App\Http\Controllers;

use App\Http\Utils\DateTimeOperations;
use App\Http\Utils\FieldValidator;
use App\Http\Utils\HttpResponses;
use App\Http\Utils\JsonResponses;
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
        $response = $this->crearPartido($request);

        if ($response instanceof Partido) {
            try {
                $partido = $response;
                $partido->save();
                return JsonResponses::jsonResponse(200, [
                    'ok' => true,
                    'partido_id' => $partido->id
                ]);
            } catch (\Exception $e) {
                return JsonResponses::jsonResponse(200, [
                    'ok' => false,
                    'error_message' => $e->getMessage()
                ]);
            }
        }

        return $response;
    }

    private function crearPartido(Request $request)
    {
        $inicio = $request['inicio'];
        $campoId = $request['campo_id'];

        if (!$inicio) {
            return JsonResponses::parametrosIncompletosResponse(['inicio']);
        }

        $partido = new Partido();
        $claveController = new ClavePartidoController();
        $partido->clave_consulta = $claveController->obtenerClaveConsulta();
        $partido->clave_edicion = $claveController->obtenerClaveEdicion();
        $partido->inicio = $inicio;
        $partido->campo_id = $campoId;

        return $partido;
    }

    public function finalizarPartido(Request $request)
    {
        $fin = $request['fin'];

        if (!$fin) {
            return JsonResponses::parametrosIncompletosResponse(['fin']);
        }

        $partido = Partido::find($request['partido_id']);
        $partido->fin = $fin;

        try {
            $partido->save();
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

    public function destroy(Request $request)
    {
        $partidoId = $request['partido_id'];
        $partido = Partido::find($partidoId);
        $puntuaciones = Puntuaciones::where('partido_id', '=', $partidoId);
        $jugadores = JugadorPartido::where('partido_id', '=', $partidoId);
        $apuestas = ApuestaPartido::where('partido_id', '=', $partidoId);

        DB::beginTransaction();
        try {
            $puntuaciones->delete();
            $jugadores->delete();
            $apuestas->delete();
            $partido->delete();
            DB::commit();
            return JsonResponses::jsonResponse(200, [
                'ok' => true
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return JsonResponses::jsonResponse(200, [
                'ok' => false,
                'error_message' => $e->getMessage()
            ]);
        }
    }

    public function getPartidoByClave(Request $request)
    {
        $claveConsulta = $request['clave_consulta'];
        $claveEdicion = $request['clave_edicion'];

        if (!$claveConsulta && !$claveEdicion) {

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
}
