<?php

namespace App\Http\Controllers;

use App\Http\Utils\FieldValidator;
use App\Http\Utils\HttpResponses;
use App\Models\Apuesta;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApuestaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apuestas = Apuesta::all();
        return response()->json($apuestas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $apuesta = $this->crearApuesta($request);
        if ($apuesta instanceof Apuesta) {
            try {
                $apuesta->save();
                return HttpResponses::insertadoOkResponse('apuesta');
            } catch (\Exception $e) {
                return HttpResponses::errorGuardadoResponse('apuesta');
            }
        }
        $errorResponse = $apuesta;
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
            $apuesta = Apuesta::find($id);
            if (!$apuesta)
                return HttpResponses::noEncontradoResponse('apuesta');
            return response()->json($apuesta);
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
            $apuesta = $this->crearApuesta($request);
            if ($apuesta instanceof Apuesta) {
                try {
                    $apuesta->save();
                    return HttpResponses::actualizadoOkResponse('apuesta');
                } catch (\Exception $e) {
                    return HttpResponses::errorGuardadoResponse('apuesta');
                }
            }
            $errorResponse = $apuesta;
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
            $apuesta = Apuesta::find($id);
            if ($apuesta) {
                try {
                    $apuesta->delete();
                    return HttpResponses::eliminadoOkResponse('apuesta');
                } catch (\Exception $e) {
                    return HttpResponses::errorEliminadoResponse('apuesta');
                }
            } else {
                return HttpResponses::noEncontradoResponse('apuesta');
            }
        }
    }

    /**
     * Crea una instancia de Apuesta para una nueva apuesta o una apuesta
     * existente a partir de los parámetros de la request.
     *
     * @param Request $request
     * @return Apuesta|\Illuminate\Http\JsonResponse|null
     */
    private function crearApuesta(Request $request)
    {
        if (!$request['nombre'])
            return HttpResponses::parametrosIncompletosReponse();
        if ($request['id']) {
            $apuesta = Apuesta::find($request['id']);
            if (!$apuesta)
                return HttpResponses::noEncontradoResponse('apuesta');
        } else
            $apuesta = new Apuesta();
        $apuesta->nombre = $request['nombre'];
        return $apuesta;
    }
}
