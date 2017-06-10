<?php

namespace App\Http\Controllers;

use App\Http\Utils\JsonResponses;
use App\Models\Jugador;
use Illuminate\Http\Request;

class JugadorController extends Controller
{
    public function getJugadoresInPartido(Request $request)
    {

    }

    public function store(Request $request)
    {
        $response = $this->crearJugador($request, true);

        if ($response instanceof Jugador) {
            $jugador = Jugador::find($request['jugador_id']);
            $insertado = true;
            $error_message = '';
            $insertadoId = -1;

            if ($jugador) {
                $insertado = false;
                $error_message = 'El jugador con el id especificado ya existe';
            } else {
                try {
                    $jugador = $response;
                    $jugador->save();
                    $insertadoId = Jugador::find($request['jugador_id'])->id;
                } catch (\Exception $e) {
                    $insertado = false;
                    $error_message = $e->getMessage();
                }
            }

            if ($insertado) {
                return JsonResponses::jsonResponse(200, [
                    'ok' => true,
                    'jugador_id' => $insertadoId
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
        $response = $this->crearJugador($request, false);

        if ($response instanceof Jugador) {
            $actualizado = true;
            $error_message = '';

            try {
                $jugador = $response;
                $jugador->save();
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

    private function crearJugador(Request $request, $modoNuevo)
    {
        if (!$this->isJugadorCompleto($request, $modoNuevo)) {
            return JsonResponses::parametrosIncompletosResponse(['jugador_id',
                'nombre', 'handicap']);
        }

        if ($modoNuevo) {
            $jugador = new Jugador();
            $jugador->id = $request['jugador_id'];
        } else {
            $jugador = Jugador::find($request['jugador_id']);
        }

        if ($request['nombre']) $jugador->nombre = $request['nombre'];
        if ($request['handicap']) $jugador->handicap = $request['handicap'];

        return $jugador;
    }

    private function isJugadorCompleto(Request $request, $modoNuevo)
    {
        $jugador_id = $request['jugador_id'];
        $nombre = $request['nombre'];
        $handicap = $request['handicap'];

        if (!$jugador_id) {
            return false;
        } else {
            if ($modoNuevo) {
                return $nombre && $handicap;
            } else {
                return $nombre || $handicap;
            }
        }
    }
}
