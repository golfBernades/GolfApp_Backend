<?php

namespace App\Http\Controllers;

use App\Http\Utils\FieldValidator;
use App\Http\Utils\HttpResponses;
use App\Models\Jugador;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JugadorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jugadores = Jugador::all();
        return response()->json($jugadores);
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
        $errorResponse = $jugador;
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
            $jugador = Jugador::find($id);
            if (!$jugador)
                return HttpResponses::noEncontradoResponse('jugador');
            return response()->json($jugador);
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
            $jugador = $this->crearJugador($request);
            if ($jugador instanceof Jugador) {
                try {
                    $jugador->save();
                    return HttpResponses::actualizadoOkResponse('jugador');
                } catch (\Exception $e) {
                    return HttpResponses::actualizadoErrorResponse('jugador');
                }
            }
            $errorResponse = $jugador;
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
            $jugador = Jugador::find($id);
            if ($jugador) {
                try {
                    $jugador->delete();
                    return HttpResponses::eliminadoOkResponse('jugador');
                } catch (\Exception $e) {
                    return HttpResponses::eliminadoErrorResponse('jugador');
                }
            } else {
                return HttpResponses::noEncontradoResponse('jugador');
            }
        }
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
        if ($request['id']) {
            $jugador = Jugador::find($request['id']);
            if (!$jugador) {
                return HttpResponses::noEncontradoResponse('jugador');
            }
        } else {
            $jugador = new Jugador();
        }
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
        // Si es para una actualización, se verifica que al menos un
        // parámetro del usuario venga en la request.
        if ($request['id']) return $nombre || $handicap;
        // Si es para un usuario nuevo, deben venir en la request todos sus
        // parámetros.
        else return $nombre && $handicap;
    }
}
