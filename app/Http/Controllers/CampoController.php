<?php

namespace App\Http\Controllers;

use App\Http\Utils\HttpResponses;
use App\Models\Campo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CampoController extends Controller
{
    public function getCampoByClave(Request $request)
    {
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
    }

    public function store(Request $request)
    {
        $campo = $this->crearCampo($request);
        if ($campo instanceof Campo) {
            $existente = EntityByIdController::getCampoById($request['campo_id']);
            if ($existente instanceof Campo)
                return HttpResponses::insertadoErrorResponse('campo');
            try {
                $campo->save();
                $campo = EntityByIdController::getCampoById($request['campo_id']);
                return HttpResponses::insertadoOkResponse('campo', $campo->id);
            } catch (\Exception $e) {
                return HttpResponses::insertadoErrorResponse('campo');
            }
        }
        return $campo;
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
        $campo = Campo::find($request['campo_id']);
        if (!$campo) $campo = new Campo();
        $campo->id = $request['campo_id'];
        if ($request['nombre']) $campo->nombre = $request['nombre'];
        if ($request['email']) {
            $usuarioController = new UsuarioController();
            $owner = $usuarioController->getUsuarioByEmail($request);
            if ($owner instanceof JsonResponse) return $owner;
            $campo->owner_id = $owner->id;
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
        $campo_id = $request['campo_id'];

        echo 'campo_id: ' . $campo_id . '<br>';

        if ($campo_id) {
            if (Campo::find($campo_id)) {
                echo 'campos para actualización de campo <br>';
                return $nombre || $par_hoyo_1 || $par_hoyo_2
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
            } else {
                echo 'campos para inserción de campo <br>';
                return $nombre && $par_hoyo_1 && $par_hoyo_2
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
        } else
            return false;
    }
}
