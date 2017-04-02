<?php

namespace App\Http\Controllers;

use App\Jugador;
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->json(['code' => 404,
            'message' => 'Ruta no implementada']);
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
            $jugador->save();
            return response()->json(['code' => 200,
                'message' => 'Jugador insertado']);
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
        $jugador = Jugador::find($id);
        if (!$jugador) {
            return response()->json(['code' => 400,
                'message' => 'Jugador no encontrado']);
        }
        return response()->json($jugador);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return response()->json(['code' => 404,
            'message' => 'Ruta no implementada']);
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
        $request['id'] = $id;
        $jugador = $this->crearJugador($request);
        if ($jugador instanceof Jugador) {
            $jugador->save();
            return response()->json(['code' => 200,
                'message' => 'Jugador actualizado']);
        }
        $errorResponse = $jugador;
        return $errorResponse;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $jugador = Jugador::find($id);
        if ($jugador) {
            $jugador->delete();
            return response()->json(['code' => 200,
                'message' => 'Jugador eliminado']);
        } else {
            return response()->json(['code' => 400,
                'message' => 'Jugador no encontrado']);
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
        if (!$this->isJugadorCompleto($request)) {
            return response()->json(['code' => 400,
                'message' => 'Parámetros incompletos']);
        }
        $jugador = null;
        if ($request['id']) {
            $jugador = Jugador::find($request['id']);
            if (!$jugador) {
                return response()->json(['code' => 400,
                    'message' => 'Jugador no encontrado']);
            }
        } else {
            $jugador = new Jugador();
        }
        $jugador->nombre = $request['nombre'];
        $jugador->apodo = $request['apodo'];
        $jugador->handicap = $request['handicap'];
        $jugador->sexo = $request['sexo'];
        $jugador->url_foto = $request['url_foto'];
        $jugador->password = $request['password'];
        $jugador->email = $request['email'];
        return $jugador;
    }

    /**
     * Determina si los parámetros obligatorios de un jugador enviados en la
     * request están completos.
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
        return $nombre && $apodo && $handicap && $sexo && $url_foto &&
            $password && $email;
    }
}
