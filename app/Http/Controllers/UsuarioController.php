<?php

namespace App\Http\Controllers;

use App\Http\Utils\HttpResponses;
use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function getUsuarioByEmail(Request $request)
    {
        $email = $request['email'];
        if (!$email) return HttpResponses::parametrosIncompletosReponse();
        $usuario = Usuario::where('email', '=', $email)->first();
        return $usuario;
    }

    public function login(Request $request)
    {
        $email = $request['email'];
        $password = $request['password'];
        if (!$email || !$password)
            return HttpResponses::parametrosIncompletosReponse();
        $usuario = $this->getUsuarioByEmail($request);
        if (!$usuario) return HttpResponses::noEncontradoResponse('usuario');
        if ($usuario->password == sha1($password))
            return HttpResponses::loginOkResponse();
        else return HttpResponses::loginErrorResponse();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
