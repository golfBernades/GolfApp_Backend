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
    public function index()
    {
        $partidos = Partido::all();
        return response()->json($partidos);
    }

    public function store(Request $request)
    {
        $partido = $this->crearPartido($request);
        if ($partido instanceof Partido) {
            try {
                $partido->save();
                return HttpResponses::partidoInsertadoOkResponse(
                    $partido->clave_consulta, $partido->clave_edicion);
            } catch (\Exception $e) {
                return HttpResponses::insertadoErrorResponse('partido');
            }
        }
        return $partido;
    }

    public function getPartidoById(Request $request)
    {
        return EntityByIdController::getPartidoById($request['partido_id']);
    }

    public function update(Request $request)
    {
        $partido = $this->getPartidoById($request);
        if ($partido instanceof Partido) {
            $partido = $this->crearPartido($request);
            if ($partido instanceof Partido) {
                try {
                    $partido->save();
                    return HttpResponses::actualizadoOkResponse('partido');
                } catch (\Exception $e) {
                    return HttpResponses::actualizadoErrorResponse('partido');
                }
            }
        }
        return $partido;
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

    /**
     * Vacía los registros asociados a los partidos que tienen más de 24
     * horas de que finalizaron.
     *
     * @return JsonResponse|int
     */
    public function vaciarPartidosFinalizados()
    {
        $request = new Request();
        $contExito = 0;
        $contFallo = 0;
        $partidos = Partido::all();
        for ($i = 0; $i < count($partidos); $i++) {
            $now = date_create();
            $inicio = date_create($partidos[$i]->inicio);
            $diferencia = DateTimeOperations::getDifferenceInHours($now,
                $inicio);
            if ($diferencia > 24) {
                $request['partido_id'] = $partidos[$i]->id;
                $response = $this->destroy($request);
                if ($response == HttpResponses::partidoVaciadoOK())
                    $contExito++;
                else
                    $contFallo++;
            }
        }
        return HttpResponses::partidosFinalizadosVaciados($contExito,
            $contFallo);
    }
}
