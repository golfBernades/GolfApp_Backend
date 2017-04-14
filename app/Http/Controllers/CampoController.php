<?php

namespace App\Http\Controllers;

use App\Http\Utils\FieldValidator;
use App\Http\Utils\HttpResponses;
use App\Models\Campo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CampoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campos = Campo::all();
        return response()->json($campos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $campo = $this->crearCampo($request);
        if ($campo instanceof Campo) {
            try {
                $campo->save();
                return HttpResponses::insertadoOkResponse('campo');
            } catch (\Exception $e) {
                return HttpResponses::insertadoErrorResponse('campo');
            }
        }
        $errorResponse = $campo;
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
            $campo = Campo::find($id);
            if (!$campo)
                return HttpResponses::noEncontradoResponse('campo');
            return response()->json($campo);
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
            $campo = $this->crearCampo($request);
            if ($campo instanceof Campo) {
                try {
                    $campo->save();
                    return HttpResponses::actualizadoOkResponse('campo');
                } catch (\Exception $e) {
                    return HttpResponses::actualizadoErrorResponse('campo');
                }
            }
            $errorResponse = $campo;
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
            $campo = Campo::find($id);
            if ($campo) {
                try {
                    $campo->delete();
                    return HttpResponses::eliminadoOkResponse('campo');
                } catch (\Exception $e) {
                    return HttpResponses::eliminadoErrorResponse('campo');
                }
            } else {
                return HttpResponses::noEncontradoResponse('campo');
            }
        }
    }

    /**
     * Crea una instancia de Campo para un nuevo campo o un campo
     * existente a partir de los parámetros de la request.
     *
     * @param Request $request
     * @return Campo|\Illuminate\Http\JsonResponse|null
     */
    private function crearCampo(Request $request)
    {
        if (!$this->isCampoCompleto($request))
            return HttpResponses::parametrosIncompletosReponse();
        if ($request['id']) {
            $campo = Campo::find($request['id']);
            if (!$campo)
                return HttpResponses::noEncontradoResponse('campo');
        } else
            $campo = new Campo();
        if ($request['nombre']) $campo->nombre = $request['nombre'];
        if ($request['par_hoyo_1'])
            $campo->par_hoyo_1 = $request['par_hoyo_1'];
        if ($request['par_hoyo_2'])
            $campo->par_hoyo_2 = $request['par_hoyo_2'];
        if ($request['par_hoyo_3'])
            $campo->par_hoyo_3 = $request['par_hoyo_3'];
        if ($request['par_hoyo_4'])
            $campo->par_hoyo_4 = $request['par_hoyo_4'];
        if ($request['par_hoyo_5'])
            $campo->par_hoyo_5 = $request['par_hoyo_5'];
        if ($request['par_hoyo_6'])
            $campo->par_hoyo_6 = $request['par_hoyo_6'];
        if ($request['par_hoyo_7'])
            $campo->par_hoyo_7 = $request['par_hoyo_7'];
        if ($request['par_hoyo_8'])
            $campo->par_hoyo_8 = $request['par_hoyo_8'];
        if ($request['par_hoyo_9'])
            $campo->par_hoyo_9 = $request['par_hoyo_9'];
        if ($request['par_hoyo_10'])
            $campo->par_hoyo_10 = $request['par_hoyo_10'];
        if ($request['par_hoyo_11'])
            $campo->par_hoyo_11 = $request['par_hoyo_11'];
        if ($request['par_hoyo_12'])
            $campo->par_hoyo_12 = $request['par_hoyo_12'];
        if ($request['par_hoyo_13'])
            $campo->par_hoyo_13 = $request['par_hoyo_13'];
        if ($request['par_hoyo_14'])
            $campo->par_hoyo_14 = $request['par_hoyo_14'];
        if ($request['par_hoyo_15'])
            $campo->par_hoyo_15 = $request['par_hoyo_15'];
        if ($request['par_hoyo_16'])
            $campo->par_hoyo_16 = $request['par_hoyo_16'];
        if ($request['par_hoyo_17'])
            $campo->par_hoyo_17 = $request['par_hoyo_17'];
        if ($request['par_hoyo_18'])
            $campo->par_hoyo_18 = $request['par_hoyo_18'];
        if ($request['ventaja_hoyo_1'])
            $campo->ventaja_hoyo_1 = $request['ventaja_hoyo_1'];
        if ($request['ventaja_hoyo_2'])
            $campo->ventaja_hoyo_2 = $request['ventaja_hoyo_2'];
        if ($request['ventaja_hoyo_3'])
            $campo->ventaja_hoyo_3 = $request['ventaja_hoyo_3'];
        if ($request['ventaja_hoyo_4'])
            $campo->ventaja_hoyo_4 = $request['ventaja_hoyo_4'];
        if ($request['ventaja_hoyo_5'])
            $campo->ventaja_hoyo_5 = $request['ventaja_hoyo_5'];
        if ($request['ventaja_hoyo_6'])
            $campo->ventaja_hoyo_6 = $request['ventaja_hoyo_6'];
        if ($request['ventaja_hoyo_7'])
            $campo->ventaja_hoyo_7 = $request['ventaja_hoyo_7'];
        if ($request['ventaja_hoyo_8'])
            $campo->ventaja_hoyo_8 = $request['ventaja_hoyo_8'];
        if ($request['ventaja_hoyo_9'])
            $campo->ventaja_hoyo_9 = $request['ventaja_hoyo_9'];
        if ($request['ventaja_hoyo_10'])
            $campo->ventaja_hoyo_10 = $request['ventaja_hoyo_10'];
        if ($request['ventaja_hoyo_11'])
            $campo->ventaja_hoyo_11 = $request['ventaja_hoyo_11'];
        if ($request['ventaja_hoyo_12'])
            $campo->ventaja_hoyo_12 = $request['ventaja_hoyo_12'];
        if ($request['ventaja_hoyo_13'])
            $campo->ventaja_hoyo_13 = $request['ventaja_hoyo_13'];
        if ($request['ventaja_hoyo_14'])
            $campo->ventaja_hoyo_14 = $request['ventaja_hoyo_14'];
        if ($request['ventaja_hoyo_15'])
            $campo->ventaja_hoyo_15 = $request['ventaja_hoyo_15'];
        if ($request['ventaja_hoyo_16'])
            $campo->ventaja_hoyo_16 = $request['ventaja_hoyo_16'];
        if ($request['ventaja_hoyo_17'])
            $campo->ventaja_hoyo_17 = $request['ventaja_hoyo_17'];
        if ($request['ventaja_hoyo_18'])
            $campo->ventaja_hoyo_18 = $request['ventaja_hoyo_18'];
        return $campo;
    }

    /**
     * Determina si los parámetros obligatorios de un campo enviados en la
     * request están completos.
     *
     * @param Request $request
     * @return bool
     */
    private function isCampoCompleto(Request $request)
    {
        $nombre = $request['nombre'];
        $par_hoyo_1 = $request['par_hoyo_1'];
        $par_hoyo_2 = $request['par_hoyo_2'];
        $par_hoyo_3 = $request['par_hoyo_3'];
        $par_hoyo_4 = $request['par_hoyo_4'];
        $par_hoyo_5 = $request['par_hoyo_5'];
        $par_hoyo_6 = $request['par_hoyo_6'];
        $par_hoyo_7 = $request['par_hoyo_7'];
        $par_hoyo_8 = $request['par_hoyo_8'];
        $par_hoyo_9 = $request['par_hoyo_9'];
        $par_hoyo_10 = $request['par_hoyo_10'];
        $par_hoyo_11 = $request['par_hoyo_11'];
        $par_hoyo_12 = $request['par_hoyo_12'];
        $par_hoyo_13 = $request['par_hoyo_13'];
        $par_hoyo_14 = $request['par_hoyo_14'];
        $par_hoyo_15 = $request['par_hoyo_15'];
        $par_hoyo_16 = $request['par_hoyo_16'];
        $par_hoyo_17 = $request['par_hoyo_17'];
        $par_hoyo_18 = $request['par_hoyo_18'];
        $ventaja_hoyo_1 = $request['ventaja_hoyo_1'];
        $ventaja_hoyo_2 = $request['ventaja_hoyo_2'];
        $ventaja_hoyo_3 = $request['ventaja_hoyo_3'];
        $ventaja_hoyo_4 = $request['ventaja_hoyo_4'];
        $ventaja_hoyo_5 = $request['ventaja_hoyo_5'];
        $ventaja_hoyo_6 = $request['ventaja_hoyo_6'];
        $ventaja_hoyo_7 = $request['ventaja_hoyo_7'];
        $ventaja_hoyo_8 = $request['ventaja_hoyo_8'];
        $ventaja_hoyo_9 = $request['ventaja_hoyo_9'];
        $ventaja_hoyo_10 = $request['ventaja_hoyo_10'];
        $ventaja_hoyo_11 = $request['ventaja_hoyo_11'];
        $ventaja_hoyo_12 = $request['ventaja_hoyo_12'];
        $ventaja_hoyo_13 = $request['ventaja_hoyo_13'];
        $ventaja_hoyo_14 = $request['ventaja_hoyo_14'];
        $ventaja_hoyo_15 = $request['ventaja_hoyo_15'];
        $ventaja_hoyo_16 = $request['ventaja_hoyo_16'];
        $ventaja_hoyo_17 = $request['ventaja_hoyo_17'];
        $ventaja_hoyo_18 = $request['ventaja_hoyo_18'];
        // Si es para una actualización, se verifica que al menos un
        // parámetro del usuario venga en la request.
        if ($request['id'])
            return $nombre || $par_hoyo_1 || $par_hoyo_2 || $par_hoyo_3
                || $par_hoyo_4 || $par_hoyo_5 || $par_hoyo_6 || $par_hoyo_7
                || $par_hoyo_8 || $par_hoyo_9 || $par_hoyo_10 || $par_hoyo_11
                || $par_hoyo_12 || $par_hoyo_13 || $par_hoyo_14 || $par_hoyo_15
                || $par_hoyo_16 || $par_hoyo_17 || $par_hoyo_18
                || $ventaja_hoyo_1 || $ventaja_hoyo_2 || $ventaja_hoyo_3
                || $ventaja_hoyo_4 || $ventaja_hoyo_5 || $ventaja_hoyo_6
                || $ventaja_hoyo_7 || $ventaja_hoyo_8 || $ventaja_hoyo_9
                || $ventaja_hoyo_10 || $ventaja_hoyo_11 || $ventaja_hoyo_12
                || $ventaja_hoyo_13 || $ventaja_hoyo_14 || $ventaja_hoyo_15
                || $ventaja_hoyo_16 || $ventaja_hoyo_17 || $ventaja_hoyo_18;
        // Si es para un usuario nuevo, deben venir en la request todos sus
        // parámetros.
        else
            return $nombre && $par_hoyo_1 && $par_hoyo_2 && $par_hoyo_3
                && $par_hoyo_4 && $par_hoyo_5 && $par_hoyo_6 && $par_hoyo_7
                && $par_hoyo_8 && $par_hoyo_9 && $par_hoyo_10 && $par_hoyo_11
                && $par_hoyo_12 && $par_hoyo_13 && $par_hoyo_14 && $par_hoyo_15
                && $par_hoyo_16 && $par_hoyo_17 && $par_hoyo_18
                && $ventaja_hoyo_1 && $ventaja_hoyo_2 && $ventaja_hoyo_3
                && $ventaja_hoyo_4 && $ventaja_hoyo_5 && $ventaja_hoyo_6
                && $ventaja_hoyo_7 && $ventaja_hoyo_8 && $ventaja_hoyo_9
                && $ventaja_hoyo_10 && $ventaja_hoyo_11 && $ventaja_hoyo_12
                && $ventaja_hoyo_13 && $ventaja_hoyo_14 && $ventaja_hoyo_15
                && $ventaja_hoyo_16 && $ventaja_hoyo_17 && $ventaja_hoyo_18;
    }
}
