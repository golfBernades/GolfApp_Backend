<?php

namespace App\Http\Controllers;

use App\Http\Utils\HttpResponses;
use App\Http\Utils\RegexValidator;
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
                return HttpResponses::errorGuardadoResponse('jugador');
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
        $validation = $this->validateJugadorId($id);
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
        $validation = $this->validateJugadorId($id);
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
                    return HttpResponses::errorGuardadoResponse('jugador');
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
        $validation = $this->validateJugadorId($id);
        if ($validation instanceof JsonResponse) {
            return $validation;
        } else {
            $jugador = Jugador::find($id);
            if ($jugador) {
                try {
                    $jugador->delete();
                    return HttpResponses::eliminadoOkResponse('jugador');
                } catch (\Exception $e) {
                    return HttpResponses::errorEliminadoResponse('jugador');
                }
            } else {
                return HttpResponses::noEncontradoResponse('jugador');
            }
        }
    }

    /**
     * Actualiza la contraseña del jugador con los datos enviados en la
     * request.
     * @param Request $request Contiene los datos del jugador a actualizar,
     * estos parámetros son:
     * jugadorId: El id del jugador a modificar.
     * oldPassword: La contraseña actual del jugador.
     * newPassword: La nueva contraseña.
     * @return JsonResponse
     */
    public function cambiarPassword(Request $request)
    {
        if (!$request['jugadorId'] || !$request['oldPassword']
            || !$request['newPassword']
        )
            return HttpResponses::parametrosIncompletosReponse();
        $jugador = Jugador::find($request['jugadorId']);
        if (!$jugador)
            return HttpResponses::noEncontradoResponse('jugador');
        if ($jugador->password != sha1($request['oldPassword']))
            return HttpResponses::passwordIncorrectaResponse();
        $jugador->password = sha1($request['newPassword']);
        try {
            $jugador->save();
            return HttpResponses::actualizadoOkResponse('jugador');
        } catch (\Exception $e) {
            return HttpResponses::errorGuardadoResponse('jugador');
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
            $jugador->password = sha1($request['password']);
        }
        if ($request['nombre'])
            $jugador->nombre = $request['nombre'];
        if ($request['apodo'])
            $jugador->apodo = $request['apodo'];
        if ($request['handicap'])
            $jugador->handicap = $request['handicap'];
        if ($request['sexo'])
            $jugador->sexo = $request['sexo'];
        if ($request['url_foto'])
            $jugador->url_foto = $request['url_foto'];
        if ($request['email'])
            $jugador->email = $request['email'];
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
        $apodo = $request['apodo'];
        $handicap = $request['handicap'];
        $sexo = $request['sexo'];
        $url_foto = $request['url_foto'];
        $password = $request['password'];
        $email = $request['email'];
        // Si es para una actualización, se verifica que al menos un
        // parámetro del usuario venga en la request.
        if ($request['id']) {
            return $nombre || $apodo || $handicap || $sexo || $url_foto ||
                $email;
        }
        // Si es para un usuario nuevo, deben venir en la request todos sus
        // parámetros.
        else {
            return $nombre && $apodo && $handicap && $sexo && $url_foto &&
                $password && $email;
        }
    }

    /**
     * Valida que el id del jugador tenga el formato correcto
     * @param $id Es el id a evaluar
     * @return int 1 -> Si la validación es correcta, o JsonResponse -> Si la
     * validación es incorrecta, y esa response representa lo que debería
     * devolver el método que invoca a este validador.
     */
    private function validateJugadorId($id)
    {
        if (RegexValidator::isIntegerNumber($id)) {
            return 1;
        } else {
            return HttpResponses::rutaInexistenteResponse();
        }
    }
}
