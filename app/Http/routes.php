<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
--------------------------------------------------------------------------------
Rutas de los jugadores
--------------------------------------------------------------------------------
*/

Route::resource('jugador', 'JugadorController', ['except' => ['create', 'edit']]);
Route::post('update_jugador_password', 'JugadorController@cambiarPassword');

/*
--------------------------------------------------------------------------------
Rutas de los campos
--------------------------------------------------------------------------------
*/

Route::resource('campo', 'CampoController', ['except' => ['create', 'edit']]);

/*
--------------------------------------------------------------------------------
Rutas de las apuestas
--------------------------------------------------------------------------------
*/

Route::resource('apuesta', 'ApuestaController', ['except' => ['create',
    'edit']]);

/*
--------------------------------------------------------------------------------
Rutas de prueba
--------------------------------------------------------------------------------
*/

Route::group(['middleware' => 'login'], function () {
    Route::get('testautentication', function () {
        return "Autenticado";
    });
});