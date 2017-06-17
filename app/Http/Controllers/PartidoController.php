<?php

namespace App\Http\Controllers;

use App\Http\Utils\JsonResponses;
use App\Models\Partido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
                    'partido_id' => $partido->id,
                    'clave_edicion' => $partido->clave_edicion,
                    'clave_consulta' => $partido->clave_consulta
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

        if (!$inicio) {
            return JsonResponses::parametrosIncompletosResponse(['inicio']);
        }

        $partido = new Partido();
        $claveController = new ClavePartidoController();
        $partido->clave_consulta = $claveController->obtenerClaveConsulta();
        $partido->clave_edicion = $claveController->obtenerClaveEdicion();
        $partido->inicio = $inicio;

        if($request['fin']) $partido->fin = $request['fin'];
        if($request['tablero_json']) $partido->fin = $request['tablero_json'];

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


        DB::beginTransaction();
        try {
            $partido->delete();
            if (file_exists($partido->tablero_json)) {
                unlink($partido->tablero_json);
            }
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

    public function getTableroStatus(Request $request)
    {
        $clave_consulta = $request['clave_consulta'];

        if (!$clave_consulta) {
            return JsonResponses::parametrosIncompletosResponse(['clave_consulta']);
        }

        $partido = DB::table('partido')
            ->where('clave_consulta', '=', $clave_consulta)
            ->first();

        if (!$partido) {
            return JsonResponses::jsonResponse(200, [
                'ok' => false,
                'error_message' => 'No existe ningún partido con la clave '
                    . 'de consulta dada'
            ]);
        }

        $filename = 'tablero_' . sha1($partido->clave_edicion);

        try {
            $file = fopen($filename, 'r');
            $jsonString = fread($file, filesize($filename));
            fclose($file);
        } catch (\Exception $e) {
            return JsonResponses::jsonResponse(200, [
                'ok' => false,
                'error_message' => $e->getMessage()
            ]);
        }

        return JsonResponses::jsonResponse(200, [
            'ok' => true,
            'tablero' => json_decode($jsonString)
        ]);
    }

    public function writeTableroStatus(Request $request)
    {
        $partidoId = $request['partido_id'];
        $tableroJson = $request['tablero_json'];

        if (!$tableroJson) {
            return JsonResponses::parametrosIncompletosResponse(['tablero_json']);
        }

        $partido = Partido::find($partidoId);
        $filename = 'tablero_' . sha1($request['clave_edicion']);

        try {

            $file = fopen($filename, 'wb');
            fwrite($file, $tableroJson);
            fclose($file);
            $partido->tablero_json = $filename;
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

}
