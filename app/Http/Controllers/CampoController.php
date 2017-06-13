<?php

namespace App\Http\Controllers;

use App\Http\Utils\JsonResponses;
use App\Models\Campo;
use App\Models\ContadorIdCampo;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CampoController extends Controller
{
    public function store(Request $request)
    {
        $response = $this->crearCampo($request, true);

        if ($response instanceof Campo) {
            $campo = Campo::find($request['campo_id']);
            $insertado = true;
            $error_message = '';
            $insertadoId = -1;

            if ($campo) {
                $insertado = false;
                $error_message = 'El campo con el id especificado ya existe';
            } else {
                try {
                    $campo = $response;
                    $campo->save();
                    $insertadoId = Campo::find($request['campo_id'])->id;
                } catch (\Exception $e) {
                    $insertado = false;
                    $error_message = $e->getMessage();
                }
            }

            if ($insertado) {
                return JsonResponses::jsonResponse(200, [
                    'ok' => true,
                    'campo_id' => $insertadoId
                ]);
            } else {
                return JsonResponses::jsonResponse(200, [
                    'ok' => false,
                    'error_message' => $error_message
                ]);
            }
        }

        return $response;
    }

    public function update(Request $request)
    {
        $response = $this->crearCampo($request, false);

        if ($response instanceof Campo) {
            $actualizado = true;
            $error_message = '';

            try {
                $campo = $response;
                $campo->save();
            } catch (\Exception $e) {
                $actualizado = false;
                $error_message = $e->getMessage();
            }

            if ($actualizado) {
                return JsonResponses::jsonResponse(200, [
                    'ok' => true
                ]);
            } else {
                return JsonResponses::jsonResponse(200, [
                    'ok' => false,
                    'error_message' => $error_message
                ]);
            }
        }

        return $response;
    }

    public function destroy(Request $request)
    {
        $campo = Campo::find($request['campo_id']);

        try {
            $campo->delete();
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

    private function crearCampo(Request $request, $modoNuevo)
    {
        if (!$this->isCampoCompleto($request, $modoNuevo))
            return JsonResponses::parametrosIncompletosResponse([
                'campo_id', 'nombre', 'par_hoyo_1', 'par_hoyo_2', 'par_hoyo_3',
                'par_hoyo_4', 'par_hoyo_5', 'par_hoyo_6', 'par_hoyo_7',
                'par_hoyo_8', 'par_hoyo_9', 'par_hoyo_10', 'par_hoyo_11',
                'par_hoyo_12', 'par_hoyo_13', 'par_hoyo_14', 'par_hoyo_15',
                'par_hoyo_16', 'par_hoyo_17', 'par_hoyo_18', 'ventaja_hoyo_1',
                'ventaja_hoyo_2', 'ventaja_hoyo_3', 'ventaja_hoyo_4',
                'ventaja_hoyo_5', 'ventaja_hoyo_6', 'ventaja_hoyo_7',
                'ventaja_hoyo_8', 'ventaja_hoyo_9', 'ventaja_hoyo_10',
                'ventaja_hoyo_11', 'ventaja_hoyo_12', 'ventaja_hoyo_13',
                'ventaja_hoyo_14', 'ventaja_hoyo_15', 'ventaja_hoyo_16',
                'ventaja_hoyo_17', 'ventaja_hoyo_18', 'email', 'password'
            ]);

        if ($modoNuevo) {
            $campo = new Campo();
            $campo->id = $request['campo_id'];
        } else {
            // En modo de edición asumimos que el campo existe porque ya fue
            // validado en el middleware PropietarioCampoMiddleware
            $campo = Campo::find($request['campo_id']);
        }

        if ($request['nombre']) $campo->nombre = $request['nombre'];
        if ($request['email']) {
            $owner = Usuario::where('email', '=', $request['email'])->first();
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

    private function isCampoCompleto(Request $request, $modoNuevo)
    {
        $campo_id = $request['campo_id'];
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

        if (!$campo_id) return false;

        if ($modoNuevo) {
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
        } else {
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
        }
    }

    public function getCampoNextId(Request $request)
    {
        try {
            $nextId = new ContadorIdCampo();
            $nextId->save();
            return JsonResponses::jsonResponse(200, [
                'ok' => true,
                'next_id' => $nextId->id
            ]);
        } catch (\Exception $e) {
            return JsonResponses::jsonResponse(200, [
                'ok' => false,
                'error_message' => $e->getMessage()
            ]);
        }
    }

    public function getUserCampos(Request $request)
    {
        $usuarioId = $request['usuario_id'];

        if (!$usuarioId) {
            return JsonResponses::parametrosIncompletosResponse(['usuario_id']);
        }

        try {
            $campos = Campo::where('owner_id', '=', $usuarioId)->get();
            return JsonResponses::jsonResponse(200, [
                'ok' => true,
                'campos' => $campos
            ]);
        } catch (\Exception $e) {
            return JsonResponses::jsonResponse(200, [
                'ok' => false,
                'error_message' => $e->getMessage()
            ]);
        }
    }
}
