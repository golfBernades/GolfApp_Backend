<?php

namespace App\Http\Controllers;

use App\Http\Utils\JsonResponses;
use App\Models\ApuestaPartido;
use App\Models\JugadorPartido;
use App\Models\Partido;
use App\Models\Puntuaciones;
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

}
