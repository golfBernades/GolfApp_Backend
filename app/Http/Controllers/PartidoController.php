<?php

namespace App\Http\Controllers;

use App\Http\Utils\DateTimeOperations;
use App\Http\Utils\FieldValidator;
use App\Http\Utils\HttpResponses;
use App\Models\Campo;
use App\Models\Jugador;
use App\Models\Partido;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PartidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $partidos = Partido::all();
        return response()->json($partidos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
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
        $errorResponse = $partido;
        return $errorResponse;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $validation = FieldValidator::validateIntegerParameterURL($id);
        if ($validation instanceof JsonResponse) {
            return $validation;
        } else {
            $partido = Partido::find($id);
            if (!$partido)
                return HttpResponses::noEncontradoResponse('partido');
            return response()->json($partido);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validation = FieldValidator::validateIntegerParameterURL($id);
        if ($validation instanceof JsonResponse) {
            return $validation;
        } else {
            $request['id'] = $id;
            $partido = $this->crearPartido($request);
            if ($partido instanceof Partido) {
                try {
                    $partido->save();
                    return HttpResponses::actualizadoOkResponse('partido');
                } catch (\Exception $e) {
                    return HttpResponses::actualizadoErrorResponse('partido');
                }
            }
            $errorResponse = $partido;
            return $errorResponse;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $validation = FieldValidator::validateIntegerParameterURL($id);
        if ($validation instanceof JsonResponse) {
            return $validation;
        } else {
            $partido = Partido::find($id);
            if ($partido) {
                try {
                    $partido->delete();
                    return HttpResponses::eliminadoOkResponse('partido');
                } catch (\Exception $e) {
                    return HttpResponses::eliminadoErrorResponse('partido');
                }
            } else {
                return HttpResponses::noEncontradoResponse('partido');
            }
        }
    }

    /**
     * Crea una instancia de Partido para un nuevo partido o un partido
     * existente a partir de los parámetros de la request.
     *
     * @param Request $request
     * @return Partido|\Illuminate\Http\JsonResponse|null
     */
    private function crearPartido(Request $request)
    {
        if ($request['id']) {
            $partido = Partido::find($request['id']);
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
        $partidos = Partido::all();
        for ($i = 0; $i < count($partidos); $i++) {
            $now = date_create();
            $inicio = date_create($partidos[$i]->inicio);
            $diferencia = DateTimeOperations::getDifferenceInHours($now,
                $inicio);
            if ($diferencia > 24) {
                $apuestaPartidoController = new ApuestaPartidoController();
                $jugadorPartidoController = new JugadorPartidoController();
                $puntuacionesController = new PuntuacionesController();
                $partidoId = $partidos[$i]->id;
                DB::beginTransaction();
                $response = $jugadorPartidoController->vaciarPartido($partidoId);
                if ($response == HttpResponses::partidoVaciadoError()) {
                    DB::rollBack();
                    return $response;
                }
                $response = $apuestaPartidoController->vaciarPartido($partidoId);
                if ($response == HttpResponses::partidoVaciadoError()) {
                    DB::rollBack();
                    return $response;
                }
                $response = $puntuacionesController->vaciarPartido($partidoId);
                if ($response == HttpResponses::partidoVaciadoError()) {
                    DB::rollBack();
                    return $response;
                }
                DB::commit();
            }
        }
        return HttpResponses::partidosFinalizadosVaciadosOk();
    }
}
