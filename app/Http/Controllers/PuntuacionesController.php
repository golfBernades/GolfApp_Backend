<?php

namespace App\Http\Controllers;

use App\Http\Utils\FieldValidator;
use App\Http\Utils\JsonResponseParser;
use App\Models\Puntuaciones;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PuntuacionesController extends Controller
{
    public function getAllPuntuacionesJugador(Request $request)
    {
        $jugadorId = $request['jugador_id'];
        $partidoId = $request['partido_id'];
        if (!$jugadorId || !$partidoId)
            return HttpResponses::parametrosIncompletosReponse();
        $jugador = EntityByIdController::getJugadorById($jugadorId);
        if ($jugador instanceof JsonResponse) return $jugador;
        $partido = EntityByIdController::getPartidoById($partidoId);
        if ($partido instanceof JsonResponse) return $partido;
        $puntosJugadorPartido = Puntuaciones::where('jugador_id', '=',
            $jugadorId)
            ->where('partido_id', '=', $partidoId)
            ->get();
        return response()->json($puntosJugadorPartido);
    }

    public function getHoyoPuntuacionesJugador(Request $request)
    {
        $jugadorId = $request['jugador_id'];
        $partidoId = $request['partido_id'];
        $hoyo = $request['hoyo'];
        if (!$jugadorId || !$partidoId || !$hoyo)
            return HttpResponses::parametrosIncompletosReponse();
        $jugador = EntityByIdController::getJugadorById($jugadorId);
        if ($jugador instanceof JsonResponse) return $jugador;
        $partido = EntityByIdController::getPartidoById($partidoId);
        if ($partido instanceof JsonResponse) return $partido;
        $validation = FieldValidator::validateIntegerParameterURL($hoyo);
        if ($validation instanceof JsonResponse) return $validation;
        if ($hoyo < 1 || $hoyo > 18) return HttpResponses::hoyoRangoInvalido();
        $puntosJugadorPartidoHoyo = Puntuaciones::where('jugador_id', '=',
            $jugadorId)
            ->where('partido_id', '=', $partidoId)
            ->where('hoyo', '=', $hoyo)
            ->first();
        if (!$puntosJugadorPartidoHoyo)
            return HttpResponses::noPuntosJugadorPartidoHoyo();
        return response()->json($puntosJugadorPartidoHoyo);
    }

    public function registrarPuntuaciones(Request $request)
    {
        $puntuaciones = $this->crearPuntuaciones($request);
        if ($puntuaciones instanceof JsonResponse)
            return $puntuaciones;
        $existente = $puntuaciones->id;
        try {
            $puntuaciones->save();
            if ($existente)
                return HttpResponses::actualizadoOkResponse('puntuaciones');
            else
                return HttpResponses::insertadoOkResponse('puntuaciones');
        } catch (\Exception $e) {
            if ($existente)
                return HttpResponses::actualizadoErrorResponse('puntuaciones');
            else
                return HttpResponses::insertadoErrorResponse('puntuaciones');
        }
    }

    private function crearPuntuaciones(Request $request)
    {
        $jugadorId = $request['jugador_id'];
        $partidoId = $request['partido_id'];
        $hoyo = $request['hoyo'];
        $golpes = $request['golpes'];
        $unidades = $request['unidades'];
        if (!$jugadorId || !$partidoId || !$hoyo || !$golpes || !$unidades)
            return HttpResponses::parametrosIncompletosReponse();
        $jugador = EntityByIdController::getJugadorById($jugadorId);
        if ($jugador instanceof JsonResponse) return $jugador;
        $partido = EntityByIdController::getPartidoById($partidoId);
        if ($partido instanceof JsonResponse) return $partido;
        if ($hoyo < 1 || $hoyo > 18) return HttpResponses::hoyoRangoInvalido();
        if ($golpes < 0) return HttpResponses::golpesValorInvalido();
        if ($unidades < 0) return HttpResponses::unidadesValorInvalido();
        $puntuaciones = $this->getHoyoPuntuacionesJugador($request);
        $puntuacionesDecoded = JsonResponseParser::parse($puntuaciones);
        if (isset($puntuacionesDecoded->code) && $puntuacionesDecoded->code
            == 400
        )
            $puntuaciones = new Puntuaciones();
        else
            $puntuaciones = Puntuaciones::find($puntuacionesDecoded->id);
        $puntuaciones->jugador_id = $jugadorId;
        $puntuaciones->partido_id = $partidoId;
        $puntuaciones->hoyo = $hoyo;
        $puntuaciones->golpes = $golpes;
        $puntuaciones->unidades = $unidades;
        return $puntuaciones;
    }
}
