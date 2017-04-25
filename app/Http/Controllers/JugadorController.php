<?php

namespace App\Http\Controllers;

use App\Http\Utils\HttpResponses;
use App\Models\Jugador;
use App\Models\JugadorPartido;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JugadorController extends Controller
{
    /**
     * Obtiene los jugadores que están participando en el partido al que se
     * tiene acceso.
     *
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAllJugador(Request $request)
    {
        $partidoId = $request['partido_id'];
        if (!$partidoId)
            return HttpResponses::parametrosIncompletosReponse();
        $partido = EntityByIdController::getPartidoById($partidoId);
        if ($partido instanceof JsonResponse) return $partido;
        $jugadoresEnPartido = DB::table('jugador as ju')
            ->join('jugador_partido as jp', function ($join) {
                $join->on('ju.id', '=', 'jp.jugador_id');
            })
            ->select(['ju.id', 'nombre', 'handicap'])
            ->where('partido_id', '=', $partidoId)
            ->get();
        return response()->json($jugadoresEnPartido);
    }

    /**
     * Obtiene el jugador con el id especificado, siempre y cuando esté
     * participando en el partido al que se tiene acceso.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getJugadorById(Request $request)
    {
        $jugadorId = $request['jugador_id'];
        $partidoId = $request['partido_id'];
        if (!$jugadorId || !$partidoId)
            return HttpResponses::parametrosIncompletosReponse();
        $jugadorPartido = JugadorPartido::where('jugador_id', '=', $jugadorId)
            ->where('partido_id', '=', $partidoId)->first();
        if (!$jugadorPartido) return HttpResponses::noEncontradoResponse('jugador');
        return Jugador::find($jugadorId);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $jugador = $this->crearJugador($request);
        if ($jugador instanceof Jugador) {
            try {
                $jugador->save();
                return HttpResponses::insertadoOkResponse('jugador');
            } catch (\Exception $e) {
                return HttpResponses::insertadoErrorResponse('jugador');
            }
        }
        return $jugador;
    }

    /**
     * Update the specified resource in storage.
     * @return Jugador|JsonResponse|null
     */
    public function update(Request $request)
    {
        $jugador = $this->getJugadorById($request);
        if ($jugador instanceof Jugador) {
            $jugador = $this->crearJugador($request);
            if ($jugador instanceof Jugador) {
                try {
                    $jugador->save();
                    return HttpResponses::actualizadoOkResponse('jugador');
                } catch (\Exception $e) {
                    return HttpResponses::actualizadoErrorResponse('jugador');
                }
            }
        }
        return $jugador;
    }

    /**
     * Crea una instancia de Jugador para un nuevo jugador o un jugador
     * existente a partir de los parámetros de la request.
     *
     * @param Request $request
     * @return Jugador|\Illuminate\Http\JsonResponse|null
     */
    private function crearJugador(Request $request)
    {
        if (!$this->isJugadorCompleto($request))
            return HttpResponses::parametrosIncompletosReponse();
        if ($request['jugador_id']) {
            $jugador = Jugador::find($request['jugador_id']);
            if (!$jugador)
                return HttpResponses::noEncontradoResponse('jugador');
        } else
            $jugador = new Jugador();
        if ($request['nombre'])
            $jugador->nombre = $request['nombre'];
        if ($request['handicap'])
            $jugador->handicap = $request['handicap'];
        return $jugador;
    }

    /**
     * Determina si los parámetros obligatorios de un jugador enviados en la
     * request están completos. Nota: Cuando se están verificando los
     * parámetros del usuario para una actualización, la contraseña no es
     * tomada en cuenta, para modificar la contraseña se usa el método
     * cambiarContraseña.
     *
     * @param Request $request
     * @return bool
     */
    private function isJugadorCompleto(Request $request)
    {
        $nombre = $request['nombre'];
        $handicap = $request['handicap'];
        if ($request['id']) return $nombre || $handicap;
        else return $nombre && $handicap;
    }
}
