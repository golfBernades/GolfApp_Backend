<?php

namespace App\Http\Controllers;

use App\Http\Utils\HttpResponses;
use App\Models\Campo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CampoController extends Controller
{
    public function index()
    {
        $campos = Campo::all();
        return response()->json($campos);
    }

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
        return $campo;
    }

    public function show(Request $request)
    {
        $id = $request['campo_id'];
        if (!$id) return HttpResponses::parametrosIncompletosReponse();
        return EntityByIdController::getCampoById($id);
    }

    public function update(Request $request)
    {
        $id = $request['campo_id'];
        if (!$id) return HttpResponses::parametrosIncompletosReponse();
        $campo = EntityByIdController::getCampoById($id);
        if ($campo instanceof JsonResponse) return $campo;
        $request['campo_id'] = $id;
        $campo = $this->crearCampo($request);
        if ($campo instanceof Campo) {
            try {
                $campo->save();
                return HttpResponses::actualizadoOkResponse('campo');
            } catch (\Exception $e) {
                return HttpResponses::actualizadoErrorResponse('campo');
            }
        }
        return $campo;
    }

    public function destroy(Request $request)
    {
        $id = $request['campo_id'];
        if (!$id) return HttpResponses::parametrosIncompletosReponse();
        $campo = EntityByIdController::getCampoById($id);
        if ($campo instanceof JsonResponse) return $campo;
        try {
            $campo->delete();
            return HttpResponses::eliminadoOkResponse('campo');
        } catch (\Exception $e) {
            return HttpResponses::eliminadoErrorResponse('campo');
        }
    }

    private function crearCampo(Request $request)
    {
        if (!$this->isCampoCompleto($request))
            return HttpResponses::parametrosIncompletosReponse();
        if ($request['campo_id']) {
            $campo = Campo::find($request['campo_id']);
            if (!$campo) return HttpResponses::noEncontradoResponse('campo');
        } else
            $campo = new Campo();
        if ($request['nombre']) $campo->nombre = $request['nombre'];
        if ($request['ciudad']) $campo->ciudad = $request['ciudad'];
        if ($request['owner_id']) {
            $campo->owner_id = $request['owner_id'];
            $owner = EntityByIdController::getJugadorById($request['owner_id']);
            if ($owner instanceof JsonResponse) return $owner;
        }
        if ($request['par_hoyo_1']) $campo->par_hoyo_1 = $request['par_hoyo_1'];
        if ($request['par_hoyo_2']) $campo->par_hoyo_2 = $request['par_hoyo_2'];
        if ($request['par_hoyo_3']) $campo->par_hoyo_3 = $request['par_hoyo_3'];
        if ($request['par_hoyo_4']) $campo->par_hoyo_4 = $request['par_hoyo_4'];
        if ($request['par_hoyo_5']) $campo->par_hoyo_5 = $request['par_hoyo_5'];
        if ($request['par_hoyo_6']) $campo->par_hoyo_6 = $request['par_hoyo_6'];
        if ($request['par_hoyo_7']) $campo->par_hoyo_7 = $request['par_hoyo_7'];
        if ($request['par_hoyo_8']) $campo->par_hoyo_8 = $request['par_hoyo_8'];
        if ($request['par_hoyo_9']) $campo->par_hoyo_9 = $request['par_hoyo_9'];
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

    private function isCampoCompleto(Request $request)
    {
        $nombre = $request['nombre'];
        $ciudad = $request['ciudad'];
        $ownerId = $request['owner_id'];
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
        if ($request['campo_id'])
            return $nombre || $ciudad || $ownerId || $par_hoyo_1 || $par_hoyo_2
                || $par_hoyo_3 || $par_hoyo_4 || $par_hoyo_5 || $par_hoyo_6
                || $par_hoyo_7 || $par_hoyo_8 || $par_hoyo_9 || $par_hoyo_10
                || $par_hoyo_11 || $par_hoyo_12 || $par_hoyo_13 || $par_hoyo_14
                || $par_hoyo_15 || $par_hoyo_16 || $par_hoyo_17 || $par_hoyo_18
                || $ventaja_hoyo_1 || $ventaja_hoyo_2 || $ventaja_hoyo_3
                || $ventaja_hoyo_4 || $ventaja_hoyo_5 || $ventaja_hoyo_6
                || $ventaja_hoyo_7 || $ventaja_hoyo_8 || $ventaja_hoyo_9
                || $ventaja_hoyo_10 || $ventaja_hoyo_11 || $ventaja_hoyo_12
                || $ventaja_hoyo_13 || $ventaja_hoyo_14 || $ventaja_hoyo_15
                || $ventaja_hoyo_16 || $ventaja_hoyo_17 || $ventaja_hoyo_18;
        // Si es para un usuario nuevo, deben venir en la request todos sus
        // parámetros.
        else
            return $nombre && $ciudad && $ownerId && $par_hoyo_1 && $par_hoyo_2
                && $par_hoyo_3 && $par_hoyo_4 && $par_hoyo_5 && $par_hoyo_6
                && $par_hoyo_7 && $par_hoyo_8 && $par_hoyo_9 && $par_hoyo_10
                && $par_hoyo_11 && $par_hoyo_12 && $par_hoyo_13 && $par_hoyo_14
                && $par_hoyo_15 && $par_hoyo_16 && $par_hoyo_17 && $par_hoyo_18
                && $ventaja_hoyo_1 && $ventaja_hoyo_2 && $ventaja_hoyo_3
                && $ventaja_hoyo_4 && $ventaja_hoyo_5 && $ventaja_hoyo_6
                && $ventaja_hoyo_7 && $ventaja_hoyo_8 && $ventaja_hoyo_9
                && $ventaja_hoyo_10 && $ventaja_hoyo_11 && $ventaja_hoyo_12
                && $ventaja_hoyo_13 && $ventaja_hoyo_14 && $ventaja_hoyo_15
                && $ventaja_hoyo_16 && $ventaja_hoyo_17 && $ventaja_hoyo_18;
    }
}
