<?php

namespace App\Http\Controllers;

use App\Http\Utils\HttpResponses;
use App\Http\Utils\RegexValidator;
use App\Models\Campo;
use App\Models\Jugador;
use App\Models\Partido;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
                return HttpResponses::insertadoOkResponse('partido');
            } catch (\Exception $e) {
                return HttpResponses::errorGuardadoResponse('partido');
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
        $validation = $this->validatePartidoId($id);
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
        $validation = $this->validatePartidoId($id);
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
                    return HttpResponses::errorGuardadoResponse('partido');
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
        $validation = $this->validatePartidoId($id);
        if ($validation instanceof JsonResponse) {
            return $validation;
        } else {
            $partido = Partido::find($id);
            if ($partido) {
                try {
                    $partido->delete();
                    return HttpResponses::eliminadoOkResponse('partido');
                } catch (\Exception $e) {
                    return HttpResponses::errorEliminadoResponse('partido');
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
        if (!$this->isPartidoCompleto($request))
            return HttpResponses::parametrosIncompletosReponse();
        if ($request['id']) {
            $partido = Partido::find($request['id']);
            if (!$partido) {
                return HttpResponses::noEncontradoResponse('partido');
            }
        } else {
            $partido = new Partido();
        }
        if ($request['clave'])
            $partido->clave = $request['clave'];
        if ($request['inicio'])
            $partido->inicio = $request['inicio'];
        if ($request['fin'])
            $partido->fin = $request['fin'];
        if ($request['jugador_id'])
            $partido->jugador_id = $request['jugador_id'];
        $jugador = Jugador::find($partido->jugador_id);
        if (!$jugador)
            return HttpResponses::noEncontradoResponse('jugador');
        if ($request['campo_id'])
            $partido->campo_id = $request['campo_id'];
        $campo = Campo::find($partido->campo_id);
        if (!$campo)
            return HttpResponses::noEncontradoResponse('campo');
        return $partido;
    }

    /**
     * Determina si los parámetros obligatorios de un partido enviados en la
     * request están completos.
     *
     * @param Request $request
     * @return bool
     */
    private function isPartidoCompleto(Request $request)
    {
        $clave = $request['clave'];
        $inicio = $request['inicio'];
        $jugadorId = $request['jugador_id'];
        $campoId = $request['campo_id'];
        if ($request['id'])
            return $clave || $inicio || $jugadorId || $campoId;
        else
            return $clave && $inicio && $jugadorId && $campoId;
    }

    /**
     * Valida que el id del partido tenga el formato correcto
     * @param $id Es el id a evaluar
     * @return int 1 -> Si la validación es correcta, o JsonResponse -> Si la
     * validación es incorrecta, y esa response representa lo que debería
     * devolver el método que invoca a este validador.
     */
    private function validatePartidoId($id)
    {
        if (RegexValidator::isIntegerNumber($id)) {
            return 1;
        } else {
            return HttpResponses::rutaInexistenteResponse();
        }
    }
}
